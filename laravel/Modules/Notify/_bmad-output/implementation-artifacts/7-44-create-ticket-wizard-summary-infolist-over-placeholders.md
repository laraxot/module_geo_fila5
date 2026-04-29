# Story 7-44: CreateTicketWizardWidget — `getSummarySchema()` deve preferire Infolist al posto dei Placeholder

**Stato**: ready-for-dev  
**Epic**: 7 (Ticket wizard — `tests.segnalazione-crea`)  
**Ultimo aggiornamento documento**: 2026-04-14

---

## Story

Come **sviluppatore che mantiene il wizard di creazione Ticket**,  
voglio che `getSummarySchema()` usi componenti **Filament Infolist** invece di `Placeholder`,  
così lo step finale di review rispetta il contratto semantico corretto: dati raccolti da mostrare = display read-only strutturato.

---

## Perché questa story esiste

Lo stato attuale di [CreateTicketWizardWidget.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php) usa `Placeholder` nel metodo `getSummarySchema()`.

Questo è debole per tre motivi:

1. `Placeholder` è adatto a testo/UI arbitraria, non a un riepilogo dati strutturato.
2. Il riepilogo finale del wizard è semanticamente un **read-only details view**.
3. Filament offre già il linguaggio giusto per questa responsabilità: **Infolists**.

La regola quindi non è “preferenza di stile”, ma allineamento al modello mentale Filament:

- form fields → input
- infolist entries → display
- schema/layout → struttura

---

## Fonte ufficiale

Filament dice esplicitamente che gli **entry classes** di Infolist servono a mostrare una lista read-only di dati, e che il loro contenuto è lo `state`, impostabile anche manualmente con `state()`. Inoltre è possibile leggere lo stato di altri campi tramite `Get`.

Fonte primaria:
- https://filamentphp.com/docs/5.x/infolists/overview

Punti rilevanti dalla doc:

- `Filament\Infolists\Components\TextEntry` è il componente naturale per dati testuali read-only.
- `state()` permette di mostrare dati che non arrivano direttamente da un record Eloquent.
- `placeholder()` esiste anche per gli entry, quindi il fallback visuale resta disponibile senza dover usare `Placeholder`.
- `Get` può leggere lo stato di altri campi del form/schema.

---

## Visione / filosofia / zen

- Il riepilogo non deve fingersi UI generica.
- Il riepilogo è l'ultimo passo prima dell'azione irreversibile: deve parlare la lingua del “review”.
- Se un componente dice “sono un entry read-only”, comunica correttamente l'intento del codice.
- Se un componente dice “sono un placeholder”, comunica contenuto accessorio, non dati strutturati.
- In Filament è meglio usare il linguaggio del framework invece di piegare un componente generico a un ruolo specifico.

---

## Regola architetturale

Per `getSummarySchema()` del wizard:

- preferire `Filament\Infolists\Components\TextEntry`, `IconEntry`, `ImageEntry`, `RepeatableEntry` quando applicabili;
- usare `Placeholder` solo per contenuto accessorio o testo non modellabile come entry;
- leggere i valori via `Get` / `state()` quando il riepilogo dipende dallo stato del wizard e non da un record persistito;
- non usare campi form disabilitati come finto riepilogo;
- non usare Blade custom o HTML arbitrario se la stessa cosa è esprimibile con Infolist.

---

## Implementazione attesa

### Stato corrente

Oggi il riepilogo usa blocchi come:

- `Placeholder::make('review_name')`
- `Placeholder::make('review_type')`
- `Placeholder::make('review_address')`
- `Placeholder::make('review_content')`
- `Placeholder::make('review_email')`

### Stato target

Il riepilogo deve essere migrato verso Infolist entries, ad esempio:

- `TextEntry` per nome, indirizzo, contenuto, email
- `TextEntry` o `Badge`/entry equivalente per il tipo disservizio
- `TextEntry` per conteggio immagini o testo immagini caricate

Note:

- `ImageEntry` va usato solo se il dato è davvero disponibile in modo sicuro come immagine renderizzabile nel contesto pre-submit.
- Se il riepilogo pre-submit ha solo percorsi temporanei/non stabili, meglio un `TextEntry` di conteggio o stato.

### Meccanica attesa

- Gli entry devono leggere i dati con `state(fn (Get $get) => ...)` o pattern equivalente supportato.
- I fallback di assenza dato devono stare negli entry (`placeholder()` / `default()`), non in `Placeholder`.
- La struttura può restare dentro `Section` / `Grid`, ma il contenuto read-only deve essere Infolist.

---

## Acceptance Criteria

```gherkin
Feature: Summary schema con Infolist

  Scenario: Riepilogo semantico
    Dato che apro lo step finale del wizard
    Quando i dati raccolti vengono mostrati
    Allora il contenuto read-only del riepilogo usa entry di Infolist
    E non Placeholder generici

  Scenario: Lettura stato wizard
    Dato che il wizard non è ancora un record persistito
    Quando il riepilogo legge i dati
    Allora gli entry leggono lo stato dal form/schema tramite Get o state esplicito

  Scenario: Fallback empty state
    Dato che un campo del riepilogo è vuoto
    Quando la UI lo mostra
    Allora il fallback viene gestito con le API dell'entry
    E non con Placeholder usato come pseudo-entry

  Scenario: Coerenza Filament-first
    Dato che il riepilogo è uno schermo di review
    Allora il codice segue il linguaggio Filament display-only
    E non ricade in workaround generici o HTML custom evitabile
```

---

## File candidati

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `.memory-bank/systemPatterns.md`

---

## Guardrail

- Niente hardcode italiano nel runtime.
- Niente `TextInput::disabled()` come finto review layer.
- Niente ritorno a partial Blade custom se Infolist copre il caso.
- `Placeholder` resta consentito solo per contenuto accessorio, non come struttura primaria del summary.

---

## Change Log

| Data | Autore | Descrizione |
|------|--------|-------------|
| 2026-04-14 | Codex | Story creata per fissare Infolist come scelta primaria nel summary del wizard |

---

## Status

ready-for-dev
