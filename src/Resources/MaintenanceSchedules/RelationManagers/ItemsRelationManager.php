<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\RelationManagers;

use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Items';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('item_code')
                    ->label('Item Code')
                    ->required()
                    ->maxLength(255),
                TextInput::make('item_name')
                    ->label('Item Name')
                    ->maxLength(255),
                DatePicker::make('start_date')
                    ->label('Start Date'),
                DatePicker::make('end_date')
                    ->label('End Date'),
                Select::make('periodicity')
                    ->label('Periodicity')
                    ->options([
                        'Weekly' => 'Weekly',
                        'Monthly' => 'Monthly',
                        'Quarterly' => 'Quarterly',
                        'Yearly' => 'Yearly',
                    ])
                    ->default('Monthly')
                    ->required(),
                TextInput::make('no_of_visits')
                    ->label('No. of Visits')
                    ->numeric()
                    ->integer()
                    ->default(1)
                    ->minValue(1)
                    ->required(),
                TextInput::make('sales_person')
                    ->label('Sales Person')
                    ->maxLength(255),
                TextInput::make('serial_no')
                    ->label('Serial No')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('item_code')
            ->columns([
                TextColumn::make('item_code')
                    ->label('Item Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('item_name')
                    ->label('Item Name')
                    ->toggleable(),
                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('End Date')
                    ->date()
                    ->toggleable(),
                TextColumn::make('periodicity')
                    ->label('Periodicity')
                    ->badge(),
                TextColumn::make('no_of_visits')
                    ->label('Visits')
                    ->numeric(),
                TextColumn::make('sales_person')
                    ->label('Sales Person')
                    ->toggleable(),
                TextColumn::make('serial_no')
                    ->label('Serial No')
                    ->toggleable(),
            ])
            ->headerActions([
                Actions\CreateAction::make(),
            ])
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }
}
