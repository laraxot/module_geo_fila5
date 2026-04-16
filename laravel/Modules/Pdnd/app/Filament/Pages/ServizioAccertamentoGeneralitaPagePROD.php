<?php

declare(strict_types=1);

namespace Modules\Pdnd\Filament\Pages;

use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Log;
use Modules\Pdnd\Services\Anpr\Services\C015\C015Service;
use Modules\Pdnd\Services\Anpr\Services\C030\C030Service;
use Modules\Pdnd\Services\Anpr\Shared\Models\Enums\ServizioAnprEnum;
use Modules\Pdnd\Services\PdndClientService;
use Modules\Xot\Filament\Pages\XotBasePage;
use Throwable;

/**
 * @property Schema $pdndForm
 */
class ServizioAccertamentoGeneralitaPagePROD extends XotBasePage
{
    /** @var array<string, mixed> */
    public array $pdndData = [];

    public string $idAnpr = '';
    public array $datiCittadino = [];
    public bool $esitoPositivo = false;

    protected string $view = 'pdnd::filament.pages.C015-servizioAccertamentoGeneralita-approvazione_autom';

    private const CODICE_FISCALE_REGEX = '/^[A-Za-z]{6}[0-9]{2}[A-Za-z]{1}[0-9]{2}[A-Za-z]{1}[0-9]{3}[A-Za-z]{1}$/';
    private const CODICE_FISCALE_LENGTH = 16;
    private const AMBIENTE_ANPR = 'prod';

    public function pdndForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('codiceFiscale')
                    ->regex(self::CODICE_FISCALE_REGEX)
                    ->maxLength(self::CODICE_FISCALE_LENGTH)
                    ->minLength(self::CODICE_FISCALE_LENGTH)
                    ->rule('size:' . self::CODICE_FISCALE_LENGTH)
                    ->autocapitalize()
                    ->alphaNum()
                    ->required()
                    ->helperText('Inserire un codice fiscale italiano valido (16 caratteri)'),
            ])
            ->statePath('pdndData');
    }

    public function send(): void
    {
        $this->resetRisultato();
        $this->validate();

        try {
            $state = $this->pdndForm->getState();
            $codiceFiscale = $this->validateCodiceFiscale($state);

            $risultato = $this->accertamentoGeneralita($codiceFiscale);

            // dddx($risultato);

            if ($this->isAccertamentoSuccessful($risultato)) {
                $this->handleAccertamentoSuccessful($risultato);
            } else {
                $this->handleAccertamentoFailed($risultato);
            }
        } catch (Exception $e) {
            Log::error('Errore in send(): ' . $e->getMessage());
            Notification::make()
                ->title('Errore imprevisto')
                ->danger()
                ->persistent()
                ->send();
        }
    }



    // ====================== FLUSSO C030 → C015 ======================
    private function accertamentoGeneralita(string $codiceFiscale): array
    {
        try {
            // 1. Recupero idAnpr tramite C030
            $idAnpr = $this->recuperaIdAnprDaC030($codiceFiscale);

            if (empty($idAnpr)) {
                throw new Exception("Impossibile ottenere ID ANPR tramite C030");
            }

            $this->idAnpr = $idAnpr;

            // 2. Chiamata a C015 usando l'idANPR
            $c015Service = $this->createC015Service();
            return $c015Service->accertamentoPerIdAnpr($idAnpr);

        } catch (Throwable $e) {
            Log::error('Errore flusso C030 → C015', [
                'codice_fiscale' => $codiceFiscale,
                'ambiente' => self::AMBIENTE_ANPR,
                'exception' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    private function recuperaIdAnprDaC030(string $codiceFiscale): ?string
    {
        $c030Service = new C030Service(app()->make(PdndClientService::class, [
            'servizio' => ServizioAnprEnum::C030,
            'ambiente' => self::AMBIENTE_ANPR,
        ]));

        $risultatoC030 = $c030Service->cercaPerCodiceFiscale($codiceFiscale);

        // Estrazione idANPR (struttura identica a C007/C015)
        return $risultatoC030['lista_soggetti'][0]['identificativi']['idANPR']
            ?? $risultatoC030['lista_soggetti'][0]['idANPR']
            ?? $risultatoC030['idAnpr']
            ?? null;
    }


    private function createC015Service(): C015Service
    {
        $pdndClient = app()->make(PdndClientService::class, [
            'servizio' => ServizioAnprEnum::C015,
            'ambiente' => self::AMBIENTE_ANPR,
        ]);
        return new C015Service($pdndClient);
    }

    // ====================== METODI DI SUPPORTO (stile C007) ======================
    private function isAccertamentoSuccessful(array $risultato): bool
    {
        return isset($risultato['successo']) && $risultato['successo'] === true;
    }

    private function handleAccertamentoSuccessful(array $risultato): void
    {
        $listaSoggetti = $risultato['lista_soggetti'] ?? [];

        if (empty($listaSoggetti)) {
            $this->esitoPositivo = false;
            $this->notifyWarning('Nessun soggetto trovato');
            return;
        }

        $primoSoggetto = $listaSoggetti[0];

        $this->datiCittadino = [
            'generalita'     => $primoSoggetto['generalita'] ?? [],
            'stato_civile'   => $primoSoggetto['stato_civile'] ?? [],
            'identificativi' => $primoSoggetto['identificativi'] ?? [],
            'info_ente'      => $primoSoggetto['info_soggetto_ente'] ?? [],
        ];

        $this->esitoPositivo = true;
        $this->notifySuccess();
    }

    private function handleAccertamentoFailed(array $risultato): void
    {
        $this->notifyError('Accertamento Fallito', $this->formatErrorBody($risultato));
    }

    private function notifySuccess(): void
    {
        Notification::make()
            ->title('Accertamento completato')
            ->body('I dati di generalità del cittadino sono stati recuperati.')
            ->success()
            ->send();
    }

    private function notifyWarning(string $message): void
    {
        Notification::make()->title('Attenzione')->body($message)->warning()->send();
    }

    private function notifyError(string $title, string $body): void
    {
        Notification::make()->title($title)->body($body)->danger()->persistent()->send();
    }

    private function resetRisultato(): void
    {
        $this->idAnpr = '';
        $this->datiCittadino = [];
        $this->esitoPositivo = false;
    }

    private function validateCodiceFiscale(array $state): string
    {
        $cf = $state['codiceFiscale'] ?? '';
        if (!is_string($cf) || empty($cf)) {
            throw new Exception('Codice fiscale obbligatorio');
        }
        return strtoupper(trim($cf));
    }

    protected function formatErrorBody(array $risultato): string
    {
        $errori = $risultato['errori'] ?? [];
        if (empty($errori)) {
            return 'Errore sconosciuto';
        }

        $lines = array_map(static fn(array $e) => sprintf(
            'Codice: %s | Messaggio: %s',
            $e['codiceErroreAnomalia'] ?? 'N/A',
            $e['testoErroreAnomalia'] ?? 'N/A'
        ), $errori);

        return implode("\n", $lines);
    }

    protected function getForms(): array { return ['pdndForm']; }

    protected function getPdndFormActions(): array
    {
        return [Action::make('pdndFormActions')->submit('pdndFormActions')];
    }
}