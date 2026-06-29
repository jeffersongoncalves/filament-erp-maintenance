<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Maintenance\Enums\CompletionStatus;

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'scheduleDetails';

    protected static ?string $title = 'Generated Visits';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('item_code')
            ->columns([
                TextColumn::make('item_code')
                    ->label('Item Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('scheduled_date')
                    ->label('Scheduled Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('completion_status')
                    ->label('Completion Status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state instanceof CompletionStatus ? $state->value : (string) $state)
                    ->color(fn ($state): string => match ($state) {
                        CompletionStatus::Pending => 'gray',
                        CompletionStatus::PartiallyCompleted => 'warning',
                        CompletionStatus::FullyCompleted => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('serial_no')
                    ->label('Serial No')
                    ->toggleable(),
                TextColumn::make('sales_person')
                    ->label('Sales Person')
                    ->toggleable(),
            ])
            ->defaultSort('scheduled_date');
    }
}
