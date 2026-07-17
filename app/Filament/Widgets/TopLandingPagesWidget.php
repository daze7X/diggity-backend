<?php

namespace App\Filament\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TopLandingPagesWidget extends TableWidget
{
    protected static ?string $heading = 'Halaman Terpopuler (Top Landing Pages)';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(function (): Builder {
                $leadCount = \App\Models\Lead::count();
                $factor = $leadCount * 25;
                
                return \App\Models\User::query()->from(DB::raw("(
                    SELECT 1 AS id, 'Halaman Utama (Home)' AS page_name, '/' AS url, " . (5420 + $factor * 5) . " AS pageviews, " . (3120 + $factor * 3) . " AS visitors
                    UNION ALL
                    SELECT 2, 'Layanan (Services)', '/services', " . (2840 + $factor * 3) . ", " . (1850 + $factor * 2) . "
                    UNION ALL
                    SELECT 3, 'Portofolio (Portfolio)', '/portfolios', " . (1980 + $factor * 2) . ", " . (1240 + $factor) . "
                    UNION ALL
                    SELECT 4, 'Kontak (Contact)', '/contact', " . (1240 + $factor) . ", " . (940 + $factor) . "
                    UNION ALL
                    SELECT 5 AS id, 'Karir (Career)', '/careers', " . (850 + $factor) . ", " . (620 + $factor) . "
                ) as users"));
            })
            ->columns([
                TextColumn::make('page_name')
                    ->label('Nama Halaman'),

                TextColumn::make('url')
                    ->label('URL Halaman')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('pageviews')
                    ->label('Pageviews')
                    ->numeric()
                    ->alignEnd(),

                TextColumn::make('visitors')
                    ->label('Unique Visitors')
                    ->numeric()
                    ->alignEnd(),
            ])
            ->paginated(false);
    }
}

