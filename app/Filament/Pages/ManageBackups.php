<?php

namespace App\Filament\Pages;

use App\Services\BackupService;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class ManageBackups extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-server-stack';
    protected static ?string $navigationLabel = 'Backup Manager';
    protected static ?string $title = 'Backup & Restore Manager';
    protected static string|\UnitEnum|null $navigationGroup = 'Sistem';
    protected static ?int $navigationSort = 100;

    protected string $view = 'filament.pages.manage-backups';

    public array $backups = [];
    public array $stats = [
        'count' => 0,
        'size' => '0 B',
    ];

    public function mount()
    {
        $this->loadBackups();
    }

    public function loadBackups()
    {
        $service = new BackupService();
        $this->backups = $service->getBackups();
        
        $totalBytes = array_sum(array_column($this->backups, 'raw_size'));
        $this->stats = [
            'count' => count($this->backups),
            'size' => $this->formatBytes($totalBytes),
        ];
    }

    public function runBackup()
    {
        try {
            $service = new BackupService();
            $filename = $service->createBackup();

            Notification::make()
                ->title('Sukses!')
                ->body("File cadangan baru {$filename} berhasil dibuat.")
                ->success()
                ->send();

            $this->loadBackups();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal!')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function restoreBackup(string $filename)
    {
        try {
            $service = new BackupService();
            $service->restoreBackup($filename);

            Notification::make()
                ->title('Restorasi Sukses!')
                ->body("Database dan media berhasil dipulihkan dari {$filename}.")
                ->success()
                ->send();

            $this->loadBackups();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Restorasi Gagal!')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function downloadBackup(string $filename)
    {
        $filePath = storage_path('app/backups/' . $filename);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        Notification::make()
            ->title('Unduh Gagal')
            ->body('File tidak ditemukan di server.')
            ->danger()
            ->send();
    }

    public function deleteBackup(string $filename)
    {
        try {
            $service = new BackupService();
            $service->deleteBackup($filename);

            Notification::make()
                ->title('Hapus Sukses')
                ->body("File cadangan {$filename} berhasil dihapus.")
                ->success()
                ->send();

            $this->loadBackups();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal Hapus')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

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
