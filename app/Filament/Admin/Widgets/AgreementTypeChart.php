<?php

namespace App\Filament\Admin\Widgets;

use App\Models\AgreementType;
use Filament\Widgets\ChartWidget;

class AgreementTypeChart extends ChartWidget
{
    protected static ?int $sort = 3;
    protected ?string $heading = 'Agreements by Type';

    protected function getData(): array
    {
        $types = AgreementType::withCount('agreements')
            ->orderByDesc('agreements_count')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Number of Agreements',
                    'data' => $types->pluck('agreements_count')->toArray(),
                    'backgroundColor' => [
                        '#f59e0b', '#3b82f6', '#10b981', '#ef4444',
                        '#8b5cf6', '#ec4899', '#14b8a6', '#f97316',
                    ],
                ],
            ],
            'labels' => $types->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}