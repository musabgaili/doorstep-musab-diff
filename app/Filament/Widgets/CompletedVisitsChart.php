<?php

namespace App\Filament\Widgets;

use App\Models\Apartment;
use App\Models\VisitRequest;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class CompletedVisitsChart extends ChartWidget
{
    protected static ?int $sort = 2;
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
        return 'Visits Completed this month';
    }

    protected function getData(): array
    {

        $activeFilter = $this->filter;

        $data = Trend::query(
            VisitRequest::query()
                ->where('status', 'approved')
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
                    'label' => 'Visit Requests complete',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#1cd113',
                    'borderColor' => '#1cd113',
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
