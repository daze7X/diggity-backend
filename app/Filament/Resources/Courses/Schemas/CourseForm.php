<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    Section::make('General Information')->schema([
                        TextInput::make('title')->required(),
                        TextInput::make('slug')->required(),
                        Select::make('type')->options([
                            'online_course' => 'Online Course',
                            'bootcamp' => 'Bootcamp',
                            'learning_path' => 'Learning Path',
                            'e_book' => 'E-Book / Digital Product',
                            'webinar' => 'Webinar / Seminar',
                            'workshop' => 'Workshop / Event',
                            'corporate_training' => 'Corporate Training',
                            'certification' => 'Professional Certification',
                            'scholarship' => 'CSR / Scholarship',
                        ])->default('online_course')->required(),
                        Select::make('category_id')
                            ->relationship('category', 'name', fn ($query) => $query->where('type', 'academy')),
                        Textarea::make('description')->columnSpanFull(),
                        Textarea::make('syllabus')->columnSpanFull(),
                        FileUpload::make('image')->image()->columnSpanFull(),
                    ])->columnSpan(2),

                    Section::make('Pricing & Stats')->schema([
                        TextInput::make('price')->required()->numeric()->default(0)->prefix('Rp'),
                        TextInput::make('original_price')->numeric()->prefix('Rp')->label('Discounted From'),
                        TextInput::make('duration')->label('Duration / Length (e.g., 24.5 Hours, 150 Pages, 3 Days)'),
                        TextInput::make('total_students')->numeric()->default(0),
                        TextInput::make('rating')->numeric()->inputMode('decimal')->step(0.1)->default(5.0),
                        TextInput::make('reviews_count')->numeric()->default(0),
                        TextInput::make('badge')->label('Badge (e.g., Best Seller)'),
                        Toggle::make('is_active')->default(true),
                        Toggle::make('is_featured')->default(false),
                    ])->columnSpan(1),
                ])->columnSpanFull(),

                Grid::make(2)->schema([
                    Section::make('Instructor / Author Details')->schema([
                        TextInput::make('instructor_name')->label('Name'),
                        TextInput::make('instructor_title')->label('Title / Role'),
                        Textarea::make('instructor_bio')->columnSpanFull()->label('Bio'),
                        FileUpload::make('instructor_avatar')->image()->avatar()->label('Avatar'),
                    ])->columnSpan(1),

                    Section::make('Course Features (Benefits)')->schema([
                        Repeater::make('benefits')
                            ->schema([
                                TextInput::make('feature')->required(),
                            ])
                            ->columnSpanFull()
                    ])->columnSpan(1),
                ])->columnSpanFull(),

                \App\Filament\Resources\Support\SeoForm::make(),
                \App\Filament\Resources\Support\TranslationForm::make([
                    'title' => 'text',
                    'description' => 'textarea',
                    'syllabus' => 'textarea',
                    'instructor_title' => 'text',
                    'instructor_bio' => 'textarea',
                ]),
            ]);
    }
}
