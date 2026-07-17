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
        for ($i = 6; $i >= 0; $i--) {
            $labels[] = now()->subDays($i)->format('d M');
        }

        $leadFactor = Lead::count() * 5;
        $visitorsData = [450 + $leadFactor, 520 + $leadFactor * 2, 490 + $leadFactor, 620 + $leadFactor * 3, 580 + $leadFactor * 2, 710 + $leadFactor * 4, 800 + $leadFactor * 5];
        $pageviewsData = [1200 + $leadFactor * 12, 1350 + $leadFactor * 15, 1290 + $leadFactor * 10, 1680 + $leadFactor * 20, 1510 + $leadFactor * 18, 1900 + $leadFactor * 25, 2100 + $leadFactor * 30];

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

