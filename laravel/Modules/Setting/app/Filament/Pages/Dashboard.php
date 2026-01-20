<?php

declare(strict_types=1);

namespace Modules\Setting\Filament\Pages;

use Illuminate\Support\Facades\Process as LaravelProcess;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'setting::filament.pages.dashboard';

    public function upgrade(): void
    {
        $command = 'php artisan filament:upgrade';

        LaravelProcess::run($command);
    }

    protected function getViewData(): array
    {
        return ['a' => 'b'];
    }

    // public function mount(): void {
    //     $user = auth()->user();
    //     // @phpstan-ignore-next-line method.nonObject
    //     if(!$user->hasRole('super-admin')){
    //         redirect('/admin');
    //     }
    // }
}
