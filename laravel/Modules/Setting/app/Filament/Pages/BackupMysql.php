<?php

declare(strict_types=1);

namespace Modules\Setting\Filament\Pages;

use Modules\Setting\Actions\DB\DownloadAction;
use Modules\Xot\Filament\Pages\XotBasePage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Webmozart\Assert\Assert;

final class BackupMysql extends XotBasePage
{
    protected string $view = 'setting::filament.pages.backup-mysql';

    public function download(string $connectionName): BinaryFileResponse
    {
        return app(DownloadAction::class)->execute($connectionName);
    }

    // public function mount(): void {
    //     $user = auth()->user();
    //     // @phpstan-ignore-next-line method.nonObject
    //     if(!$user->hasRole('super-admin')){
    //         redirect('/admin');
    //     }
    // }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $connections = config('database.connections');
        Assert::isArray($connections);

        $connections = array_filter(
            $connections,
            static function (mixed $item): bool {
                // Type narrowing: ensure item is array with driver key
                if (! is_array($item)) {
                    return false;
                }
                $driver = isset($item['driver']) && is_string($item['driver']) ? $item['driver'] : '';

                return 'mysql' === $driver;
            }
        );

        // $connections=collect($connections)->keyBy('database');
        return ['connections' => $connections];
    }
}
