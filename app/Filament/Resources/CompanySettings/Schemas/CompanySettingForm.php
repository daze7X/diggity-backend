<?php

namespace App\Filament\Resources\CompanySettings\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CompanySettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Settings')
                    ->tabs([
                        
                        Tab::make('Kontak & Media Sosial')
                            ->components([
                                TextInput::make('name')
                                    ->label('Nama Agensi')
                                    ->required(),

                                TextInput::make('email')
                                    ->label('Email Official')
                                    ->email(),

                                TextInput::make('whatsapp')
                                    ->label('Nomor WhatsApp')
                                    ->placeholder('Contoh: 628123456789'),

                                TextInput::make('instagram_url')
                                    ->label('URL Instagram')
                                    ->url(),

                                TextInput::make('linkedin_url')
                                    ->label('URL LinkedIn')
                                    ->url(),

                                Textarea::make('address')
                                    ->label('Alamat Kantor')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Legalitas Perusahaan')
                            ->components([
                                TextInput::make('company_pt_name')
                                    ->label('Nama Perusahaan (PT)')
                                    ->placeholder('Contoh: PT Diggity Digital Internasional'),

                                TextInput::make('company_nib')
                                    ->label('Nomor NIB')
                                    ->placeholder('Contoh: 9120304910243'),

                                TextInput::make('company_kbli')
                                    ->label('Klasifikasi KBLI')
                                    ->placeholder('Contoh: KBLI 62019 (Aktivitas Pemrograman Komputer Lainnya)'),
                            ]),

                        Tab::make('Filosofi & Partner')
                            ->components([
                                Textarea::make('philosophy_build')
                                    ->label('Filosofi - Build')
                                    ->rows(2)
                                    ->placeholder('Merancang produk software (web/mobile) berkinerja tinggi.'),

                                Textarea::make('philosophy_grow')
                                    ->label('Filosofi - Grow')
                                    ->rows(2)
                                    ->placeholder('Mendorong pertumbuhan pasar melalui SEO, periklanan, dan marketing media sosial.'),

                                Textarea::make('philosophy_scale')
                                    ->label('Filosofi - Scale')
                                    ->rows(2)
                                    ->placeholder('Menjamin keandalan infrastruktur cloud server dan kapasitas sistem yang stabil.'),

                                Textarea::make('philosophy_empower')
                                    ->label('Filosofi - Empower')
                                    ->rows(2)
                                    ->placeholder('Memberdayakan tim Anda melalui pelatihan dan transfer keahlian digital.'),

                                TagsInput::make('partner_logos')
                                    ->label('Trusted By (Nama Partner)')
                                    ->placeholder('Tambahkan nama partner (tekan Enter)')
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Milestones Sejarah')
                            ->components([
                                Repeater::make('history_timeline')
                                    ->label('Timeline Sejarah Perusahaan')
                                    ->schema([
                                        TextInput::make('year')
                                            ->label('Tahun')
                                            ->required(),
                                        TextInput::make('title')
                                            ->label('Judul Milestone')
                                            ->required(),
                                        Textarea::make('desc')
                                            ->label('Deskripsi')
                                            ->rows(2)
                                            ->required(),
                                    ])
                                    ->grid(2)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
