<?php

namespace App\Filament\Widgets;

use App\Models\Apartment;
use App\Models\VisitRequest;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class PendingVisitsChart extends ChartWidget
{
    protected static ?int $sort = 3;
    protected static ?string $heading = 'Chart';
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
        return 'Visits Pending this month';
    }

    protected function getData(): array
    {

        $activeFilter = $this->filter;

        $data = Trend::query(
            VisitRequest::query()
                ->where('status', 'pending')
        );

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
                    'label' => 'Visit Requests pending',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#C70039',
                    'borderColor' => '#C70039',
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
