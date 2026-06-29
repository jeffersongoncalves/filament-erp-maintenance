<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Tests;

use Composer\InstalledVersions;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use JeffersonGoncalves\Erp\Core\ErpCoreServiceProvider;
use JeffersonGoncalves\Erp\Maintenance\ErpMaintenanceServiceProvider;
use JeffersonGoncalves\FilamentErp\Core\Testing\InteractsWithErpFilament;
use JeffersonGoncalves\FilamentErp\Maintenance\FilamentErpMaintenanceServiceProvider;
use JeffersonGoncalves\FilamentErp\Maintenance\Tests\Fixtures\TestPanelProvider;
use JeffersonGoncalves\FilamentErp\Maintenance\Tests\Fixtures\TestUser;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use InteractsWithErpFilament;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rebindFilamentDataStore();

        // The domain factories ship in the vendored packages; resolve them by
        // basename across the Maintenance and Core packages in turn.
        Factory::guessFactoryNamesUsing($this->erpFactoryResolver([
            'JeffersonGoncalves\\Erp\\Maintenance\\Database\\Factories',
            'JeffersonGoncalves\\Erp\\Core\\Database\\Factories',
        ]));

        Filament::setCurrentPanel(Filament::getDefaultPanel());

        $this->withoutVite();

        $this->actingAs(TestUser::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]));
    }

    protected function getPackageProviders($app): array
    {
        return array_merge($this->filamentTestProviders(), [
            ErpCoreServiceProvider::class,
            ErpMaintenanceServiceProvider::class,
            FilamentErpMaintenanceServiceProvider::class,
            TestPanelProvider::class,
        ]);
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);

        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
        $app['config']->set('auth.providers.users.model', TestUser::class);

        $coreConfig = InstalledVersions::getInstallPath('jeffersongoncalves/laravel-erp-core').'/config/erp-core.php';

        if (file_exists($coreConfig)) {
            $app['config']->set('erp-core', require $coreConfig);
        }

        $maintenanceConfig = InstalledVersions::getInstallPath('jeffersongoncalves/laravel-erp-maintenance').'/config/erp-maintenance.php';

        if (file_exists($maintenanceConfig)) {
            $app['config']->set('erp-maintenance', require $maintenanceConfig);
        }
    }

    protected function defineDatabaseMigrations(): void
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->default('');
            $table->rememberToken();
        });

        $this->loadErpVendorMigrations([
            'core' => [
                'create_erp_companies_table',
                'create_erp_currencies_table',
                'create_erp_currency_exchanges_table',
                'create_erp_uoms_table',
                'create_erp_uom_conversions_table',
                'create_erp_fiscal_years_table',
                'create_erp_departments_table',
                'create_erp_designations_table',
                'create_erp_brands_table',
                'create_erp_terms_and_conditions_table',
                'create_erp_addresses_table',
                'create_erp_contacts_table',
                'create_erp_naming_series_table',
            ],
            'maintenance' => [
                'create_erp_maintenance_schedules_table',
                'create_erp_maintenance_schedule_items_table',
                'create_erp_maintenance_schedule_details_table',
                'create_erp_maintenance_visits_table',
                'create_erp_maintenance_visit_purposes_table',
            ],
        ]);
    }
}
