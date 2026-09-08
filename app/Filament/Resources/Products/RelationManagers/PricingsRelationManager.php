<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class PricingsRelationManager extends RelationManager
{
    protected static string $relationship = 'pricings';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Pricing Details')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Name (e.g. Starter, Premium)'),
                        
                        Select::make('pricing_type')
                            ->options([
                                'one_time' => 'One-Time Purchase',
                                'subscription' => 'Subscription',
                                'bundle' => 'Bundle',
                                'custom' => 'Custom / Enterprise',
                            ])
                            ->default('one_time')
                            ->required(),
                        
                        TextInput::make('price')
                            ->label('Display Price (String)')
                            ->placeholder('e.g. Rp 299.000 / Contact Us')
                            ->required(),
                            
                        TextInput::make('numeric_price')
                            ->label('Numeric Price (For Calculation)')
                            ->numeric()
                            ->prefix('IDR'),
                            
                        Select::make('period')
                            ->options([
                                'one_time' => 'One Time',
                                'month' => 'Monthly',
                                'year' => 'Yearly',
                                'project' => 'Per Project',
                            ])
                            ->default('month')
                            ->required(),
                            
                        Select::make('license_type')
                            ->options([
                                'personal' => 'Personal',
                                'commercial' => 'Commercial',
                                'extended' => 'Extended',
                                'agency' => 'Agency',
                            ])
                            ->label('License Type (Marketplace)'),
                    ]),
                ]),
                
                Section::make('Display & Marketing')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('pricing_label')
                            ->label('Badge Label')
                            ->placeholder('e.g. Most Popular, Best Value'),
                            
                        TextInput::make('cta_text')
                            ->label('Button CTA')
                            ->placeholder('e.g. Buy Now, Start Free Trial'),
                            
                        TextInput::make('discount_percentage')
                            ->numeric()
                            ->suffix('%')
                            ->label('Discount (%)'),
                            
                        Select::make('pricing_status')
                            ->options([
                                'active' => 'Active',
                                'draft' => 'Draft',
                                'promotional' => 'Promotional',
                                'deprecated' => 'Deprecated',
                                'archived' => 'Archived',
                            ])
                            ->default('active')
                            ->required(),
                    ]),
                    
                    Textarea::make('description')
                        ->rows(3)
                        ->maxLength(65535)
                        ->columnSpanFull(),
                        
                    Repeater::make('features')
                        ->simple(
                            TextInput::make('feature')->required()
                        )
                        ->columnSpanFull(),
                ]),
                
                Section::make('Flags')->schema([
                    Grid::make(4)->schema([
                        Toggle::make('is_popular')->label('Most Popular'),
                        Toggle::make('is_free_trial')->label('Free Trial'),
                        Toggle::make('is_enterprise')->label('Enterprise'),
                        Toggle::make('contact_sales')->label('Contact Sales'),
                    ])
                ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('pricing_type')->sortable(),
                TextColumn::make('price')->label('Display Price'),
                TextColumn::make('pricing_status')->badge()->sortable(),
                ToggleColumn::make('is_popular'),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
