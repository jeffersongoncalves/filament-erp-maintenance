<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\MaintenanceScheduleResource;

class ListMaintenanceSchedules extends ListRecords
{
    protected static string $resource = MaintenanceScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
