<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;


class AlertOverview extends BaseWidget
{

    public ?Model $record = null;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Alerts', $this->record->users()->count()),
        ];
    }
}
