<x-filament-panels::page>
    <x-filament::section>
        <form wire:submit="send">

            <x-slot name="heading">
                C015 - Accertamento Generalità
            </x-slot>

            <x-slot name="description">
                Servizio per l'accertamento delle generalità del cittadino tramite ANPR.
                Restituisce i dati anagrafici completi (generalità, stato civile, identificativi, ecc.).
            </x-slot>
            
            {{ $this->pdndForm }}
            
            <br>

            <x-filament::actions :actions="$this->getPdndFormActions()" />

            <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="send()"/>

            <br><br>

            @if($esitoPositivo)
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-success-600 flex items-center gap-2">
                        ✅ Accertamento completato con successo
                    </h3>
                    <br>

                    <!-- === LAYOUT A TRE COLONNE === -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <!-- Colonna 1: Generalità -->
                        <x-filament::section heading="Generalità" class="h-fit">
                            <dl class="space-y-3 text-sm">
                                <div class="flex justify-between"><span class="font-medium">Cognome</span> <span>{{ $datiCittadino['generalita']['cognome'] ?? '-' }}</span></div>
                                <div class="flex justify-between"><span class="font-medium">Nome</span> <span>{{ $datiCittadino['generalita']['nome'] ?? '-' }}</span></div>
                                <div class="flex justify-between"><span class="font-medium">Codice Fiscale</span> <span class="font-mono">{{ $datiCittadino['generalita']['codiceFiscale']['codFiscale'] ?? '-' }}</span></div>
                                <div class="flex justify-between"><span class="font-medium">Validità CF</span> 
                                    <span>{{ ($datiCittadino['generalita']['codiceFiscale']['validitaCF'] ?? '') === '1' ? '✅ Valido' : '❌ Non valido' }}</span>
                                </div>
                                <div class="flex justify-between"><span class="font-medium">Sesso</span> <span>{{ $datiCittadino['generalita']['sesso'] ?? '-' }}</span></div>
                                <div class="flex justify-between"><span class="font-medium">Soggetto AIRE</span> <span>{{ $datiCittadino['generalita']['soggettoAIRE'] === 'S' ? 'Sì' : 'No' }}</span></div>
                                <div class="flex justify-between"><span class="font-medium">Data di nascita</span> 
                                    <span>{{ $datiCittadino['generalita']['dataNascita'] ? \Carbon\Carbon::parse($datiCittadino['generalita']['dataNascita'])->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between"><span class="font-medium">Luogo di nascita</span> 
                                    <span>{{ $luogoFinale ?? '-' }}</span>
                                </div>
                            </dl>
                        </x-filament::section>

                        {{-- <!-- Colonna 2: Identificativi -->
                        <x-filament::section heading="Identificativi" class="h-fit">
                            <dl class="space-y-3 text-sm">
                                <div class="flex justify-between"><span class="font-medium">ID ANPR</span> <span class="font-mono">{{ $idAnpr }}</span></div>
                                <div class="flex justify-between"><span class="font-medium">ID Scheda ANPR</span> <span class="font-mono">{{ $datiCittadino['generalita']['idSchedaSoggettoANPR'] ?? '-' }}</span></div>
                            </dl>
                        </x-filament::section> --}}

                        <!-- Colonna 3: Stato Civile -->
                        @if(!empty($datiCittadino['stato_civile']))
                            <x-filament::section heading="Stato Civile" class="h-fit">
                                @php
                                    $codiceStato = $datiCittadino['stato_civile']['statoCivile'] ?? null;
                                    $descrizioni = [
                                        '1' => 'Celibe/Nubile', '2' => 'Coniugato/a', '3' => 'Vedovo/a',
                                        '4' => 'Divorziato/a', '5' => 'Non classificabile', '6' => 'Unito civilmente',
                                        '7' => 'Stato libero (decesso)', '8' => 'Stato libero (scioglimento)', '9' => 'Non classificabile'
                                    ];
                                    $descrizione = $descrizioni[$codiceStato] ?? 'Codice sconosciuto';
                                @endphp
                                <p class="text-base font-medium">
                                    {{ $descrizione }} <span class="text-gray-400">({{ $codiceStato }})</span>
                                </p>
                            </x-filament::section>
                        @endif

                    </div>
                </div>
            @else
                <div class="mt-6 p-4 bg-gray-100 rounded-lg text-center">
                    Effettua una ricerca per ottenere i dati richiesti.
                </div>
            @endif

        </form>
    </x-filament::section>
</x-filament-panels::page>