<?php

namespace App\Filament\Resources\SupportTickets\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(auth()->id())
                    ->disabled()
                    ->dehydrated(true)
                    ->required(),
                Textarea::make('message')
                    ->label('Isi Pesan Balasan')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('message')
            ->defaultSort('created_at', 'asc')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Pengirim')
                    ->weight('bold')
                    ->searchable(),
                TextColumn::make('message')
                    ->label('Pesan')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dikirim Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Kirim Balasan Support')
                    ->mutateFormDataUsing(function (array $data): array {
                        $ticket = $this->getOwnerRecord();
                        if ($ticket->status === 'resolved' || $ticket->status === 'closed' || $ticket->status === 'open') {
                            $ticket->status = 'in_progress';
                            $ticket->save();
                        }
                        return $data;
                    }),
            ])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
