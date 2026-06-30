<?php

namespace JeffersonGoncalves\FilamentErp\Maintenance\Concerns;

use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use JeffersonGoncalves\Erp\Maintenance\Models\MaintenanceSchedule;
use JeffersonGoncalves\Erp\Maintenance\Services\MaintenanceScheduleService;

/**
 * The "Generate Schedule" record action for a maintenance schedule. It hands
 * off to {@see MaintenanceScheduleService::generateSchedule()}, which expands
 * every schedule item into its dated visit detail rows (clearing any previously
 * generated rows first, so the action is safe to run repeatedly).
 *
 * The action is available regardless of docstatus: it is useful before submit
 * to preview the projected visits, and after submit to regenerate them. (The
 * same expansion also fires automatically when a schedule is submitted.) Any
 * failure is surfaced as a Filament danger notification.
 */
trait GeneratesMaintenanceSchedule
{
    public static function generateScheduleAction(): Action
    {
        return Action::make('generateSchedule')
            ->label('Generate Schedule')
            ->icon('heroicon-o-calendar-days')
            ->color('primary')
            ->requiresConfirmation()
            ->action(function (Model $record): void {
                if (! $record instanceof MaintenanceSchedule) {
                    return;
                }

                try {
                    app(MaintenanceScheduleService::class)->generateSchedule($record);

                    $count = $record->scheduleDetails()->count();

                    Notification::make()
                        ->title('Schedule generated')
                        ->body('Generated '.$count.' visit '.($count === 1 ? 'row' : 'rows').'.')
                        ->success()
                        ->send();
                } catch (\Throwable $exception) {
                    Notification::make()
                        ->title('Unable to generate schedule')
                        ->body($exception->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }
}
