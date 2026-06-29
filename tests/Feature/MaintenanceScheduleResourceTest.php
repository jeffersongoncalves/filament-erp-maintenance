<?php

use JeffersonGoncalves\Erp\Core\Enums\DocStatus;
use JeffersonGoncalves\Erp\Core\Models\Company;
use JeffersonGoncalves\Erp\Maintenance\Models\MaintenanceSchedule;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\Pages\CreateMaintenanceSchedule;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\Pages\EditMaintenanceSchedule;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\Pages\ListMaintenanceSchedules;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceSchedules\RelationManagers\ItemsRelationManager;
use Livewire\Livewire;

beforeEach(function () {
    filament()->setCurrentPanel(filament()->getPanel('admin'));

    $this->company = Company::factory()->create();
});

function makeSchedule(): MaintenanceSchedule
{
    return MaintenanceSchedule::factory()->create([
        'customer_name' => 'Acme Co',
        'company_id' => test()->company->id,
        'transaction_date' => '2024-01-01',
    ]);
}

it('can render the maintenance schedule list page', function () {
    Livewire::test(ListMaintenanceSchedules::class)->assertSuccessful();
});

it('can render the maintenance schedule create page', function () {
    Livewire::test(CreateMaintenanceSchedule::class)->assertSuccessful();
});

it('can render the maintenance schedule edit page', function () {
    $schedule = makeSchedule();

    Livewire::test(EditMaintenanceSchedule::class, ['record' => $schedule->getRouteKey()])
        ->assertSuccessful();
});

it('can create a maintenance schedule through the form', function () {
    Livewire::test(CreateMaintenanceSchedule::class)
        ->fillForm([
            'customer_name' => 'Globex',
            'company_id' => $this->company->id,
            'transaction_date' => '2024-02-01',
            'status' => 'Draft',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(MaintenanceSchedule::query()->where('customer_name', 'Globex')->exists())->toBeTrue();
});

it('can add a schedule item through the relation manager', function () {
    $schedule = makeSchedule();

    Livewire::test(ItemsRelationManager::class, [
        'ownerRecord' => $schedule,
        'pageClass' => EditMaintenanceSchedule::class,
    ])
        ->callTableAction('create', null, [
            'item_code' => 'AC-UNIT',
            'item_name' => 'Air Conditioner',
            'start_date' => '2024-01-01',
            'periodicity' => 'Monthly',
            'no_of_visits' => 3,
            'sales_person' => 'Jane',
        ])
        ->assertHasNoActionErrors();

    expect($schedule->items()->where('item_code', 'AC-UNIT')->exists())->toBeTrue();
});

it('submits a maintenance schedule through the UI and generates its visit details', function () {
    $schedule = makeSchedule();

    $schedule->items()->create([
        'item_code' => 'AC-UNIT',
        'start_date' => '2024-01-01',
        'periodicity' => 'Monthly',
        'no_of_visits' => 3,
    ]);

    Livewire::test(ListMaintenanceSchedules::class)
        ->callTableAction('submit', $schedule);

    $schedule->refresh();

    expect($schedule->docstatus)->toBe(DocStatus::Submitted)
        ->and($schedule->scheduleDetails)->toHaveCount(3);
});

it('regenerates visit details through the Generate Schedule action', function () {
    $schedule = makeSchedule();

    $schedule->items()->create([
        'item_code' => 'AC-UNIT',
        'start_date' => '2024-01-01',
        'periodicity' => 'Monthly',
        'no_of_visits' => 4,
    ]);

    Livewire::test(ListMaintenanceSchedules::class)
        ->callTableAction('generateSchedule', $schedule);

    expect($schedule->scheduleDetails()->count())->toBe(4);
});
