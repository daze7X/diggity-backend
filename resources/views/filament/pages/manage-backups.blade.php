<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Stat: Backup Count -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-6 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-primary-500/10 text-primary-500 rounded-lg">
                <svg class="w-6 h-6" style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Jumlah Cadangan</p>
                <h4 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['count'] }}</h4>
            </div>
        </div>

        <!-- Stat: Total Storage Size -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-6 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-success-500/10 text-success-500 rounded-lg">
                <svg class="w-6 h-6" style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Ukuran Penyimpanan</p>
                <h4 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['size'] }}</h4>
            </div>
        </div>
    </div>

    <!-- Backup Action Trigger Button -->
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
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nama Berkas</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Ukuran</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Waktu Pembuatan</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                @forelse($backups as $backup)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                        <!-- Filename -->
                        <td class="px-6 py-4 text-sm font-semibold text-slate-900 dark:text-white">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-slate-400" style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span>{{ $backup['filename'] }}</span>
                            </div>
                        </td>
                        <!-- Size -->
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                            {{ $backup['size'] }}
                        </td>
                        <!-- Timestamp -->
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                            {{ $backup['created_at'] }}
                        </td>
                        <!-- Action Buttons -->
                        <td class="px-6 py-4 text-sm text-right space-x-2 whitespace-nowrap">
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
                        </td>
                    </tr>
                @empty
                    <!-- Empty State -->
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500 dark:text-slate-400">
                            <svg class="w-12 h-12 text-slate-300 dark:text-slate-700 mx-auto mb-3" style="width: 48px; height: 48px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
