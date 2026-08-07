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
                return \App\Models\PageView::query()
                    ->select(DB::raw('MIN(id) as id'), 'path', DB::raw('COUNT(*) as pageviews'), DB::raw('COUNT(DISTINCT ip_address) as visitors'))
                    ->groupBy('path')
                    ->orderBy('pageviews', 'desc');
            })
            ->columns([
                TextColumn::make('path')
                    ->label('Nama Halaman')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        '/' => 'Halaman Utama (Home)',
                        '/about' => 'Tentang Kami (About)',
                        '/services' => 'Solusi & Layanan (Solutions)',
                        '/products' => 'Produk Digital (Products)',
                        '/portfolio' => 'Portofolio (Portfolio)',
                        '/academy' => 'Akademi Digital (Academy)',
                        '/insights' => 'Artikel & Blog (Insights)',
                        '/contact' => 'Kontak Kami (Contact)',
                        '/job-connect' => 'Karir & Lowongan (Job Connect)',
                        '/login' => 'Halaman Masuk (Login)',
                        '/register' => 'Halaman Daftar (Register)',
                        default => $state
                    }),

                TextColumn::make('url')
                    ->label('URL Halaman')
                    ->state(fn ($record) => $record->path)
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

