<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Maintenance\Enums\MaintenanceVisitPurposeType;

class PurposesRelationManager extends RelationManager
{
    protected static string $relationship = 'purposes';

    protected static ?string $title = 'Purposes';

    public function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                TextInput::make('item_code')
                    ->label('Item Code')
                    ->maxLength(255),
                TextInput::make('serial_no')
                    ->label('Serial No')
                    ->maxLength(255),
                Select::make('purpose_type')
                    ->label('Purpose Type')
                    ->options(self::purposeTypeOptions())
                    ->default(MaintenanceVisitPurposeType::Maintenance->value)
                    ->required(),
                TextInput::make('service_person')
                    ->label('Service Person')
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull(),
                Textarea::make('work_done')
                    ->label('Work Done')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('item_code')
            ->columns([
                TextColumn::make('item_code')
                    ->label('Item Code')
                    ->searchable(),
                TextColumn::make('serial_no')
                    ->label('Serial No')
                    ->toggleable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(40)
                    ->toggleable(),
                TextColumn::make('work_done')
                    ->label('Work Done')
                    ->limit(40)
                    ->toggleable(),
                TextColumn::make('service_person')
                    ->label('Service Person')
                    ->toggleable(),
                TextColumn::make('purpose_type')
                    ->label('Purpose Type')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state instanceof MaintenanceVisitPurposeType ? $state->value : (string) $state),
            ])
            ->headerActions([
                Actions\CreateAction::make(),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }

    /** @return array<string, string> */
    protected static function purposeTypeOptions(): array
    {
        $options = [];

        foreach (MaintenanceVisitPurposeType::cases() as $case) {
            $options[$case->value] = $case->value;
        }

        return $options;
    }
}
