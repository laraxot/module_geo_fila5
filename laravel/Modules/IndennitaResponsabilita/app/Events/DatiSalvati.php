<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Events;

use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;

/**
 * Evento per il salvataggio dei dati di valutazione
 */
class DatiSalvati implements ShouldBroadcast
{
    /**
     * Record modificato
     */
    public function __construct(
        public IndennitaResponsabilita $record,
        public array $vecchiDati = [],
        public array $nuoviDati = []
    ) {
        $this->record = $record;
        $this->vecchiDati = $record->only(['matr', 'cognome', 'email', 'responsabilita_di_spesa', 'realizzazione_piani_programmi', 'supporto_decisioni_dirigente', 'note']);
        $this->nuoviDati = $this->form->only(['matr', 'cognome', 'email', 'responsabilita_di_spesa', 'realizzazione_piani_programmi', 'supporto_decisioni_dirigente', 'note']);
    }

    /**
     * Dati che sono cambiati
     */
    public function getVecchiDati(): array
    {
        return array_diff_assoc($this->vecchiDati, $this->nuoviDati);
    }

    /**
     * Dati nuovi inseriti
     */
    public function getNuoviDati(): array
    {
        return array_diff_assoc($this->nuoviDati, $this->vecchiDati);
    }

    /**
     * Get nome per broadcasting
     */
    public function broadcastOn(): array
    {
        return ['dati-salvati'];
    }
}
