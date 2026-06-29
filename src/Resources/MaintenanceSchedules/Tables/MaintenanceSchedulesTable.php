<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\Tables;

use Filament\Actions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Core\Enums\DocStatus;
use JeffersonGoncalves\FilamentErp\Core\Concerns\SubmittableRecordActions;
use JeffersonGoncalves\FilamentErp\Maintenance\Concerns\GeneratesMaintenanceSchedule;

class MaintenanceSchedulesTable
{
    use GeneratesMaintenanceSchedule;
    use SubmittableRecordActions;

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('party_id')
                    ->label('Party')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('transaction_date')
                    ->label('Transaction Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('docstatus')
                    ->label('Doc Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof DocStatus ? $state->name : $state)
                    ->color(fn ($state): string => match ($state) {
                        DocStatus::Draft => 'gray',
                        DocStatus::Submitted => 'success',
                        DocStatus::Cancelled => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('company.name')
                    ->label('Company')
                    ->toggleable()
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('docstatus')
                    ->label('Doc Status')
                    ->options([
                        0 => 'Draft',
                        1 => 'Submitted',
                        2 => 'Cancelled',
                    ]),
            ])
            ->recordActions([
                Actions\EditAction::make()
                    ->visible(fn ($record): bool => $record->docstatus === DocStatus::Draft),
                ...self::submittableRecordActions(),
                self::generateScheduleAction(),
                Actions\DeleteAction::make()
                    ->visible(fn ($record): bool => $record->docstatus === DocStatus::Draft),
            ]);
    }
}
