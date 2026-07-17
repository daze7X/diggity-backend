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
        return [
            Stat::make('Total Prospek (Leads)', Lead::count())
                ->description('Pesan masuk dari calon klien')
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

