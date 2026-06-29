<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\Pages;

use Filament\Resources\Pages\CreateRecord;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\MaintenanceVisitResource;

class CreateMaintenanceVisit extends CreateRecord
{
    protected static string $resource = MaintenanceVisitResource::class;
}
