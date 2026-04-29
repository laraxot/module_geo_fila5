# Story 7-50: segnalazione-crea step2 — high html parity + altissima visual parity

**Stato**: ready-for-dev  
**Epic**: 7 (Ticket wizard unificato)  
**Ultimo aggiornamento**: 2026-04-14  
**Dipendenze**: 7-45, 7-48, 7-49

---

## Story

Come cittadino che compila una segnalazione,  
voglio che lo step `dati-della-segnalazione` del wizard `segnalazione-crea` sia semanticamente e visivamente allineato al riferimento Design Comuni,  
cosi da avere fiducia, chiarezza e continuita UX durante la compilazione.

Riferimento canonico: [segnalazione-02-dati](https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html).

---

## Perche (business logic, scopo, visione)

- **Affidabilita percepita**: una pagina istituzionale incoerente abbassa fiducia e tasso di completamento.
- **Riduzione errori utente**: gerarchia visiva e testi conformi riducono incertezze.
- **Governance DRY/KISS**: un solo pattern chiaro e riusabile per i 3 step.
- **Politica di prodotto**: Design Comuni e la baseline, non un riferimento opzionale.

---

## Gap residui da chiudere

1. Mancanza di elementi equivalenti alla colonna "Informazioni richieste" (navigazione intra-step o equivalente accessibile).
2. Required legend non stabilmente visibile nel punto corretto.
3. Sezione autore non ancora equivalente al reference (nome/cf/read-only context + contatti).
4. Etichette campi con fallback tecnici (`type`, `name`, `content`) dove devono comparire label utente.
5. Azioni finali step non completamente equivalenti (testi/ordine/stati visuali).
6. Colonna sinistra troppo stretta e con contrasto/leggibilita insufficiente: nel locale il contenuto laterale si percepisce male rispetto al reference.
7. Colonna centrale troppo stretta per il corpo form, con ritmo verticale troppo lasco tra heading, legend, section e campi.
8. Header top-level del sito con copy come `Accedi all'area personale` poco leggibile nel contesto locale rispetto al reference; la parity non puo fermarsi al solo card form.

---

## Evidenza raccolta

- URL locale verificata: `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step`
- HTTP smoke: `200 OK`
- Screenshot locale acquisito: `/tmp/fixcity-step2-local.png`
- Screenshot reference acquisito: `/tmp/fixcity-step2-reference.png`

Osservazioni consolidate dagli screenshot:

- la colonna sinistra locale appare piu compressa del reference e perde funzione orientativa;
- il contenitore centrale del wizard non sfrutta larghezza sufficiente, quindi le tre sezioni non respirano come nel reference;
- il vertical spacing locale e eccessivo e produce una pagina piu lunga e meno densa del dovuto;
- la leggibilita dell'header superiore resta inferiore al reference e danneggia la percezione istituzionale dell'intera pagina.

---

## Acceptance Criteria (BDD)

### AC1 — Struttura step 2
**GIVEN** la pagina `tests/segnalazione-crea` allo step `dati-della-segnalazione`  
**WHEN** viene renderizzato il form  
**THEN** esistono blocchi chiari e consistenti per `Luogo`, `Disservizio`, `Autore della segnalazione`.

### AC2 — Required legend
**GIVEN** l'inizio dello step 2  
**WHEN** utente arriva alla sezione dati  
**THEN** la legenda campi obbligatori e visibile prima dei campi principali.

### AC3 — Label utente (no chiavi tecniche visibili)
**GIVEN** i campi principali dello step 2  
**WHEN** il form e renderizzato  
**THEN** nessun campo mostra label tecniche (`type`, `name`, `content`) e tutte le label risultano human-readable via i18n.

### AC4 — Sezione autore ad alta parity
**GIVEN** utente autenticato  
**WHEN** visualizza la sezione autore  
**THEN** vede una sintesi read-only (nome + identificativo) e un blocco contatti coerente col reference.

### AC5 — Bottoni azione coerenti
**GIVEN** footer dello step 2  
**WHEN** i controlli sono visibili  
**THEN** i tre controlli (indietro/salva/avanti) rispettano ruolo, ordine e stile del reference.

### AC6 — Colonne e densita verticale ad alta parity
**GIVEN** lo step 2 desktop  
**WHEN** si confronta locale e reference  
**THEN** la colonna laterale informativa e la colonna centrale del form hanno proporzioni leggibili e il vertical rhythm non risulta piu eccessivamente dispersivo.

### AC7 — Header page-level leggibile
**GIVEN** l'intera pagina `segnalazione-crea`  
**WHEN** viene confrontata con il reference  
**THEN** la zona header/topbar mantiene leggibilita sufficiente, inclusi i link di accesso personale e ricerca, senza trattare il wizard come isola separata dal resto del layout.

### AC8 — Nessuna regressione tecnica
**GIVEN** il refactor parity  
**WHEN** si eseguono verifiche minime  
**THEN** nessun loop runtime, nessun class-not-found, nessuna regressione step 1/step 3.

---

## Technical guardrails

- Usare componenti `Filament\Schemas` per `get*Schema()` del wizard.
- I `Placeholder` del form non sono il target finale: per dati read-only strutturati usare `Infolists`; per copy editoriale/legale usare `Schemas\Text`.
- Evitare nuove sezioni annidate inutili nello step 2.
- CSS solo page-scoped su `div.page-content[data-slug="tests.segnalazione-crea"]`.
- Nessuna body class per parity.
- Mantenere naming doc in minuscolo (eccetto `README.md`).
- Trattare la parity a livello pagina, non solo a livello card del wizard.
- Usare screenshot locale/reference come evidenza minima prima di dichiarare "alta parity" o "visual parity altissima".

---

## File target previsti

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`
- `laravel/Modules/Fixcity/lang/it/*.php` e `lang/en/*.php` (solo chiavi realmente usate)
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Themes/Sixteen/docs/design-comuni/TICKET-CREATION-WIZARD.md`

---

## Piano test minimo

1. Screenshot desktop + mobile step 2 locale.
2. Screenshot reference Design Comuni.
3. Verifica visiva differenze su: heading, legend, labels, autore, bottoni.
4. Verifica visiva differenze su: larghezza colonna sinistra, larghezza colonna centrale, densita verticale, header.
5. `php -l` su widget.
6. Build theme (`npm run build && npm run copy`).

---

## Definition of done

- AC1..AC6 rispettati.
- Story e docs aggiornate con rationale + regole anti-regressione.
- Stato story impostato `ready-for-dev`.

---

## execution notes (2026-04-14)

- Corretto runtime blocker `Placeholder::make()` nello step privacy usando `Text::make(...)` (Schemas).
- Corretto runtime blocker `TextEntry::make()` nella sezione autore usando `Text::make(...)`.
- Evitato uso metodi non supportati da `AddressInput` (`placeholder`/`helperText`), mantenendo API compatibile.
- Ripristinata applicazione CSS parity aggiungendo wrapper `ticket-wizard-root` in Blade.
- Aggiunta required legend sopra al wizard, allineata al reference.
