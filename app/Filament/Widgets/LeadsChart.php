<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend; // Jika belum install trend, kita pakai query manual sederhana dulu
use Illuminate\Support\Facades\DB;

class LeadsChart extends ChartWidget
{
    protected ?string $heading = 'Tren Pesan Masuk (Leads)';

    protected function getData(): array
    {
        // Mengambil data jumlah leads per bulan di tahun ini
        $data = collect(range(1, 12))->map(function ($month) {
            return Lead::whereMonth('created_at', $month)
                ->whereYear('created_at', date('Y'))
                ->count();
        })->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Leads Masuk',
                    'data' => $data,
                    'borderColor' => '#fbbf24', // Warna oranye/kuning khas Diggity
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

