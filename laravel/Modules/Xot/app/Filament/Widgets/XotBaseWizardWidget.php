<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

/**
 * Base per widget Filament che espongono un {@see Wizard} nello schema.
 *
 * **Perche esiste (visione / filosofia / religione / zen)**:
 *
 * ## Separazione delle Responsabilita
 * - `XotBaseWidget` = contratto generico (form lineare, tabelle, statistiche)
 * - `XotBaseWizardWidget` = specializzazione per wizard multi-step
 *   - Gestisce: navigazione step, persistenza `?step=`, normalizzazione stato annidato
 * - Widget dominio (es. CreateTicketWizardWidget) = campi specifici e business logic
 *
 * ## DRY + KISS
 * - UNA sola implementazione del protocollo wizard:
 *   - Lettura sicura di `?step=` con validazione range 1..N
 *   - Appiattimento stato annidato (`normalizeWizardFormState()`)
 *   - Persistenza step in query string (solo se consentito)
 * - Ogni modulo NON reinventa la stessa logica
 *
 * ## Allineamento Filament
 * - Navigazione delegata a `Wizard` / `Step` (documentazione ufficiale v5)
 * - Parallelo concettuale con `CreateRecord\Concerns\HasWizard` (pannello): li `getSteps()` + `hasSkippableSteps()`;
 *   qui `getWizardSteps()` + {@see hasSkippableWizardSteps()} — stesso componente {@see Wizard}, contesto Livewire widget (frontoffice/CMS), non pagina Resource.
 * - Questa classe NON sostituisce Filament, incornicia solo gli hook Laraxot comuni
 * - Hook disponibili per override dominio-specifici:
 *   - `configureWizardNextAction()` → label, tooltip, icon del pulsante Avanti
 *   - `configureWizardPreviousAction()` → label, tooltip, icon del pulsante Indietro
 *   - `getWizardSubmitAction()` → rendering pulsante Submit centralizzato in classe base
 *
 * ## Politica Sicurezza
 * - Override `?step=` NON e mai implicito in produzione
 * - Consentito SOLO se:
 *   - `app()->isLocal()` → true
 *   - `config('app.debug')` → true
 *   - `wizardAllowStepQueryExtra()` → override modulo-specifico (default false)
 *
 * ## Auto-Label e Traduzioni (LangServiceProvider)
 * - **REGOLA AUREA**: NON usare `->label()` o `->tooltip()` espliciti sui campi/azioni
 * - LangServiceProvider configura automaticamente label, placeholder, helperText, tooltip
 * - Pattern chiave: `{namespace}::{widget_name}.{type}.{field_name}.{property}`
 *   - Es: `<moule name>::create_ticket_wizard.actions.next.label`
 *   - Es: `<moule name>::create_ticket_wizard.fields.address.required`
 * - Il submit button wizard resta centralizzato qui, non nel widget dominio
 *
 * ## Log e Gestione Errori
 * - **NO `Log::error()` nei widget dominio** (filosofia Laraxot)
 * - Filament gestisce automaticamente la UI per validation errors
 * - Catch `\Throwable` solo per notifiche user-friendly generiche
 * - Log dettagliato: compito del framework/logging.php, non del dominio
 *
 * @see Wizard
 * @see \Filament\Resources\Pages\CreateRecord\Concerns\HasWizard
 * @see \Modules\Lang\Providers\LangServiceProvider
 * @see \Modules\Lang\Actions\Filament\AutoLabelAction
 */
abstract class XotBaseWizardWidget extends XotBaseWidget
{
    /** Step iniziale (1..N) calcolato da mount e da `?step=` se consentito. */
    public int $wizardStartStep = 1;

    protected int|string|array $columnSpan = 'full';

    /**
     * Elenco step del wizard (ordine = flusso utente). Ogni widget concreto lo implementa;
     * la convenzione `getStepByName('foo')` → `getFooSchema()` resta nel metodo helper {@see getStepByName()}.
     *
     * @return array<int, Step>
     */
    abstract public function getWizardSteps(): array;

    /**
     * Numero massimo di step del wizard (per validare la query `step`).
     * Default: numero di elementi restituiti da {@see getWizardSteps()} (come `count(getSteps())` nel trait Filament `HasWizard`).
     */
    protected function wizardMaxStep(): int
    {
        return max(1, \count($this->getWizardSteps()));
    }

