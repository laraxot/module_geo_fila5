# story 7-48: segnalazione-crea step2 section parity and author readonly

## stato

ready-for-dev

## obiettivo

Aumentare la visual parity dello step 2 (`dati di segnalazione`) con il reference Design Comuni, strutturando il form in sezioni semantiche e rendendo il blocco autore coerente con una presentazione read-only.

## intervento

Nel widget `CreateTicketWizardWidget`:

- `getDataSchema()` ora usa tre `Section`:
  - `Luogo`
  - `Disservizio`
  - `Autore della segnalazione`
- nel blocco autore:
  - griglia read-only con nome/codice fiscale/telefono (placeholder infolist-like)
  - campo `email` come contatto modificabile
- aggiunti helper per dati utente:
  - `getAuthUserName()`
  - `getAuthUserFiscalCode()`
  - `getAuthUserPhone()`

## perche'

- migliora gerarchia visiva e comprensione, come nel reference;
- separa dati di contesto (autore) da input editabili;
- mantiene un render path stabile nel Form schema senza regressioni.

## verifica

- `php -l Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` -> OK
- `curl -I --max-time 20 "http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step"` -> `200`
- check contenuti HTML -> presenti:
  - `Luogo`
  - `Disservizio`
  - `Autore della segnalazione`
  - `Informazione su di te`

## file aggiornati

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Modules/Fixcity/docs/stories/wizard-step-2-section-parity-and-author-readonly.md`
- `laravel/Modules/Fixcity/docs/stories/index.md`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
