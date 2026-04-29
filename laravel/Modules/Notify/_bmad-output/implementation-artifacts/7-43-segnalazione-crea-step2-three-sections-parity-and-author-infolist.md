# Story 7-43: segnalazione-crea — step 2 con tre sezioni, parity HTML/visuale e autore via Infolist

**Stato**: ready-for-dev  
**Epic**: 7 (Ticket wizard — `tests.segnalazione-crea`)  
**URL locale verifica**: `http://127.0.0.1:8001/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step`  
**Reference parity**: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`  
**Ultimo aggiornamento documento**: 2026-04-14

---

## Story

Come **utente che compila lo step 2 del wizard segnalazione**,  
voglio ritrovare la stessa struttura e lo stesso ritmo del reference Design Comuni,  
così la pagina locale comunica chiaramente le tre aree del task:

- luogo
- disservizio
- autore della segnalazione

e l'autore viene mostrato come informazione già nota, non come form confuso.

---

## Perché esiste questa story

Lo stato attuale del widget `CreateTicketWizardWidget` non rispetta ancora il contratto editoriale dello step 2:

- `getDataSchema()` è piatto;
- mancano le tre sezioni esplicite del reference;
- il blocco autore non è modellato come card informativa/read-only;
- il reference Design Comuni tratta `Autore della segnalazione` come riepilogo informativo, non come gruppo di input libero;
- il sito è multilingua, quindi titoli, descrizioni e microcopy non possono essere hardcoded nel PHP.

Questa story esiste per fissare il pattern corretto prima dell'implementazione.

---

## Evidenza raccolta

### Runtime locale reale

- La URL locale su `:8001` risponde `HTTP 200`.
- Il wizard attuale è renderizzato dal widget `CreateTicketWizardWidget`.

### Stato corrente del widget

In [CreateTicketWizardWidget.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php) oggi `getDataSchema()` contiene solo:

- `name`
- `type`
- `content`
- `email`

Quindi manca già a livello di schema il contratto paritario richiesto dallo step 2:

- `Luogo`
- `Disservizio`
- `Autore della segnalazione`

### Reference ufficiale Design Comuni

Dal reference `segnalazione-02-dati.html` risultano chiaramente:

1. sezione `Luogo`
2. sezione `Disservizio`
3. sezione `Autore della segnalazione`

e dentro autore compaiono dati read-only tipo:

- nome
- codice fiscale
- contatti

Fonte:
- https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html

---

## Visione / filosofia / zen

- Lo step 2 non è un secchio di campi: è una pagina con tre capitoli semantici.
- I campi editabili e le informazioni read-only non vanno trattati allo stesso modo.
- Se un dato è “autore noto”, la UI corretta è informativa, non pseudo-editabile.
- In Filament, quando una parte dello step è read-only, **Infolist** è il linguaggio giusto più di un form fake.
- Multilingua significa che il dominio PHP descrive struttura e intenti, mentre il testo utente vive in lang/CMS.

---

## Regole architetturali

1. Lo step `data` deve essere articolato in **tre sezioni esplicite** allineate al reference.
2. La sezione `Autore della segnalazione` deve preferire una resa **Filament Infolist** o equivalente read-only realmente idiomatico.
3. `Luogo` resta nel dominio Geo tramite `AddressInput`; Fixcity lo consuma ma non duplica la logica geo.
4. `Disservizio` resta form-first perché contiene input veri.
5. Nessuna stringa utente in italiano dentro PHP/JS: usare chiavi traduzione stabili e atomiche.
6. HTML parity e visual parity vanno cercate senza tornare a un wizard Blade custom.

---

## Implementazione attesa

### 1. Struttura step 2

`getDataSchema()` deve esprimere tre blocchi distinti:

- `Luogo`
- `Disservizio`
- `Autore della segnalazione`

Il mapping atteso è:

- `Luogo`
  - titolo sezione
  - descrizione breve
  - `AddressInput`
  - CTA geolocalizzazione

- `Disservizio`
  - `type`
  - `name`
  - `content`
  - `images`

- `Autore della segnalazione`
  - card informativa read-only per utente autenticato o dati già noti
  - eventuale fallback form solo per guest se il prodotto lo richiede davvero

### 2. Autore tramite Infolist

Per la sezione autore, preferire **Filament Infolist** perché:

- è semanticamente read-only;
- comunica meglio “dato già presente”;
- si allinea al reference che mostra una card informativa;
- evita di simulare campi editabili dove non serve.

Uso atteso:

- nome autore
- codice fiscale se disponibile
- contatti

Se il contesto tecnico impedisce un embedding sicuro dell'Infolist direttamente nello schema form, il dev agent deve:

- documentare il limite;
- usare la soluzione read-only più vicina al contratto Infolist;
- non regredire su performance/runtime.

### 3. Multilingua

Tutti i testi di sezione e supporto devono stare in traduzioni, con chiavi stabili del tipo:

- `fixcity::segnalazione.sections.place.title`
- `fixcity::segnalazione.sections.place.description`
- `fixcity::segnalazione.sections.issue.title`
- `fixcity::segnalazione.sections.author.title`

Le chiavi finali devono restare atomiche:

- `label`
- `title`
- `description`
- `text`

mai fusioni ambigue.

### 4. Parity

L'implementazione deve inseguire due target insieme:

- **HTML parity** con il reference
- **visual parity** con il reference

Elementi da allineare:

- indice laterale con tre voci
- heading delle tre sezioni
- sottotitoli descrittivi
- card grey/background rhythm
- upload area nella sezione disservizio
- card autore con gerarchia visiva coerente

---

## Acceptance Criteria

```gherkin
Feature: Step 2 parity a tre sezioni

  Scenario: Struttura step 2
    Dato che apro lo step 2 del wizard
    Quando la pagina viene renderizzata
    Allora vedo tre sezioni semantiche distinte
    E le sezioni sono Luogo, Disservizio e Autore della segnalazione

  Scenario: Luogo nel dominio corretto
    Dato che la sezione Luogo è presente
    Allora usa il componente Geo proprietario per l'indirizzo
    E non duplica logica di geolocalizzazione dentro Fixcity

  Scenario: Disservizio come form
    Dato che compilo tipo, titolo, dettagli e immagini
    Allora questi campi appartengono alla sezione Disservizio
    E restano editabili come form Filament

  Scenario: Autore come informazione
    Dato che i dati autore sono già noti
    Quando la sezione Autore viene mostrata
    Allora la UI li presenta come informazione read-only
    E la resa preferita è Filament Infolist

  Scenario: Multilingua
    Dato che il sito è localizzato
    Quando cambio locale
    Allora i titoli e i testi di supporto dello step 2 arrivano dalle traduzioni
    E non da stringhe italiane hardcoded nel codice runtime

  Scenario: Parity
    Dato il reference Design Comuni dello step 2
    Quando confronto la pagina locale
    Allora la struttura HTML e la resa visiva risultano allineate quanto più possibile senza violare l'architettura Filament-first
