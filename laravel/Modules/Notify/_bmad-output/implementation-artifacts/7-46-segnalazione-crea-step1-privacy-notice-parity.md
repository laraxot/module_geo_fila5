# Story 7-46: segnalazione-crea — step 1 privacy notice con parity visuale verso Design Comuni

**Stato**: ready-for-dev  
**Epic**: 7 (Ticket wizard — `tests.segnalazione-crea`)  
**URL locale verifica**: `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.privacy-e-condizioni%3A%3Adata%3A%3Awizard-step`  
**Reference parity**: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html`  
**Ultimo aggiornamento documento**: 2026-04-14

---

## Story

Come **utente che apre lo step 1 del wizard segnalazione**,  
voglio vedere il blocco informativo privacy completo prima del checkbox,  
così capisco cosa sto autorizzando e la pagina locale resta visivamente e semanticamente allineata al reference Design Comuni.

---

## Perché esiste questa story

Nella URL locale dello step privacy il wizard risponde `200`, ma manca ancora il contenuto editoriale fondamentale che nel reference compare sopra al checkbox:

> Il Comune di Firenze gestisce i dati personali forniti e liberamente comunicati...

Nel widget attuale `getPrivacySchema()` espone solo:

- `Checkbox::make('privacyAccepted')`

Quindi il problema non è il checkbox. Il problema è che manca un vero **privacy notice read-only** con:

- testo introduttivo
- link all’informativa
- gerarchia visiva coerente con Design Comuni

---

## Evidenza esterna

Reference ufficiale Design Comuni:
- https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html

Il reference contiene esplicitamente:

- stepper con `Autorizzazioni e condizioni`
- paragrafo legale introduttivo
- link all’informativa privacy
- checkbox finale di accettazione

Filament docs rilevanti:
- Infolists Overview: https://filamentphp.com/docs/5.x/infolists/overview

Filament chiarisce che gli **Infolists** servono a mostrare dati/contenuti read-only in modo strutturato. Per questo step il blocco privacy non è input: è contenuto informativo read-only.

---

## Visione / filosofia / zen

- La privacy notice non è una decorazione del checkbox.
- Prima viene l’informazione, poi il consenso.
- Uno step chiamato `Autorizzazioni e condizioni` senza testo legale è semanticalmente vuoto.
- Il contenuto read-only importante deve avere dignità di contenuto, non sembrare un helper text casuale.
- Multilingua significa che quel testo va governato come contenuto localizzabile, non scritto in italiano nel PHP.

---

## Ragionamento su Infolist

Lo step privacy ha due nature diverse:

- contenuto read-only editoriale
- un singolo input (`privacyAccepted`)

Per il blocco read-only esistono tre strade:

1. `helperText` del checkbox  
   Scartato: troppo debole, semanticamente secondario, visivamente lontano dal reference.

2. Blade custom pesante  
   Rischioso: duplica markup e allontana il widget dal linguaggio Filament.

3. **componente read-only Filament**  
   Scelta preferita: usare un blocco read-only di schema, valutando **Infolist / Prime text content** come layer corretto.

Conclusione di governance:

- il testo privacy va trattato come **contenuto read-only di primo livello**
- Infolist è coerente se il contenuto viene strutturato come entry/read-only block
- se per prose lunga un Prime/Text component di Filament risulta tecnicamente più adatto, il principio resta lo stesso: **non helper text, non stringa hardcoded, non Blade duplicata**

---

## Implementazione attesa

### Struttura step 1 target

Lo step `privacy` deve contenere nell’ordine:

1. blocco informativo privacy read-only
2. link all’informativa
3. checkbox di accettazione

### Contenuto minimo atteso

- paragrafo introduttivo equivalente al reference
- CTA/link all’informativa privacy
- checkbox finale

### Regola multilingua

Il testo non va hardcodato nel widget.

Deve vivere in traduzioni o contenuto CMS con chiavi stabili, ad esempio:

- `fixcity::segnalazione.sections.privacy.notice.text`
- `fixcity::segnalazione.sections.privacy.notice_link.label`
- `fixcity::segnalazione.sections.privacy.checkbox.label`

### Regola di rendering

Il blocco privacy deve essere visualmente percepito come contenuto principale dello step, non come nota secondaria:

- larghezza coerente
- spacing coerente
- tono tipografico coerente con Design Comuni
- link ben visibile

---

## Acceptance Criteria

```gherkin
Feature: Step 1 privacy notice parity

  Scenario: Privacy notice visibile
    Dato che apro lo step 1 del wizard
    Quando la pagina viene renderizzata
    Allora vedo un blocco informativo privacy prima del checkbox

  Scenario: Consenso dopo informazione
    Dato che il blocco privacy è mostrato
    Quando osservo l'ordine dei contenuti
    Allora prima leggo l'informazione
    E solo dopo posso selezionare il checkbox

  Scenario: Multilingua
    Dato che il sito è localizzato
    Quando cambio lingua
    Allora il testo privacy e il link arrivano da traduzioni/contenuto localizzabile
    E non da stringhe italiane hardcoded nel widget

  Scenario: Parity visuale
    Dato il reference Design Comuni dello step privacy
    Quando confronto la pagina locale
    Allora il blocco informativo mancante è stato reintegrato
    E la gerarchia visiva dello step risulta più vicina al reference
```

---

## File candidati

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Modules/Fixcity/lang/it/segnalazione.php`
- `laravel/Modules/Fixcity/lang/en/segnalazione.php`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md`
- eventuale JSON CMS della pagina se il testo viene esternalizzato lì

---

## Guardrail

- Niente testo legale hardcoded nel PHP.
- Niente checkbox come unico contenuto dello step privacy.
- Niente helperText usato come surrogato del blocco legale principale.
- Preferire un componente read-only Filament coerente con il contenuto informativo.

---

## Change Log

| Data | Autore | Descrizione |
|------|--------|-------------|
| 2026-04-14 | Codex | Story creata per parity step 1 con privacy notice completo |

---

## Status

ready-for-dev
