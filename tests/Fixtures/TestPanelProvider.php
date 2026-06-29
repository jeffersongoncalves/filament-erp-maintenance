<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Tests\Fixtures;

use Filament\Panel;
use Filament\PanelProvider;
use JeffersonGoncalves\FilamentErp\Maintenance\FilamentErpMaintenancePlugin;

class TestPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->plugins([
                FilamentErpMaintenancePlugin::make(),
            ]);
    }
}
