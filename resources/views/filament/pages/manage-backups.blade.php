<x-filament-panels::page>
    <style>
        /* Custom Backup Manager Layouts */
        .backup-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        @media (min-width: 768px) {
            .backup-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        .backup-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
        :is(.dark) .backup-card {
            background-color: #1e293b;
            border-color: #334155;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
        }
        .backup-icon-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 0.5rem;
            flex-shrink: 0;
        }
        .backup-icon-primary {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }
        .backup-icon-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }
        .backup-stat-title {
            font-size: 0.875rem;
            font-weight: 500;
            color: #64748b;
        }
        :is(.dark) .backup-stat-title {
            color: #94a3b8;
        }
        .backup-stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            margin-top: 0.125rem;
        }
        :is(.dark) .backup-stat-value {
            color: #ffffff;
        }
        
        /* Table Styles */
        .backup-table-wrapper {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }
        :is(.dark) .backup-table-wrapper {
            background-color: #0f172a;
            border-color: #1e293b;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
        }
        .backup-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        .backup-table th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        :is(.dark) .backup-table th {
            background-color: #1e293b;
            color: #cbd5e1;
            border-bottom-color: #334155;
        }
        .backup-table td {
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        :is(.dark) .backup-table td {
            color: #cbd5e1;
            border-bottom-color: #1e293b;
        }
        .backup-table tr:last-child td {
            border-bottom: none;
        }
        .filename-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            max-width: 260px;
        }
        .filename-text {
            font-weight: 600;
            color: #0f172a;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        :is(.dark) .filename-text {
            color: #ffffff;
        }
        .action-buttons-group {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
        }
    </style>

    <!-- Stat Grid -->
    <div class="backup-grid">
        <!-- Stat: Count -->
        <div class="backup-card">
            <div class="backup-icon-wrapper backup-icon-primary">
                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                </svg>
            </div>
            <div>
                <p class="backup-stat-title">Jumlah Cadangan</p>
                <h4 class="backup-stat-value">{{ $stats['count'] }}</h4>
            </div>
        </div>

        <!-- Stat: Size -->
        <div class="backup-card">
            <div class="backup-icon-wrapper backup-icon-success">
                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <div>
                <p class="backup-stat-title">Total Ukuran Penyimpanan</p>
                <h4 class="backup-stat-value">{{ $stats['size'] }}</h4>
            </div>
        </div>
    </div>

    <!-- Trigger Button -->
    <div class="flex justify-end mb-6">
        <x-filament::button
            wire:click="runBackup"
            icon="heroicon-m-plus"
            size="lg"
            class="cursor-pointer"
        >
            Buat Cadangan Baru
        </x-filament::button>
    </div>

    <!-- Table List of Backups -->
    <div class="backup-table-wrapper">
        <table class="backup-table">
            <thead>
                <tr>
                    <th style="width: 40%">Nama Berkas</th>
                    <th style="width: 15%">Ukuran</th>
                    <th style="width: 20%">Waktu Pembuatan</th>
                    <th style="width: 25%; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($backups as $backup)
                    <tr>
                        <!-- Name Column -->
                        <td>
                            <div class="filename-container">
                                <svg style="width: 20px; height: 20px; flex-shrink: 0;" class="text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span class="filename-text" title="{{ $backup['filename'] }}">
                                    {{ $backup['filename'] }}
                                </span>
                            </div>
                        </td>
                        <!-- Size Column -->
                        <td>{{ $backup['size'] }}</td>
                        <!-- Created At Column -->
                        <td>{{ $backup['created_at'] }}</td>
                        <!-- Actions Column -->
                        <td>
                            <div class="action-buttons-group">
                                <!-- Download -->
                                <x-filament::button
                                    wire:click="downloadBackup('{{ $backup['filename'] }}')"
                                    color="gray"
                                    size="sm"
                                    icon="heroicon-m-arrow-down-tray"
                                    class="cursor-pointer inline-flex"
                                >
                                    Unduh
                                </x-filament::button>

                                <!-- Restore -->
                                <x-filament::button
                                    wire:click="restoreBackup('{{ $backup['filename'] }}')"
                                    color="success"
                                    size="sm"
                                    icon="heroicon-m-arrow-path"
                                    class="cursor-pointer inline-flex"
                                    wire:confirm="PERINGATAN: Memulihkan cadangan akan menimpa seluruh database dan file media saat ini! Apakah Anda yakin?"
                                >
                                    Pulihkan
                                </x-filament::button>

                                <!-- Delete -->
                                <x-filament::button
                                    wire:click="deleteBackup('{{ $backup['filename'] }}')"
                                    color="danger"
                                    size="sm"
                                    icon="heroicon-m-trash"
                                    class="cursor-pointer inline-flex"
                                    wire:confirm="Apakah Anda yakin ingin menghapus berkas cadangan ini?"
                                >
                                    Hapus
                                </x-filament::button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <!-- Empty State -->
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 3rem 1.5rem;">
                            <svg style="width: 48px; height: 48px; margin: 0 auto 0.75rem auto;" class="text-slate-300 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="font-semibold text-slate-900 dark:text-white">Belum Ada File Cadangan</p>
                            <p class="text-xs text-slate-400 mt-1">Silakan klik tombol di atas untuk membuat cadangan baru.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-filament-panels::page>
