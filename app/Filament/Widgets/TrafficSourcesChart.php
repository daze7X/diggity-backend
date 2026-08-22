<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class TrafficSourcesChart extends ChartWidget
{
    protected ?string $heading = 'Sumber Lalu Lintas (Traffic Sources)';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $direct = 0;
        $organic = 0;
        $social = 0;
        $referral = 0;
        $ads = 0;

        $pageViews = \App\Models\PageView::all();

        foreach ($pageViews as $pv) {
            $ref = strtolower($pv->referrer ?? '');
            $url = strtolower($pv->url ?? '');

            // Klasifikasi kampanye iklan berbayar (Paid Ads)
            if (str_contains($url, 'gclid') || str_contains($url, 'fbclid') || str_contains($url, 'utm_medium=cpc')) {
                $ads++;
            }
            // Klasifikasi kunjungan langsung (Direct)
            elseif (empty($pv->referrer) || str_contains($ref, 'localhost') || str_contains($ref, 'diggity-frontend') || str_contains($ref, 'diggity.agency')) {
                $direct++;
            }
            // Klasifikasi mesin pencari (Organic Search)
            elseif (str_contains($ref, 'google') || str_contains($ref, 'bing') || str_contains($ref, 'yahoo') || str_contains($ref, 'duckduckgo')) {
                $organic++;
            }
            // Klasifikasi media sosial (Social Media)
            elseif (str_contains($ref, 'facebook') || str_contains($ref, 'instagram') || str_contains($ref, 'linkedin') || str_contains($ref, 'twitter') || str_contains($ref, 't.co') || str_contains($ref, 'tiktok')) {
                $social++;
            }
            // Klasifikasi rujukan lainnya (Referrals)
            else {
                $referral++;
            }
        }

        $data = $pageViews->count() > 0 
            ? [$organic, $direct, $social, $referral, $ads]
            : [0, 0, 0, 0, 0];

        return [
            'datasets' => [
                [
                    'label' => 'Total Kunjungan',
                    'data' => $data,
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

