<?php

namespace App\Filament\Widgets;

use App\Support\LibraryCatalog;
use Filament\Widgets\ChartWidget;

class BooksByCategoryChart extends ChartWidget
{
    protected ?string $heading = 'Books by Category';

    protected function getData(): array
    {
        $categories = collect(LibraryCatalog::categories());

        return [
            'datasets' => [[
                'label' => 'Books',
                'data' => $categories->pluck('book_count')->all(),
            ]],
            'labels' => $categories->pluck('name')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
