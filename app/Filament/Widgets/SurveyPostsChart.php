<?php

namespace App\Filament\Widgets;


use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class SurveyPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Utilisateurs';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Trend::model(User::class)
        ->between(
            start: now()->startOfMonth(),
            end: now()->endOfMonth(),
        )
        ->perDay()
        ->count();
 
    return [
        'datasets' => [
            [
                'label' => 'Nombre d\'utilisateurs',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
