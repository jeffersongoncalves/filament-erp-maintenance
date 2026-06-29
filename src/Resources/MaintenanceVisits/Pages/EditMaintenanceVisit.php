<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\MaintenanceVisitResource;

class EditMaintenanceVisit extends EditRecord
{
    protected static string $resource = MaintenanceVisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