    /**
     * Chiave usata in `getFormSchema()` per wrappare il componente `Wizard` (stato annidato sotto `data`).
     * Override nel widget concreto se diverso da `wizard`.
     */
    protected function getWizardSchemaWrapperKey(): string
    {
        return 'wizard';
    }

    /**
     * @return array<int, Component>
     */
    public function getFormSchema(): array
    {
        $wizard = $this->makeWizard($this->getWizardSteps())
            ->nextAction(fn (Action $action): Action => $this->configureWizardNextAction($action))
            ->previousAction(fn (Action $action): Action => $this->configureWizardPreviousAction($action))
            ->submitAction($this->getWizardSubmitAction());

        return [
            $wizard,
        ];
    }

    /**
     * Centralizza il contratto minimo di un wizard Xot:
     * step iniziale coerente, full width, e step in query solo se consentito.
     *
     * @param array<int, Step> $steps
     */
    protected function makeWizard(array $steps): Wizard
    {
        $wizard = Wizard::make($steps)
            ->startOnStep(fn (): int => $this->wizardStartStep)
            ->columnSpanFull()
            ->skippable($this->hasSkippableWizardSteps());

        if ($this->queryStepOverrideAllowed()) {
            $wizard->persistStepInQueryString('step');
        }

        return $wizard;
    }

    /**
     * Hook per i dati iniziali del form (da sovrascrivere nel widget di dominio).
     * Segue il pattern di Filament CreateRecord.
     *
     * @return array<string, mixed>
     */
    protected function defaultFormData(): array
    {
        return [];
    }

    /**
     * Validazione custom per il wizard submission.
     * Da sovrascrivere nei widget di dominio per logiche custom.
     * Filament gestisce automaticamente la validation dei form fields.
     */
    protected function validateWizardSubmission(): void
    {
        // Validazione di base gestita da Filament
        // Override per logiche custom es:
        // if ($this->isLastStep()) { $this->validateFinalStep(); }
    }

    /**
     * Prepara i dati prima della creazione/aggiornamento.
     * Pattern ufficiale di Filament: mutateFormDataBeforeCreate/Update.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    protected function prepareWizardFormData(array $data): array
    {
        // Override per trasformazioni dati custom
        // es: unset($data['field_temporaneo']);
        // es: $data['calculated_field'] = $this->calculateSomething();

        return $data;
    }

    /**
     * Controlla se lo step corrente è l'ultimo.
     * Utile per logiche conditional nei wizard.
     */
    protected function isLastStep(): bool
    {
        return $this->wizardStartStep >= $this->wizardMaxStep();
    }

    /**
     * Controlla se lo step corrente è il primo.
     */
    protected function isFirstStep(): bool
    {
        return $this->wizardStartStep <= 1;
    }

    /**
     * Aggiunge metodi di utility per la gestione degli step.
     * Questi metodi sono usati nei widget di dominio per logiche custom.
     */
    protected function getCurrentStepName(): ?string
    {
        $steps = $this->getWizardSteps();
        $index = $this->wizardStartStep - 1; // 0-based index

        $step = $steps[$index] ?? null;

        if (null === $step) {
            return null;
        }

        $label = $step->getLabel();

        return is_string($label) && '' !== $label ? $label : null;
    }

    /**
     * Metodo di hook prima di andare allo step successivo.
     * Da sovrascrivere per validazioni custom tra step.
     */
    protected function beforeNextStep(): bool
    {
        // Restituisce false per bloccare la navigazione
        // return false;

        return true; // Allow navigation by default
    }

    /**
     * Metodo di hook dopo andare allo step successivo.
     * Da sovrascrivere per logiche custom (es. cleanup, pre-fill).
     */
    protected function afterNextStep(): void
    {
        // Override per logiche custom
    }

    /**
     * Metodo di hook prima di andare allo step precedente.
     */
    protected function beforePreviousStep(): bool
    {
        return true; // Allow navigation by default
    }

    /**
     * Metodo di hook dopo andare allo step precedente.
     */
    protected function afterPreviousStep(): void
    {
        // Override per logiche custom
    }

