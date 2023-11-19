<?php

namespace App\Filament\Widgets;

use App\Models\Alert;
use App\Models\Category;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class StatsOverview extends BaseWidget
{

    protected static ?string $pollingInterval = null;
    
    protected function getStats(): array
    {

        $productsCountByMonth = Product::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->pluck('count', 'month')
        ->toArray();
        
        return [
            Stat::make('Users', User::where('is_admin',false)->count()),
            Stat::make('Products',Product::count())
            ->chart(array_values($productsCountByMonth)),
            Stat::make('Categories', Category::count()),
            Stat::make('Alert',Alert::count()),
        ];
    }
}
