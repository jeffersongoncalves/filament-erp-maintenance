<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Maintenance\Support\ModelResolver;
use JeffersonGoncalves\FilamentErp\Maintenance\FilamentErpMaintenancePlugin;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\Pages\CreateMaintenanceVisit;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\Pages\EditMaintenanceVisit;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\Pages\ListMaintenanceVisits;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\RelationManagers\PurposesRelationManager;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\Schemas\MaintenanceVisitForm;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\Tables\MaintenanceVisitsTable;

class MaintenanceVisitResource extends Resource
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'customer_name';

    public static function getModel(): string
    {
        return ModelResolver::maintenanceVisit();
    }

    public static function getNavigationGroup(): ?string
    {
        try {
            return FilamentErpMaintenancePlugin::get()->getNavigationGroup();
        } catch (\Throwable) {
            return config('filament-erp-maintenance.navigation_group', 'ERP — Maintenance');
        }
    }

    public static function form(Schema $schema): Schema
    {
        return MaintenanceVisitForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaintenanceVisitsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PurposesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMaintenanceVisits::route('/'),
            'create' => CreateMaintenanceVisit::route('/create'),
            'edit' => EditMaintenanceVisit::route('/{record}/edit'),
        ];
    }
}
