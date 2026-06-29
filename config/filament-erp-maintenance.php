<?php

use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\MaintenanceScheduleResource;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\MaintenanceVisitResource;
use JeffersonGoncalves\FilamentErp\Maintenance\Widgets\MaintenanceStatsWidget;

return [

    /*
    |--------------------------------------------------------------------------
    | Navigation Group
    |--------------------------------------------------------------------------
    |
    | The navigation group under which all ERP maintenance resources are listed
    | in the Filament panel. Override per-plugin with ->navigationGroup('...').
    |
    */

    'navigation_group' => 'ERP — Maintenance',

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    |
    | The Filament resource classes registered by the plugin. Each entry can be
    | swapped for a custom resource extending the default one.
    |
    */

    'resources' => [
        'maintenance_schedule' => MaintenanceScheduleResource::class,
        'maintenance_visit' => MaintenanceVisitResource::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Widgets
    |--------------------------------------------------------------------------
    |
    | The Filament widgets registered by the plugin on the panel dashboard.
    |
    */

    'widgets' => [
        'maintenance_stats' => MaintenanceStatsWidget::class,
    ],

];