```

---

## Task / Subtask

- [ ] Rifattorizzare `getDataSchema()` in tre sezioni canoniche
- [ ] Reinserire `AddressInput` nella sezione `Luogo`
- [ ] Portare `images` dentro `Disservizio`
- [ ] Modellare `Autore della segnalazione` come blocco read-only preferendo Infolist
- [ ] Definire fallback coerente per guest vs utente autenticato
- [ ] Allineare indice laterale e heading alle tre sezioni reali
- [ ] Aggiornare traduzioni senza hardcode italiano
- [ ] Verificare parity HTML/visuale contro il reference
- [ ] Aggiornare docs modulo/tema/indici dopo l'implementazione

---

## File candidati

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Modules/Geo/resources/views/filament/forms/components/address-input.blade.php`
- `laravel/Modules/Fixcity/lang/it/segnalazione.php`
- `laravel/Modules/Fixcity/lang/en/segnalazione.php`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md`
- `laravel/Themes/Sixteen/docs/design-comuni/` documentazione parity step 2

---

## Fonti

- Design Comuni step 2 reference:  
  https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html
- Filament Forms overview:  
  https://filamentphp.com/docs/5.x/forms/overview
- Filament Infolists overview:  
  https://filamentphp.com/docs/5.x/infolists/overview

---

## Change Log

| Data | Autore | Descrizione |
|------|--------|-------------|
| 2026-04-14 | Codex | Story creata per parity step 2 a tre sezioni con autore read-only via Infolist |

---

## Status

ready-for-dev
