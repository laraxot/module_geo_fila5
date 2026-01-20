# 📊 PresenzeAssenze Charts - Attendance Analytics

**Modulo**: PresenzeAssenze
**Data**: 2025-12-09
**Status**: ✅ Production Ready

---

## 📋 Overview

Chart widgets per analisi presenze/assenze, trend ferie, e statistiche workforce.

### Use Cases

- 📅 **Attendance Timeline** - Trend presenze mensili
- 🏖️ **Leave Balance** - Bilancio ferie/permessi
- 📊 **Absence Types** - Distribuzione tipologie assenze
- 👥 **Department Comparison** - Confronto presenze per reparto

---

## 📊 Example Widgets

### 1. Attendance Timeline Chart

```php
<?php

namespace Modules\PresenzeAssenze\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Modules\PresenzeAssenze\Models\Presenza;

class AttendanceTimelineChart extends ChartWidget
{
    protected static ?string $heading = 'Attendance Trend';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $presenze = Trend::model(Presenza::class)
            ->between(
                start: now()->subMonths(6),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Presenze',
                    'data' => $presenze->map(fn ($value) => $value->aggregate),
                    'borderColor' => 'rgb(34, 197, 94)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'fill' => 'start',
                ],
            ],
            'labels' => $presenze->map(fn ($value) => $value->date),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Modules\Xot\Filament\Actions\ExportChartPngAction::make(),
            \Modules\Xot\Filament\Actions\ExportChartSvgAction::make(),
        ];
    }
}
```

### 2. Leave Balance Doughnut

```php
<?php

namespace Modules\PresenzeAssenze\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\PresenzeAssenze\Models\LeaveBalance;

class LeaveBalanceChart extends ChartWidget
{
    protected static ?string $heading = 'Leave Balance';

    public ?string $userId = null;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $userId = $this->userId ?? auth()->id();

        $balance = LeaveBalance::where('user_id', $userId)->first();

        return [
            'datasets' => [
                [
                    'data' => [
                        $balance?->annual_leave_used ?? 0,
                        $balance?->annual_leave_remaining ?? 0,
                        $balance?->sick_leave_used ?? 0,
                        $balance?->sick_leave_remaining ?? 0,
                    ],
                    'backgroundColor' => [
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(251, 146, 60, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                    ],
                ],
            ],
            'labels' => [
                'Annual Leave Used',
                'Annual Leave Remaining',
                'Sick Leave Used',
                'Sick Leave Remaining',
            ],
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Modules\Xot\Filament\Actions\ExportChartPngAction::make(),
            \Modules\Xot\Filament\Actions\ExportChartSvgAction::make(),
        ];
    }
}
```

### 3. Absence Types Distribution

```php
<?php

namespace Modules\PresenzeAssenze\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\PresenzeAssenze\Models\Assenza;

class AbsenceTypesChart extends ChartWidget
{
    protected static ?string $heading = 'Absence Types';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $types = Assenza::query()
            ->selectRaw('type, COUNT(*) as count')
            ->whereYear('date', now()->year)
            ->groupBy('type')
            ->pluck('count', 'type');

        return [
            'datasets' => [
                [
                    'label' => 'Count',
                    'data' => $types->values(),
                    'backgroundColor' => [
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(251, 146, 60, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                    ],
                ],
            ],
            'labels' => $types->keys()->map(fn ($key) => ucfirst($key)),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Modules\Xot\Filament\Actions\ExportChartPngAction::make(),
            \Modules\Xot\Filament\Actions\ExportChartSvgAction::make(),
        ];
    }
}
```

### 4. Department Attendance Heatmap

```php
<?php

namespace Modules\PresenzeAssenze\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\PresenzeAssenze\Models\Presenza;
use Illuminate\Support\Facades\DB;

class DepartmentAttendanceHeatmap extends ChartWidget
{
    protected static ?string $heading = 'Department Attendance Heatmap';

    protected function getType(): string
    {
        return 'matrix';
    }

    protected function getData(): array
    {
        // Get attendance rate by department and day of week
        $matrix = Presenza::query()
            ->select(
                'department_id',
                DB::raw('DAYOFWEEK(date) as day_of_week'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('date', now()->year)
            ->groupBy('department_id', 'day_of_week')
            ->get()
            ->map(fn ($item) => [
                'x' => $item->day_of_week,
                'y' => $item->department_id,
                'v' => $item->count,
            ]);

        return [
            'datasets' => [
                [
                    'data' => $matrix,
                    'backgroundColor' => fn ($context) => {
                        $value = $context->dataset->data[$context->dataIndex]['v'];
                        $max = $matrix->max('v');
                        $intensity = $value / $max;

                        return "rgba(34, 197, 94, {$intensity})";
                    },
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
                'tooltip' => [
                    'callbacks' => [
                        'title' => RawJs::make('() => ""'),
                        'label' => RawJs::make('(context) => {
                            const v = context.dataset.data[context.dataIndex];
                            const days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
                            return days[v.x - 1] + ": " + v.v + " presenze";
                        }'),
                    ],
                ],
            ],
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Modules\Xot\Filament\Actions\ExportChartPngAction::make(),
            \Modules\Xot\Filament\Actions\ExportChartSvgAction::make(),
        ];
    }
}
```

---

## 🎯 Advanced Features

### Working Hours Analysis

```php
class WorkingHoursChart extends ChartWidget
{
    protected function getData(): array
    {
        $hours = Presenza::query()
            ->selectRaw('
                user_id,
                SUM(TIMESTAMPDIFF(HOUR, clock_in, clock_out)) as total_hours
            ')
            ->whereYear('date', now()->year)
            ->groupBy('user_id')
            ->with('user')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Working Hours',
                    'data' => $hours->pluck('total_hours'),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.8)',
                ],
                [
                    'label' => 'Standard Hours',
                    'data' => $hours->map(fn () => 1920), // 40h/week * 48 weeks
                    'backgroundColor' => 'rgba(107, 114, 128, 0.5)',
                    'type' => 'line',
                ],
            ],
            'labels' => $hours->pluck('user.name'),
        ];
    }
}
```

---

## 📚 Risorse

- [Chart.js Matrix](https://github.com/kurkle/chartjs-chart-matrix)
- [Laravel Trend](https://github.com/Flowframe/laravel-trend)

---

**Autore**: PTVX Development Team
**Ultimo Aggiornamento**: 2025-12-09
