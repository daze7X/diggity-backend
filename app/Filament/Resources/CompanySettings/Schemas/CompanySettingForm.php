<?php

namespace App\Filament\Resources\CompanySettings\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
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

                                TextInput::make('discord_url')
                                    ->label('URL Discord')
                                    ->url(),

                                TextInput::make('telegram_url')
                                    ->label('URL Telegram')
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

                                FileUpload::make('company_profile_pdf')
                                    ->label('Dokumen Company Profile (PDF)')
                                    ->directory('company_profiles')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Filosofi & Partner')
                            ->components([
                                Textarea::make('history_text_id')
                                    ->label('Teks Sejarah Singkat (Bahasa Indonesia)')
                                    ->rows(4),

                                

                                Textarea::make('philosophy_build')
                                    ->label('Filosofi - Build (ID)')
                                    ->rows(2)
                                    ->placeholder('Merancang produk software (web/mobile) berkinerja tinggi.'),

                                

                                Textarea::make('philosophy_grow')
                                    ->label('Filosofi - Grow (ID)')
                                    ->rows(2)
                                    ->placeholder('Mendorong pertumbuhan pasar melalui SEO, periklanan, dan marketing media sosial.'),

                                

                                Textarea::make('philosophy_scale')
                                    ->label('Filosofi - Scale (ID)')
                                    ->rows(2)
                                    ->placeholder('Menjamin keandalan infrastruktur cloud server dan kapasitas sistem yang stabil.'),

                                

                                Textarea::make('philosophy_empower')
                                    ->label('Filosofi - Empower (ID)')
                                    ->rows(2)
                                    ->placeholder('Memberdayakan tim Anda melalui pelatihan dan transfer keahlian digital.'),

                                

                                FileUpload::make('partner_logos')
                                    ->label('Trusted By (Logo Partner)')
                                    ->directory('partner_logos')
                                    ->multiple()
                                    ->image()
                                    ->reorderable()
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Visi & Misi')
                            ->components([
                                Textarea::make('vision_id')
                                    ->label('Visi (Bahasa Indonesia)')
                                    ->rows(3)
                                    ->placeholder('Menjadi mitra transformasi digital terdepan...')
                                    ->required(),

                                Textarea::make('vision_en')
                                    ->label('Vision (English)')
                                    ->rows(3)
                                    ->placeholder('To be the leading digital transformation partner...')
                                    ->required(),

                                Repeater::make('mission_id')
                                    ->label('Misi (Bahasa Indonesia)')
                                    ->schema([
                                        TextInput::make('text')
                                            ->label('Poin Misi')
                                            ->required()
                                    ])
                                    ->columnSpanFull(),

                                Repeater::make('mission_en')
                                    ->label('Mission (English)')
                                    ->schema([
                                        TextInput::make('text')
                                            ->label('Mission Point')
                                            ->required()
                                    ])
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

                \Filament\Schemas\Components\Section::make('English Translations (Lokalisasi EN)')
                    ->collapsed()
                    ->schema([
                        Textarea::make('en_history_text_id')->label('Sejarah Singkat (EN)')->rows(4),
                        Textarea::make('en_philosophy_build')->label('Filosofi - Build (EN)')->rows(2),
                        Textarea::make('en_philosophy_grow')->label('Filosofi - Grow (EN)')->rows(2),
                        Textarea::make('en_philosophy_scale')->label('Filosofi - Scale (EN)')->rows(2),
                        Textarea::make('en_philosophy_empower')->label('Filosofi - Empower (EN)')->rows(2),
                        Repeater::make('en_history_timeline')
                            ->label('Timeline Sejarah Perusahaan (EN)')
                            ->schema([
                                TextInput::make('year')
                                    ->label('Tahun'),
                                TextInput::make('title')
                                    ->label('Judul Milestone (EN)'),
                                Textarea::make('desc')
                                    ->label('Deskripsi (EN)')
                                    ->rows(2),
                            ])
                            ->grid(2)
                            ->columnSpanFull()
                            ->helperText('Kosongkan baris di sini jika ingin menggunakan Auto-Translate dari Milestones Sejarah di atas.'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}



