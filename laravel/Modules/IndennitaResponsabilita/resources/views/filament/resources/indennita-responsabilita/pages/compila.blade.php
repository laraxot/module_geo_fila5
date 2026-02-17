<x-filament::page>
    <div class="fi-header">
        <h3 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
            {!! $this->record->msg('titolo') !!}
        </h3>
    </div>

    <div class="space-y-6">
        <div class="fi-section p-6 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <h3 class="text-lg font-medium tracking-tight text-gray-950 dark:text-white border-b pb-2 mb-4">Informazioni Generali</h3>
            <div class="grid grid-cols-4 gap-4">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Matricola</span>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $this->record->matr }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Cognome</span>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $this->record->cognome }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Nome</span>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $this->record->nome }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">P.Time %</span>
                    <p class="text-gray-900 dark:text-white font-medium">{{ number_format(($this->record->perc_p_time_year ?? 0) * 100, 2) }} %</p>
                </div>
            </div>
        </div>

        <div class="fi-section p-6 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <h3 class="text-lg font-medium tracking-tight text-gray-950 dark:text-white border-b pb-2 mb-4">Riepilogo Calcoli</h3>
            <div class="grid grid-cols-4 gap-4">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Punteggio Totale</span>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $this->record->tot_score }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Mensile Calcolato</span>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $this->record->mensile_calcolato }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Mensile Attribuito</span>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $this->record->mensile_attribuito }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Annuale Attribuito</span>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $this->record->annuale_attribuito }}</p>
                </div>
            </div>
        </div>

        {{ $this->form }}

        <div class="flex items-center gap-x-3">
             <x-filament::button
                color="gray"
                tag="a"
                :href="static::$resource::getUrl('index')"
            >
                Back
            </x-filament::button>

             <x-filament::button
                type="button"
                wire:click="save()"
            >
                Salva
            </x-filament::button>
        </div>

        @if($this->record->msg('legenda'))
             <div class="fi-section p-6 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <h3 class="text-lg font-medium tracking-tight text-gray-950 dark:text-white border-b pb-2 mb-4">Legenda</h3>
                <div class="mt-2 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                    {!! $this->record->msg('legenda') !!}
                </div>
            </div>
        @endif
    </div>
</x-filament::page>