    /**
     * Inizializza lo stato del wizard: step da query + fill dati default.
     * Chiamare da mount() nel widget concreto dopo aver impostato le property locali.
     *
     * Chiama `form->fill()` per inizializzare la proprietà Livewire `$data` con tutte
     * le chiavi dei campi del form. Senza questo, Livewire Entangle lancia errori
     * "property cannot be found" perché `$data` è un array vuoto al momento dell'init Alpine.
     */
    protected function initWizardState(): void
    {
        $this->wizardStartStep = $this->resolveInitialStepFromQuery();

        // Defensive: Filament's InteractsWithForms may initialize the Form at a different
        // lifecycle moment; avoid fatal errors by falling back to populating $this->data
        // when the Form instance is not yet available.
        try {
            if (isset($this->form) && is_object($this->form) && method_exists($this->form, 'fill')) {
                $this->form->fill($this->defaultFormData());
            } else {
                // Initialize Livewire-bound data array to prevent Entangle errors in Alpine
                $this->data = $this->defaultFormData();
            }
        } catch (\Throwable $e) {
            // Best-effort fallback to ensure the widget renders even if form->fill fails
            $this->data = $this->defaultFormData();
        }
    }

    /**
     * Configura l'azione "Avanti" del wizard.
     *
     * **Default**: ritorna l'action senza modifiche.
     * LangServiceProvider applica automaticamente label e tooltip via traduzione.
     *
     * Override nel widget dominio SOLO per:
     * - Icon custom: `->icon('heroicon-o-arrow-right')`
     * - Comportamento custom: `->requiresConfirmation()`
     * - NON usare per `->label()` o `->tooltip()` (gia gestiti da LangServiceProvider)
     */
    protected function configureWizardNextAction(Action $action): Action
    {
        return $action;
    }

    /**
     * Configura l'azione "Indietro" del wizard.
     *
     * **Default**: ritorna l'action senza modifiche.
     * LangServiceProvider applica automaticamente label e tooltip via traduzione.
     *
     * Override nel widget dominio SOLO per:
     * - Icon custom: `->icon('heroicon-o-arrow-left')`
     * - Comportamento custom: `->withoutFontWeight()`
     * - NON usare per `->label()` o `->tooltip()` (gia gestiti da LangServiceProvider)
     */
    protected function configureWizardPreviousAction(Action $action): Action
    {
        return $action;
    }

    /**
     * Bottone submit sull'ultimo step del wizard (centralizzato in base).
     *
     * **Protocollo di rendering** (in ordine di priorita):
     * 1. Se esiste `pub_theme::filament.wizard.submit-button` nel tema attivo: usa view tema
     * 2. Fallback Filament: `Action::make('submit')->submit('save')->button()`
     *
     * **Perche NON Action::submit('submit')**:
     * Action::submit crea un form Filament → il form si chiama sempre 'form', non 'submit'.
     * Soluzione corretta: `<button type="submit">` nativo che delega al `<form wire:submit>` Blade.
     */
    protected function getWizardSubmitAction(): Htmlable
    {
        /** @var view-string $submitView */
        $submitView = 'pub_theme::filament.wizard.submit-button';

        if (view()->exists($submitView)) {
            return new HtmlString((string) view($submitView)->render());
        }

        return Action::make('submit')
            ->submit('save')
            ->button();
    }

    protected function getStepByName(string $name): Step
    {
        $schema = Str::of($name)
            ->snake()
            ->studly()
            ->prepend('get')
            ->append('Schema')
            ->toString();

        /** @var array<Htmlable|string> $schemaComponents */
        $schemaComponents = $this->$schema();

        return Step::make($name)->schema($schemaComponents);
    }

    /**
     * Allineato a {@see \Filament\Resources\Pages\Concerns\HasWizard::hasSkippableSteps()}:
     * se `true`, gli step sono navigabili senza completare i campi obbligatori dello step corrente.
     * Per flussi cittadini (privacy, consensi) il default è `false`.
     */
    protected function hasSkippableWizardSteps(): bool
    {
        return false;
    }

    /**
     * Consentire `?step=` oltre local/debug (es. `config('mio_modulo.wizard.allow_step_query_override')`).
     */
    protected function wizardAllowStepQueryExtra(): bool
    {
        return false;
    }

    protected function queryStepOverrideAllowed(): bool
    {
        if (app()->isLocal()) {
            return true;
        }

        if (config('app.debug', false)) {
            return true;
        }

        return $this->wizardAllowStepQueryExtra();
    }

