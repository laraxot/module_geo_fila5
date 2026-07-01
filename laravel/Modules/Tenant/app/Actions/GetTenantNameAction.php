<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per ottenere il nome del tenant basato sul server name.
 */
class GetTenantNameAction
{
    use QueueableAction;

    /**
     * Esegue l'action per ottenere il nome del tenant.
     *
     * @return string Il nome del tenant
     */
    public function execute(): string
    {
        $default = config('app.url');

        if (! \is_string($default)) {
            $default = 'localhost';
        }

        $default = Str::after($default, '//');

        $serverName = $this->getServerName($default);
        $serverName = Str::of($serverName)->replace('www.', '')->toString();

        /** @var Collection<int, string> $parts */
        $parts = collect(explode('.', $serverName))
            ->map(static fn (string $part): string => Str::slug($part))
            ->reverse()
            ->values();

        // Prova il percorso completo
        $configFile = $this->buildConfigPath($parts);
        if (file_exists($configFile)) {
            return $parts->implode('/');
        }

        // Prova il percorso senza l'ultimo segmento se ci sono più di 2 parti
        if ($parts->count() > 2) {
            /** @var Collection<int, string> $shortenedParts */
            $shortenedParts = $parts->slice(0, -1);
            $configFile = $this->buildConfigPath($shortenedParts);
            if (file_exists($configFile)) {
                return $shortenedParts->implode('/');
            }
        }

        // Fallback al default
        $part = explode('.', $default);
        $inverted = array_reverse($part);
        $defaultPath = implode('/', $inverted);
        if ($defaultPath !== '' && file_exists(base_path('config/'.$defaultPath))) {
            return $defaultPath;
        }

        return 'localhost';
    }

    /**
     * Ottiene il nome del server con fallback al default.
     *
     * @param  string  $default  Il valore di default da usare
     *
     * @return string Il nome del server
     */
    private function getServerName(string $default): string
    {
        if (
            isset($_SERVER['SERVER_NAME']) &&
                $_SERVER['SERVER_NAME'] !== '127.0.0.1' &&
                is_string($_SERVER['SERVER_NAME'])
        ) {
            return $_SERVER['SERVER_NAME'];
        }

        return $default;
    }

    /**
     * Costruisce il percorso di configurazione.
     *
     * @param  Collection<int, string>  $parts  Le parti del percorso
     *
     * @return string Il percorso completo
     */
    private function buildConfigPath(Collection $parts): string
    {
        return config_path($parts->implode(DIRECTORY_SEPARATOR));
    }
}
