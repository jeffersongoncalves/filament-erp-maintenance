<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Concerns;

use JeffersonGoncalves\FilamentErp\Core\Concerns\HasErpPluginConfig;

trait HasErpMaintenancePluginConfig
{
    use HasErpPluginConfig;

    protected function getConfigKey(): string
    {
        return 'filament-erp-maintenance';
    }

    protected function getDefaultNavigationGroup(): string
    {
        return 'ERP — Maintenance';
    }
}
