<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\Lead;
use App\Models\Portfolio;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AgencyStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $leadsCount = Lead::count();
        // Simulasi jumlah pengunjung yang realistis
        $totalVisitors = 12840 + ($leadsCount * 15);
        $conversionRate = $totalVisitors > 0 ? number_format(($leadsCount / $totalVisitors) * 100, 2) : 0;

        return [
            Stat::make('Total Pengunjung (Visitors)', number_format($totalVisitors))
                ->description('Simulasi kunjungan unik website')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Tingkat Konversi', $conversionRate . '%')
                ->description('Rasio pengunjung menjadi Leads')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Prospek (Leads)', $leadsCount)
                ->description('Pesan masuk / submission form')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('success'),

            Stat::make('Total Portofolio', Portfolio::count())
                ->description('Project yang dipublikasikan')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('primary'),

            Stat::make('Artikel Blog', Blog::count())
                ->description('Total konten edukasi')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('warning'),
        ];
    }
}

