<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Lead;

class VisitorsChart extends ChartWidget
{
    protected ?string $heading = 'Statistik Pengunjung (Visitors & Pageviews)';

    protected static ?int $sort = 2; // Urutan tampilan widget

    protected function getData(): array
    {
        $labels = [];
        $visitorsData = [];
        $pageviewsData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('d M');

            // Hitung total pageviews di hari tersebut
            $pageviews = \App\Models\PageView::whereDate('created_at', $date->toDateString())->count();

            // Hitung unique visitors di hari tersebut
            $visitors = \App\Models\PageView::whereDate('created_at', $date->toDateString())
                ->distinct('ip_address')
                ->count();

            $pageviewsData[] = $pageviews;
            $visitorsData[] = $visitors;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Unique Visitors',
                    'data' => $visitorsData,
                    'borderColor' => '#3b82f6', // Warna Biru
                    'backgroundColor' => 'rgba(59, 130, 246, 0.05)',
                    'fill' => 'start',
                ],
                [
                    'label' => 'Pageviews',
                    'data' => $pageviewsData,
                    'borderColor' => '#10b981', // Warna Hijau
                    'backgroundColor' => 'rgba(16, 185, 129, 0.05)',
                    'fill' => 'start',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

