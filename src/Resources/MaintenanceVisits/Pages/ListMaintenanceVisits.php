<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\MaintenanceVisitResource;

class ListMaintenanceVisits extends ListRecords
{
    protected static string $resource = MaintenanceVisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
