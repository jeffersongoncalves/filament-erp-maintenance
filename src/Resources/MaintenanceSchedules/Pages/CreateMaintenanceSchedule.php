<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\Pages;

use Filament\Resources\Pages\CreateRecord;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\MaintenanceScheduleResource;

class CreateMaintenanceSchedule extends CreateRecord
{
    protected static string $resource = MaintenanceScheduleResource::class;
}
