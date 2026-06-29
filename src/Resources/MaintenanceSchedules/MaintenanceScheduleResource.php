<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Maintenance\Support\ModelResolver;
use JeffersonGoncalves\FilamentErp\Maintenance\FilamentErpMaintenancePlugin;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\Pages\CreateMaintenanceSchedule;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\Pages\EditMaintenanceSchedule;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\Pages\ListMaintenanceSchedules;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\RelationManagers\DetailsRelationManager;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\RelationManagers\ItemsRelationManager;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\Schemas\MaintenanceScheduleForm;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\Tables\MaintenanceSchedulesTable;

class MaintenanceScheduleResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'customer_name';

    public static function getModel(): string
    {
        return ModelResolver::maintenanceSchedule();
    }

    public static function getNavigationGroup(): ?string
    {
        try {
            return FilamentErpMaintenancePlugin::get()->getNavigationGroup();
        } catch (\Throwable) {
            return config('filament-erp-maintenance.navigation_group', 'ERP — Maintenance');
        }
    }

    public static function form(Form $form): Form
    {
        return MaintenanceScheduleForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return MaintenanceSchedulesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
            DetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMaintenanceSchedules::route('/'),
            'create' => CreateMaintenanceSchedule::route('/create'),
            'edit' => EditMaintenanceSchedule::route('/{record}/edit'),
        ];
    }
}
