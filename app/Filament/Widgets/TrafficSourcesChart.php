<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class TrafficSourcesChart extends ChartWidget
{
    protected ?string $heading = 'Sumber Lalu Lintas (Traffic Sources)';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Persentase Kunjungan',
                    'data' => [45, 25, 15, 10, 5],
                    'backgroundColor' => [
                        '#3b82f6', // Organic Search - Blue
                        '#10b981', // Direct - Green
                        '#fbbf24', // Social Media - Yellow
                        '#f43f5e', // Referrals - Rose
                        '#8b5cf6', // Paid Ads - Purple
                    ],
                ],
            ],
            'labels' => ['Organic Search', 'Direct', 'Social Media', 'Referrals', 'Paid Ads'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

