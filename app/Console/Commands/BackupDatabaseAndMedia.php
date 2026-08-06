<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use File;

class BackupDatabaseAndMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-database-and-media';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Melakukan backup database PostgreSQL dan folder media storage ke dalam satu berkas zip aman.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses backup...');

        // 1. Setup Direktori Backup
        $backupDir = storage_path('app/backups');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $timestamp = now()->format('Y-m-d_H-i-s');
        $tempSqlFile = $backupDir . DIRECTORY_SEPARATOR . "db-backup-{$timestamp}.sql";
        $finalZipFile = $backupDir . DIRECTORY_SEPARATOR . "backup-{$timestamp}.zip";

        // 2. Ekspor Database PostgreSQL menggunakan pg_dump
        $dbConfig = config('database.connections.pgsql');
        $host = $dbConfig['host'] ?? '127.0.0.1';
        $port = $dbConfig['port'] ?? '5432';
        $database = $dbConfig['database'] ?? '';
        $username = $dbConfig['username'] ?? '';
        $password = $dbConfig['password'] ?? '';

        if (empty($database) || empty($username)) {
            $this->error('Konfigurasi database PostgreSQL tidak lengkap.');
            return Command::FAILURE;
        }

        // Cari path pg_dump.exe di Windows jika perlu
        $pgDump = 'pg_dump';
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $paths = glob('C:/Program Files/PostgreSQL/*/bin/pg_dump.exe');
            if (!empty($paths)) {
                $pgDump = end($paths);
            }
        }

        $this->info("Menggunakan pg_dump: {$pgDump}");

        $cmd = [
            $pgDump,
            "--host={$host}",
            "--port={$port}",
            "--username={$username}",
            "--dbname={$database}",
            "--file={$tempSqlFile}"
        ];

        // Jalankan perintah dengan process
        $process = new Process($cmd);
        $process->setEnv(['PGPASSWORD' => $password]);
        $process->setTimeout(300); // 5 menit max

        $process->run();

        if (!$process->isSuccessful()) {
            $this->error('Gagal mengekspor database: ' . $process->getErrorOutput());
            if (File::exists($tempSqlFile)) {
                File::delete($tempSqlFile);
            }
            return Command::FAILURE;
        }

        $this->info('Database berhasil diekspor.');

        // 3. Kompresi Database SQL dan Media Storage ke dalam ZIP
        $zip = new ZipArchive();
        if ($zip->open($finalZipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // A. Tambahkan berkas SQL database
            $zip->addFile($tempSqlFile, 'db-backup.sql');

            // B. Tambahkan folder media storage (storage/app/public) jika ada
            $mediaDir = storage_path('app/public');
            if (File::exists($mediaDir)) {
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($mediaDir),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $name => $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        // Buat relative path di dalam ZIP agar terstruktur rapi di bawah folder "media/"
                        $relativePath = 'media/' . substr($filePath, strlen($mediaDir) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }
            }

            $zip->close();
            $this->info("Berkas backup berhasil dibuat: " . basename($finalZipFile));
        } else {
            $this->error('Gagal membuat berkas ZIP backup.');
            if (File::exists($tempSqlFile)) {
                File::delete($tempSqlFile);
            }
            return Command::FAILURE;
        }

        // Hapus berkas SQL sementara setelah berhasil dimasukkan ke ZIP
        if (File::exists($tempSqlFile)) {
            File::delete($tempSqlFile);
        }

        // 4. Pruning / Pembersihan Otomatis (Simpan hanya 7 backup terakhir)
        $this->pruneOldBackups($backupDir);

        $this->info('Proses backup selesai dengan sukses!');
        return Command::SUCCESS;
    }

    /**
     * Membatasi jumlah file backup agar tidak memenuhi kapasitas disk.
     */
    protected function pruneOldBackups($dir)
    {
        $files = File::glob($dir . DIRECTORY_SEPARATOR . 'backup-*.zip');
        
        if (count($files) > 7) {
            // Urutkan berdasarkan waktu modifikasi tertua ke terbaru
            usort($files, function ($a, $b) {
                return File::lastModified($a) <=> File::lastModified($b);
            });

            // Hitung berapa file yang harus dihapus
            $filesToDelete = count($files) - 7;
            for ($i = 0; $i < $filesToDelete; $i++) {
                File::delete($files[$i]);
                $this->info('Menghapus backup lama untuk menghemat kapasitas disk: ' . basename($files[$i]));
            }
        }
    }
}
