<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class BackupService
{
    protected string $backupDir;
    protected string $publicStoragePath;

    public function __construct()
    {
        $this->backupDir = storage_path('app/backups');
        $this->publicStoragePath = storage_path('app/public');
        
        // Ensure backup directory exists
        if (!File::exists($this->backupDir)) {
            File::makeDirectory($this->backupDir, 0755, true);
        }
    }

    /**
     * Get all backups with metadata
     */
    public function getBackups(): array
    {
        if (!File::exists($this->backupDir)) {
            return [];
        }

        $files = File::files($this->backupDir);
        $backups = [];

        foreach ($files as $file) {
            if ($file->getExtension() === 'zip') {
                $backups[] = [
                    'filename' => $file->getFilename(),
                    'size' => $this->formatBytes($file->getSize()),
                    'raw_size' => $file->getSize(),
                    'created_at' => date('Y-m-d H:i:s', $file->getMTime()),
                    'raw_time' => $file->getMTime(),
                ];
            }
        }

        // Sort by newest first
        usort($backups, fn($a, $b) => $b['raw_time'] <=> $a['raw_time']);

        return $backups;
    }

    /**
     * Create a new database & media backup zip file
     */
    public function createBackup(): string
    {
        $timestamp = date('Y-m-d-H-i-s');
        $zipName = "backup-{$timestamp}.zip";
        $zipPath = $this->backupDir . '/' . $zipName;

        // 1. Generate Database Dump
        $sqlDump = $this->generateSqlDump();
        $tempSqlPath = $this->backupDir . '/db_backup.sql';
        File::put($tempSqlPath, $sqlDump);

        // 2. Zip SQL Dump & Public Storage
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // Add database SQL file
            $zip->addFile($tempSqlPath, 'db_backup.sql');

            // Add media files recursively from storage/app/public
            if (File::exists($this->publicStoragePath)) {
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($this->publicStoragePath),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        // Create relative path inside zip starting with "media/"
                        $relativePath = 'media/' . substr($filePath, strlen($this->publicStoragePath) + 1);
                        $relativePath = str_replace('\\', '/', $relativePath); // Cross-platform slashes
                        $zip->addFile($filePath, $relativePath);
                    }
                }
            }
            $zip->close();
        }

        // 3. Clean up temp SQL file
        if (File::exists($tempSqlPath)) {
            File::delete($tempSqlPath);
        }

        return $zipName;
    }

    /**
     * Restore database & media from a backup zip file
     */
    public function restoreBackup(string $filename): void
    {
        $zipPath = $this->backupDir . '/' . $filename;

        if (!File::exists($zipPath)) {
            throw new \Exception("File backup {$filename} tidak ditemukan.");
        }

        $tempExtractDir = $this->backupDir . '/temp_restore';
        if (File::exists($tempExtractDir)) {
            File::deleteDirectory($tempExtractDir);
        }
        File::makeDirectory($tempExtractDir, 0755, true);

        // 1. Extract ZIP file
        $zip = new ZipArchive();
        if ($zip->open($zipPath) === true) {
            $zip->extractTo($tempExtractDir);
            $zip->close();
        } else {
            throw new \Exception("Gagal mengekstrak berkas backup zip.");
        }

        // 2. Restore Database SQL
        $sqlPath = $tempExtractDir . '/db_backup.sql';
        if (File::exists($sqlPath)) {
            $sqlContent = File::get($sqlPath);
            
            // Execute the raw SQL within a transaction for safety
            DB::transaction(function () use ($sqlContent) {
                DB::unprepared($sqlContent);
            });
        } else {
            File::deleteDirectory($tempExtractDir);
            throw new \Exception("File database (db_backup.sql) tidak ditemukan di dalam paket backup.");
        }

        // 3. Restore Media Public Storage
        $extractedMediaDir = $tempExtractDir . '/media';
        if (File::exists($this->publicStoragePath)) {
            File::cleanDirectory($this->publicStoragePath);
        } else {
            File::makeDirectory($this->publicStoragePath, 0755, true);
        }

        if (File::exists($extractedMediaDir)) {
            File::copyDirectory($extractedMediaDir, $this->publicStoragePath);
        }

        // 4. Clean up temp extraction folder
        File::deleteDirectory($tempExtractDir);
    }

    /**
     * Delete a backup file
     */
    public function deleteBackup(string $filename): void
    {
        $filePath = $this->backupDir . '/' . $filename;
        if (File::exists($filePath)) {
            File::delete($filePath);
        } else {
            throw new \Exception("File cadangan tidak ditemukan.");
        }
    }

    /**
     * Generate SQL script content representing database structure and rows
     */
    protected function generateSqlDump(): string
    {
        $connection = DB::connection();
        $sql = "-- Diggity Custom Database Backup Dump\n";
        $sql .= "-- Created at: " . date('Y-m-d H:i:s') . "\n\n";

        // Disable foreign keys and triggers for the session to prevent restore order conflicts
        $sql .= "SET session_replication_role = 'replica';\n\n";

        // Fetch all tables in public schema
        $tablesQuery = "SELECT table_name FROM information_schema.tables WHERE table_schema='public' AND table_type='BASE TABLE'";
        $tables = DB::select($tablesQuery);

        foreach ($tables as $tableRow) {
            $tableName = $tableRow->table_name;
            
            // Skip Laravel migrations table
            if ($tableName === 'migrations') {
                continue;
            }

            $sql .= "-- Table Data: \"{$tableName}\"\n";
            $sql .= "TRUNCATE TABLE \"{$tableName}\" CASCADE;\n";

            $rows = DB::table($tableName)->get();

            if ($rows->count() > 0) {
                $columns = array_keys((array)$rows[0]);
                $quotedColumns = array_map(fn($col) => "\"$col\"", $columns);
                $columnsStr = implode(', ', $quotedColumns);

                foreach ($rows as $row) {
                    $values = [];
                    foreach ($columns as $column) {
                        $val = $row->$column;
                        if (is_null($val)) {
                            $values[] = 'NULL';
                        } elseif (is_bool($val)) {
                            $values[] = $val ? 'true' : 'false';
                        } else {
                            // Escape text using PDO connection quote utility
                            $values[] = $connection->getPdo()->quote($val);
                        }
                    }
                    $valuesStr = implode(', ', $values);
                    $sql .= "INSERT INTO \"{$tableName}\" ({$columnsStr}) VALUES ({$valuesStr});\n";
                }
            }

            // Reset Postgres AUTO_INCREMENT sequence if table has "id" column
            if (Schema::hasColumn($tableName, 'id')) {
                $sql .= "SELECT setval(pg_get_serial_sequence('$tableName', 'id'), coalesce(max(id), 1), max(id) IS NOT null) FROM \"{$tableName}\";\n";
            }

            $sql .= "\n";
        }

        // Restore foreign keys and triggers back to default session role
        $sql .= "SET session_replication_role = 'origin';\n";

        return $sql;
    }

    /**
     * Helper to format bytes into readable units
     */
    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
