<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use JeffersonGoncalves\Erp\Maintenance\Enums\CompletionStatus;
use JeffersonGoncalves\Erp\Maintenance\Enums\MaintenanceType;

class MaintenanceVisitForm
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
                        Select::make('maintenance_schedule_id')
                            ->label('Maintenance Schedule')
                            ->relationship('maintenanceSchedule', 'customer_name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        DatePicker::make('mntc_date')
                            ->label('Maintenance Date'),
                        Select::make('maintenance_type')
                            ->label('Maintenance Type')
                            ->options(self::enumOptions(MaintenanceType::cases()))
                            ->default(MaintenanceType::Scheduled->value)
                            ->required(),
                        Select::make('completion_status')
                            ->label('Completion Status')
                            ->options(self::enumOptions(CompletionStatus::cases()))
                            ->default(CompletionStatus::Pending->value)
                            ->required(),
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

    /**
     * @param  array<int, \BackedEnum>  $cases
     * @return array<string, string>
     */
    protected static function enumOptions(array $cases): array
    {
        $options = [];

        foreach ($cases as $case) {
            /** @var string $value */
            $value = $case->value;
            $options[$value] = $value;
        }

        return $options;
    }
}
