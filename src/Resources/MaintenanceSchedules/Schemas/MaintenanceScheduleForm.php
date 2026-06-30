<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MaintenanceScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(null)
            ->components([
                Section::make('Details')
                    ->schema([
                        TextInput::make('customer_name')
                            ->label('Customer Name')
                            ->maxLength(255),
                        TextInput::make('party_id')
                            ->label('Party')
                            ->numeric()
                            ->integer()
                            ->nullable(),
                        DatePicker::make('transaction_date')
                            ->label('Transaction Date'),
                        TextInput::make('status')
                            ->label('Status')
                            ->default('Draft')
                            ->maxLength(255),
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ])->columns(2),
            ]);
    }
}
