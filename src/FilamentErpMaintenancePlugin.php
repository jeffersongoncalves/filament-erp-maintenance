<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance;

use Filament\Contracts\Plugin;
use Filament\Panel;
use JeffersonGoncalves\FilamentErp\Maintenance\Concerns\HasErpMaintenancePluginConfig;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\MaintenanceScheduleResource;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\MaintenanceVisitResource;

class FilamentErpMaintenancePlugin implements Plugin
{
    use HasErpMaintenancePluginConfig;

    public function getId(): string
    {
        return 'filament-erp-maintenance';
    }

    public function register(Panel $panel): void
    {
        $panel->resources($this->resolveResources([
            'maintenance_schedule' => MaintenanceScheduleResource::class,
            'maintenance_visit' => MaintenanceVisitResource::class,
        ]));

        $panel->widgets($this->resolveWidgets());
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
