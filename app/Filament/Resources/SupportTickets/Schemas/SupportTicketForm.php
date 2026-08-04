<?php

namespace App\Filament\Resources\SupportTickets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SupportTicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->disabled()
                    ->required(),
                TextInput::make('ticket_number')
                    ->disabled()
                    ->required(),
                TextInput::make('subject')
                    ->disabled()
                    ->required(),
                Select::make('category')
                    ->options([
                        'general' => 'General Inquiry',
                        'billing' => 'Billing & Payment',
                        'technical' => 'Technical Support',
                    ])
                    ->disabled()
                    ->required(),
                Select::make('status')
                    ->options([
                        'open' => 'Open',
                        'in_progress' => 'In Progress',
                        'resolved' => 'Resolved',
                        'closed' => 'Closed',
                    ])
                    ->required(),
                Select::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                    ])
                    ->required(),
            ]);
    }
}
