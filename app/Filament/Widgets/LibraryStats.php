<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Throwable;

class LibraryStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        try {
            return [
                Stat::make('Total Books', Book::count()),
                Stat::make('Total Users', User::count()),
                Stat::make('Total Categories', Category::count()),
                Stat::make('Available Books', Book::where('status', Book::STATUS_AVAILABLE)->count()),
            ];
        } catch (Throwable) {
            return [
                Stat::make('Total Books', 0),
                Stat::make('Total Users', 0),
                Stat::make('Total Categories', 0),
                Stat::make('Available Books', 0),
            ];
        }
    }
}
