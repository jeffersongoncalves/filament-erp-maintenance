<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use JeffersonGoncalves\Erp\Core\Enums\DocStatus;
use JeffersonGoncalves\Erp\Maintenance\Support\ModelResolver;

/**
 * A snapshot of the maintenance pipeline: how many maintenance schedules are
 * committed (submitted), and how many maintenance visits are still pending.
 */
class MaintenanceStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $scheduleModel = ModelResolver::maintenanceSchedule();
        $visitModel = ModelResolver::maintenanceVisit();

        $submittedSchedules = $scheduleModel::query()
            ->where('docstatus', DocStatus::Submitted->value)
            ->count();

        $pendingVisits = $visitModel::query()
            ->where('docstatus', DocStatus::Draft->value)
            ->count();

        return [
            Stat::make('Submitted Schedules', (string) $submittedSchedules)
                ->description('committed maintenance plans')
                ->color($submittedSchedules > 0 ? 'primary' : 'gray'),
            Stat::make('Pending Visits', (string) $pendingVisits)
                ->description('draft maintenance visits')
                ->color($pendingVisits > 0 ? 'warning' : 'gray'),
        ];
    }
}
