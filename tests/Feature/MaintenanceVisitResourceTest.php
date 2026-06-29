<?php

use Filament\Actions\Testing\TestAction;
use JeffersonGoncalves\Erp\Core\Enums\DocStatus;
use JeffersonGoncalves\Erp\Core\Models\Company;
use JeffersonGoncalves\Erp\Maintenance\Enums\CompletionStatus;
use JeffersonGoncalves\Erp\Maintenance\Enums\MaintenanceType;
use JeffersonGoncalves\Erp\Maintenance\Models\MaintenanceVisit;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\Pages\CreateMaintenanceVisit;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\Pages\EditMaintenanceVisit;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\Pages\ListMaintenanceVisits;
use JeffersonGoncalves\FilamentErp\Maintenance\Resources\MaintenanceVisits\RelationManagers\PurposesRelationManager;
use Livewire\Livewire;

beforeEach(function () {
    filament()->setCurrentPanel(filament()->getPanel('admin'));

    $this->company = Company::factory()->create();
});

function makeVisit(): MaintenanceVisit
{
    return MaintenanceVisit::factory()->create([
        'customer_name' => 'Acme Co',
        'company_id' => test()->company->id,
        'mntc_date' => '2024-01-01',
        'maintenance_type' => MaintenanceType::Scheduled,
    ]);
}

it('can render the maintenance visit list page', function () {
    Livewire::test(ListMaintenanceVisits::class)->assertSuccessful();
});

it('can render the maintenance visit create page', function () {
    Livewire::test(CreateMaintenanceVisit::class)->assertSuccessful();
});

it('can render the maintenance visit edit page', function () {
    $visit = makeVisit();

    Livewire::test(EditMaintenanceVisit::class, ['record' => $visit->getRouteKey()])
        ->assertSuccessful();
});

it('can create a maintenance visit through the form', function () {
    Livewire::test(CreateMaintenanceVisit::class)
        ->fillForm([
            'customer_name' => 'Globex',
            'company_id' => $this->company->id,
            'mntc_date' => '2024-02-01',
            'maintenance_type' => MaintenanceType::Scheduled->value,
            'completion_status' => CompletionStatus::Pending->value,
            'status' => 'Draft',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(MaintenanceVisit::query()->where('customer_name', 'Globex')->exists())->toBeTrue();
});

it('adds a purpose through the relation manager and recomputes completion status', function () {
    $visit = makeVisit();

    Livewire::test(PurposesRelationManager::class, [
        'ownerRecord' => $visit,
        'pageClass' => EditMaintenanceVisit::class,
    ])
        ->callAction(TestAction::make('create')->table(), data: [
            'item_code' => 'PUMP-1',
            'purpose_type' => 'Maintenance',
            'description' => 'Inspect pump',
            'work_done' => 'Cleaned and serviced',
            'service_person' => 'Bob',
        ])
        ->assertHasNoActionErrors();

    $visit->refresh();

    expect($visit->purposes()->where('item_code', 'PUMP-1')->exists())->toBeTrue()
        ->and($visit->completion_status)->toBe(CompletionStatus::FullyCompleted);
});

it('submits a maintenance visit through the UI', function () {
    $visit = makeVisit();

    Livewire::test(ListMaintenanceVisits::class)
        ->callAction(TestAction::make('submit')->table($visit));

    expect($visit->refresh()->docstatus)->toBe(DocStatus::Submitted);
});
