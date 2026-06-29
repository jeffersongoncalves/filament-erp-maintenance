<?php

it('loads the filament-erp-maintenance config file', function () {
    expect(config('filament-erp-maintenance'))->toBeArray();
});

it('has a default navigation group', function () {
    expect(config('filament-erp-maintenance.navigation_group'))->toBe('ERP — Maintenance');
});

it('registers all resources in config', function () {
    $resources = config('filament-erp-maintenance.resources');

    expect($resources)->toBeArray()
        ->toHaveKeys([
            'maintenance_schedule',
            'maintenance_visit',
        ]);
});

it('registers the dashboard widgets in config', function () {
    expect(config('filament-erp-maintenance.widgets'))->toBeArray()
        ->toHaveKeys(['maintenance_stats']);
});
