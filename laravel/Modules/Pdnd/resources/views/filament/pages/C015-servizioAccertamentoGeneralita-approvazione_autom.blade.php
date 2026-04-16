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
                    <h3 class="text-lg font-semibold text-success-600">✅ Accertamento completato con successo</h3>

                    @if(!empty($datiCittadino['generalita']))
                        <x-filament::section heading="Generalità">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div><strong>Cognome:</strong> {{ $datiCittadino['generalita']['cognome'] ?? '-' }}</div>
                                <div><strong>Nome:</strong> {{ $datiCittadino['generalita']['nome'] ?? '-' }}</div>
                                <div><strong>Codice Fiscale:</strong> {{ $datiCittadino['generalita']['codiceFiscale']['codFiscale'] ?? '-' }}</div>
                                <div><strong>Sesso:</strong> {{ $datiCittadino['generalita']['sesso'] ?? '-' }}</div>
                                <div><strong>Soggetto AIRE:</strong> {{ $datiCittadino['generalita']['soggettoAIRE'] ?? '-' }}</div>

                                {{-- DATA DI NASCITA --}}
                                @php
                                    $dataNascita = $datiCittadino['generalita']['dataNascita'] ?? null;
                                    $dataFormattata = $dataNascita 
                                        ? \Carbon\Carbon::parse($dataNascita)->format('d/m/Y') 
                                        : '-';
                                @endphp
                                <div><strong>Data di nascita:</strong> {{ $dataFormattata }}</div>

                                {{-- LUOGO DI NASCITA --}}
                                @php
                                    $luogo = $datiCittadino['generalita']['luogoNascita'] ?? [];
                                    $comune = $luogo['comune']['nomeComune'] ?? null;
                                    $localita = $luogo['localita']['descrizioneLocalita'] ?? null;
                                    $luogoEccezionale = $luogo['luogoEccezionale'] ?? null;
                                @endphp
                                <div><strong>Luogo di nascita:</strong> 
                                    @if($comune)
                                        {{ $comune }}
                                        @if($localita) ({{ $localita }}) @endif
                                    @elseif($luogoEccezionale)
                                        {{ $luogoEccezionale }}
                                    @else
                                        -
                                    @endif
                                </div>

                            </dl>
                        </x-filament::section>
                    @endif

                    @if(!empty($datiCittadino['stato_civile']))
                        <x-filament::section heading="Stato Civile">
                            @php
                                $codiceStato = $datiCittadino['stato_civile']['statoCivile'] ?? null;
                                $descrizioni = [
                                    '1' => 'Celibe/Nubile',
                                    '2' => 'Coniugato/a',
                                    '3' => 'Vedovo/a',
                                    '4' => 'Divorziato/a',
                                    '5' => 'Non classificabile/ignoto/n.c',
                                    '6' => 'Unito civilmente',
                                    '7' => 'Stato libero a seguito di decesso della parte unita civilmente',
                                    '8' => 'Stato libero a seguito di scioglimento dell\'unione',
                                    '9' => 'Non classificabile/ignoto/n.c',
                                ];
                                $descrizione = $descrizioni[$codiceStato] ?? 'Codice sconosciuto ('.$codiceStato.')';
                            @endphp
                            
                            <p><strong>Stato Civile:</strong> {{ $descrizione }} <span class="text-gray-400">({{ $codiceStato }})</span></p>
                        </x-filament::section>
                    @endif

                    @if(!empty($datiCittadino['info_ente']))
                        <x-filament::section heading="Informazioni Ente">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($datiCittadino['info_ente'] as $info)
                                    <li>
                                        <strong>{{ $info['chiave'] ?? 'Info' }}:</strong> 
                                        {{ $info['valore_testo'] ?? $info['valore'] ?? $info['valore_data'] ?? '-' }}
                                    </li>
                                @endforeach
                            </ul>
                        </x-filament::section>
                    @endif
                </div>
            @else
                <div class="mt-6 p-4 bg-gray-100 rounded-lg">
                    <p class="text-gray-600">
                        @if($idAnpr)
                            {{ $idAnpr }}
                        @else
                            Effettua una ricerca per ottenere i dati richiesti.
                        @endif
                    </p>
                </div>
            @endif

        </form>
    </x-filament::section>
</x-filament-panels::page>