<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\MaintenanceScheduleResource;

class EditMaintenanceSchedule extends EditRecord
{
    protected static string $resource = MaintenanceScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