    /**
     * Legge `?step=` come intero 1..wizardMaxStep() solo se {@see queryStepOverrideAllowed()} consente salti.
     * Supporta sia passi numerici che descrittivi (per compatibilità con viste Blade personalizzate).
     */
    protected function resolveInitialStepFromQuery(): int
    {
        if (app()->runningInConsole()) {
            return 1;
        }

        $raw = request()->query('step');
        if (null === $raw || '' === $raw) {
            return 1;
        }

        // Controlla se è un parametro descrittivo (usato da alcune viste Blade personalizzate)
        if (! is_numeric($raw)) {
            if (str_contains((string) $raw, 'riepilogo')) {
                return 3;
            }
            if (str_contains((string) $raw, 'dati-della-segnalazione')) {
                return 2;
            }

            // Default al primo passo per qualsiasi altro valore non numerico
            return 1;
        }

        $step = (int) $raw;
        $max = $this->wizardMaxStep();
        if ($step < 1 || $step > $max) {
            return 1;
        }

        if (! $this->queryStepOverrideAllowed() && 1 !== $step) {
            return 1;
        }

        return $step;
    }

    /**
     * Appiattisce lo stato restituito da `getState()` se il `Wizard` e sotto la chiave wrapper.
     *
     * @param array<string, mixed> $state
     *
     * @return array<string, mixed>
     */
    protected function normalizeWizardFormState(array $state): array
    {
        $key = $this->getWizardSchemaWrapperKey();
        if (isset($state[$key]) && \is_array($state[$key])) {
            return $this->stringKeyed($state[$key]);
        }

        return $this->stringKeyed($state);
    }

    /**
     * @param array<mixed, mixed> $row
     *
     * @return array<string, mixed>
     */
    protected function stringKeyed(array $row): array
    {
        $out = [];
        foreach ($row as $key => $value) {
            $out[(string) $key] = $value;
        }

        return $out;
    }

    /**
     * Chiave del componente {@see Wizard} nello schema `form` (es. `form.data::wizard`).
     * Usata da {@see nextStep()} / {@see previousStep()} per delegare a Filament.
     */
    protected function getWizardComponentKey(): string
    {
        $schema = $this->getSchema('form');
        if (null === $schema) {
            throw new \RuntimeException('Schema [form] non trovato sul widget wizard.');
        }

        foreach ($schema->getComponents(withHidden: true) as $component) {
            if ($component instanceof Wizard) {
                $key = $component->getKey();
                if (null === $key || '' === $key) {
                    throw new \RuntimeException('Chiave Wizard vuota nello schema form.');
                }

                return $key;
            }
        }

        throw new \RuntimeException('Nessun componente Wizard trovato nello schema form.');
    }

    /**
     * Pulsanti Blade custom (`wire:click`): devono chiamare il {@see Wizard} via
     * {@see InteractsWithSchemas::callSchemaComponentMethod()}, non esistono metodi magici sul widget.
     */
    public function nextStep(): void
    {
        $key = $this->getWizardComponentKey();
        $wizard = $this->getSchemaComponent($key);
        if (! $wizard instanceof Wizard) {
            return;
        }

        $currentStepIndex = $wizard->getCurrentStepIndex();

        $this->callSchemaComponentMethod($key, 'nextStep', [
            'currentStepIndex' => $currentStepIndex,
        ]);

        $this->wizardStartStep = min($this->wizardMaxStep(), $currentStepIndex + 2);
    }

    /**
     * Allinea lo step server-side al footer Filament (indice 0-based come {@see Wizard::getCurrentStepIndex()}).
     */
    public function previousStep(): void
    {
        $key = $this->getWizardComponentKey();
        $wizard = $this->getSchemaComponent($key);
        if (! $wizard instanceof Wizard) {
            return;
        }

        $currentStepIndex = $wizard->getCurrentStepIndex();

        $this->callSchemaComponentMethod($key, 'previousStep', [
            'currentStepIndex' => $currentStepIndex,
        ]);

        $this->wizardStartStep = max(1, $currentStepIndex);
    }

    /**
     * Naviga a uno step specifico per nome.
     */
    public function goToStep(string $stepName): void
    {
        $key = $this->getWizardComponentKey();

        $this->callSchemaComponentMethod($key, 'goToStep', [
            'step' => $stepName,
        ]);
    }
}
