<div class="filament-hidden">

![Filament ERP Maintenance](https://raw.githubusercontent.com/jeffersongoncalves/filament-erp-maintenance/3.x/art/jeffersongoncalves-filament-erp-maintenance.png)

</div>

# Filament ERP Maintenance

Filament v5 panel resources for the [Laravel ERP maintenance module](https://github.com/jeffersongoncalves/laravel-erp-maintenance) — maintenance schedules and visits.

This package is the UI layer for the `jeffersongoncalves/laravel-erp-maintenance` domain package (namespace `JeffersonGoncalves\Erp\Maintenance\`). It wires the maintenance models into ready-to-use Filament resources, with Submit/Cancel actions and a schedule generator.

## Features

- **Maintenance schedules** — Schedules with item and detail relation managers, and a Generate Schedule action
- **Maintenance visits** — Visits with a purposes relation manager
- **Document lifecycle** — Submit/Cancel record actions wired to the domain `submit()` / `cancel()` methods
- **Dashboard widget** — `MaintenanceStatsWidget` with schedule and visit counts
- **Configurable** — Swap resource classes, change the navigation group or assign a cluster via config

## Compatibility

| Package | PHP | Filament | Laravel |
|---------|-----|----------|---------|
| `^3.0`  | `^8.2` | `^5.0` | `^11.0 \| ^12.0 \| ^13.0` |

## Installation

Install the package via Composer:

```bash
composer require jeffersongoncalves/filament-erp-maintenance
```

Register the plugin on a Filament panel:

```php
use JeffersonGoncalves\FilamentErp\Maintenance\FilamentErpMaintenancePlugin;

$panel->plugin(
    FilamentErpMaintenancePlugin::make()
        ->navigationGroup('ERP — Maintenance'),
);
```

## Resources

| Resource | Purpose |
|----------|---------|
| `MaintenanceScheduleResource` | Maintenance schedules (+ Items RM, Details RM, Submit/Cancel, Generate Schedule) |
| `MaintenanceVisitResource` | Maintenance visits (+ Purposes RM, Submit/Cancel) |

Transaction resources expose **Submit** and **Cancel** record actions that drive the domain document lifecycle. A maintenance schedule also exposes a **Generate Schedule** action that builds the periodic visit detail rows from its items.

## Widgets

| Widget | Purpose |
|--------|---------|
| `MaintenanceStatsWidget` | Schedule and visit counts |

## Configuration

Publish the config to swap resource classes, change the navigation group, or adjust widgets:

```bash
php artisan vendor:publish --tag="filament-erp-maintenance-config"
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Jefferson Simão Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
