<?php

declare(strict_types=1);

namespace Modules\MobilitaVolontaria\Models\Panels;

/**
 * Class _ModulePanel
 *
 * Classe base per i panel del modulo MobilitaVolontaria.
 * Implementazione semplificata che non richiede la dipendenza dal modulo Cms.
 */
class _ModulePanel
{
    /**
     * Definisce le azioni disponibili per questo panel.
     */
    public function actions(): array
    {
        return [
            //   new Actions\TestAction(),
        ];
    }

    /**
     * Restituisce il titolo del panel.
     */
    public function getTitle(): string
    {
        return '';
    }

    /**
     * Restituisce la descrizione del panel.
     */
    public function getDescription(): string
    {
        return '';
    }
}
