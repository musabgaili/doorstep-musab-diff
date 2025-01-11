<?php

namespace App\Filament\Widgets;

use App\Models\Apartment;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ApartmentOverview extends ChartWidget
{

    protected static ?int $sort = 4;
    protected static string $view = 'filament-widgets::chart-widget';
    protected static ?string $heading = 'Chart';
    protected static ?string $maxHeight = '300px';
    public ?string $filter = 'today';
    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }

    public function getHeading(): string
    {
        return 'Apartments Registered this month';
    }

    protected function getData(): array
    {

        $activeFilter = $this->filter;
        $data = Trend::model(Apartment::class);

        switch ($activeFilter) {
            case 'today':
                $data = $data->between(
                    start: now()->startOfDay(),
                    end: now()->endOfDay(),
                )->perHour();
                break;
            case 'week':
                $data = $data->between(
                    start: now()->startOfWeek(),
                    end: now()->endOfWeek(),
                )->perDay();
                break;
            case 'month':
                $data = $data->between(
                    start: now()->startOfMonth(),
                    end: now()->endOfMonth(),
                )->perDay();
                break;
            case 'year':
                $data = $data->between(
                    start: now()->startOfYear(),
                    end: now()->endOfYear(),
                )->perMonth();
                break;
        }

        $data = $data->count();
        return [
            'datasets' => [
                [
                    'label' => 'Apartments',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#8A2BE2',
                    'borderColor' => '#8A2BE2',
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
