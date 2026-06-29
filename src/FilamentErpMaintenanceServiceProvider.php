<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentErpMaintenanceServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-erp-maintenance';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasTranslations();
    }
}
