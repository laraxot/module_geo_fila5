# Story 7.30: segnalazione-crea - recovery runtime, checkbox privacy, i18n e visual parity step 1

Status: ready-for-dev

## Story

Come **sviluppatore del modulo Fixcity e del tema Sixteen**,
voglio ripristinare e riallineare lo **step 1 (privacy)** di `segnalazione-crea` rispetto al reference Design Comuni,
cosi che la pagina torni stabile (`200`), il checkbox sia visibile, le traduzioni non escano come chiavi raw e il pulsante `Avanti` abbia tipografia e colore corretti su desktop, tablet e mobile.

## Contesto

### Sorgenti confrontate

- Locale target: `http://127.0.0.1:8001/it/tests/segnalazione-crea`
- Reference ufficiale: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html`
- Story collegata: [7-2 segnalazione-crea step1 parity checkbox navigation](./7-2-segnalazione-crea-step1-parity-checkbox-navigation.md)

### Problemi segnalati dall'utente

1. Nella pagina `segnalazione-crea` **il checkbox privacy non si vede** o non rispetta il reference.
2. Mancano o vengono mostrate raw le traduzioni:
   - `fixcity::segnalazione.steps.privacy.label`
   - `fixcity::segnalazione.actions.next.label`
3. Il testo dentro il pulsante `Avanti` **non deve essere nero** e **non deve usare quel font**.
4. Va ricontrollata meglio la **visual parity** con il reference `segnalazione-01-privacy`, non solo il singolo checkbox.
5. La documentazione operativa deve essere aggiornata in modo sistematico dentro **moduli** e **temi**, usando **indici** e collegamenti relativi bidirezionali.

### Evidenze tecniche gia raccolte

- Il route target su `:8001` al momento del triage ha restituito una pagina di **Internal Server Error**, quindi la story deve includere anche il **ripristino runtime** prima della parity visuale.
- In `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` lo step 1 usa:
  - `__('fixcity::segnalazione.steps.privacy.label')` per lo stepper
  - `__('fixcity::segnalazione.actions.next.label')` per il CTA `Avanti`
- Le chiavi risultano gia presenti in:
  - `laravel/Modules/Fixcity/lang/it/segnalazione.php`
  - `laravel/Modules/Fixcity/lang/en/segnalazione.php`
- Questo indica che il problema non e necessariamente “aggiungere le traduzioni”, ma puo essere uno di questi:
  - namespace traduzioni non caricato / provider non bootstrappato correttamente
  - cache traduzioni / config / view incoerente
  - fallback locale errato
  - blocco/wizard che mescola stringhe CMS e chiavi traduzione senza risoluzione consistente
- Il wizard e Livewire puro e la parity deve privilegiare **CSS/JS + pipeline traduzioni**; evitare rewrite HTML non necessari.

### Vincoli non negoziabili

1. **Preservare l'architettura corrente**: mantenere `CreateTicketWizardWidget` e la view `ticket-create-wizard.blade.php`.
2. **Preferire fix CSS/JS/i18n pipeline**: non introdurre refactor strutturali gratuiti nel markup.
3. **Parity guidata da reference**: verificare lo step 1 contro `segnalazione-01-privacy` su desktop, tablet e mobile.
4. **Documentazione sempre aggiornata**: aggiornare docs di modulo e tema e i relativi indici con link bidirezionali.
5. **No hardcoded regressivi**: non sostituire una chiave traduzione con testo italiano hardcoded solo per nascondere il problema.

## Acceptance Criteria

1. `http://127.0.0.1:8001/it/tests/segnalazione-crea` risponde `200` e lo step 1 privacy renderizza senza errori runtime.
2. Il checkbox privacy dello step 1 e visibile, cliccabile e coerente con il reference Bootstrap Italia / Design Comuni su desktop, tablet e mobile.
3. Le label dello stepper e del CTA non mostrano chiavi raw (`fixcity::...`) ma testo tradotto corretto; il caricamento traduzioni e stabile almeno per `it` ed `en`.
4. Il pulsante `Avanti` ha **colore testo, font-family, font-size, font-weight e contrasto** coerenti con il reference; il testo non appare nero e non eredita font errati.
5. La visual parity dello step 1 viene rivalutata in modo screenshot-driven rispetto al reference, includendo almeno: titolo, stepper, testo privacy, checkbox/label e CTA.
6. Le eventuali correzioni restano compatibili con la HTML parity del wizard: se serve toccare il markup, deve essere minimo e motivato; la strada preferita resta CSS/JS/i18n.
7. Documentazione aggiornata in:
   - `laravel/Modules/Fixcity/docs/`
   - `laravel/Themes/Sixteen/docs/`
   con relativi **index/README** aggiornati e collegamenti relativi bidirezionali verso story, docs parity e file sorgente rilevanti.
8. Se dall'analisi emerge una nuova regola stabile su namespace traduzioni / parity wizard / fix CSS page-scoped, questa viene codificata nei documenti di regola pertinenti e referenziata dagli indici.

## Tasks / Subtasks

### Task 1 - Ripristino runtime e root cause (AC: 1)
- [ ] Riprodurre il problema su `:8001` e catturare l'eccezione reale da log / response debug.
- [ ] Identificare se il `500` dipende da bootstrap traduzioni, view, cache o altro runtime del wizard.
- [ ] Ripristinare risposta `200` senza introdurre workaround fragili.
- [ ] Verificare `php -l` sui file PHP/Blade toccati e `curl` finale con codice `200`.

### Task 2 - Audit i18n stepper e CTA (AC: 3, 6)
- [ ] Verificare il flusso completo delle chiavi `fixcity::segnalazione.steps.privacy.label` e `fixcity::segnalazione.actions.next.label` dal lang file al render Livewire.
- [ ] Confermare se le chiavi esistono gia e correggere il punto reale di rottura invece di duplicare inutilmente le traduzioni.
- [ ] Allineare l'uso di stringhe CMS e traduzioni nel wizard per evitare output raw o fallback incoerenti.
- [ ] Testare almeno `it` ed `en` sul wizard.

### Task 3 - Checkbox privacy parity (AC: 2, 5)
- [ ] Confrontare checkbox e label dello step 1 con il reference `segnalazione-01-privacy`.
- [ ] Verificare computed styles, pseudo-elementi, `appearance`, `opacity`, `position`, contrasto e area cliccabile.
- [ ] Correggere in `segnalazione-parity.css` gli override page-scoped del wizard se il checkbox e ancora invisibile o stilato male.
- [ ] Verificare la resa su desktop, tablet e mobile.

### Task 4 - CTA `Avanti` visual parity (AC: 4, 5, 6)
- [ ] Analizzare il bottone step 1 / nav stepper rispetto al reference: colore testo, font, weight, size, padding, iconografia e allineamento.
- [ ] Correggere i soli layer necessari in CSS page-scoped del wizard per evitare testo nero o font errato.
- [ ] Verificare che il fix non rompa gli altri CTA del flusso (`Indietro`, `Conferma`, `Salva`).

### Task 5 - Screenshot-driven parity pass (AC: 5)
- [ ] Catturare o aggiornare screenshot locale/reference per lo step 1 privacy su desktop, tablet e mobile.
- [ ] Documentare i delta residui visivi piu importanti e chiuderli o motivarli.

### Task 6 - Documentazione, regole e indici (AC: 7, 8)
- [ ] Aggiornare `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md` con root cause e fix effettivo.
- [ ] Aggiornare l'indice modulo (`laravel/Modules/Fixcity/docs/README.md`) con riferimento alla story e alla regola emersa.
- [ ] Aggiornare la documentazione tema pertinente in `laravel/Themes/Sixteen/docs/` e il relativo indice/README.
- [ ] Se emerge una regola stabile su traduzioni / wizard parity / CSS scope, registrarla in un doc di regola esistente o nuovo, con link bidirezionali dagli indici.

## Dev Notes

### File molto probabili

| Area | Path |
|------|------|
| Widget Livewire | `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` |
| View wizard | `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` |
| Traduzioni | `laravel/Modules/Fixcity/lang/it/segnalazione.php` |
| Traduzioni | `laravel/Modules/Fixcity/lang/en/segnalazione.php` |
| Content JSON | `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-crea.json` |
| CSS parity | `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` |
| Doc wizard | `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md` |
| Indice modulo | `laravel/Modules/Fixcity/docs/README.md` |
| Indice tema | `laravel/Themes/Sixteen/docs/design-comuni/README.md` |

### Note operative importanti

- Le chiavi traduzione richieste dall'utente risultano gia presenti nei file lingua: prima verificare **namespace load / cache / fallback / provider**, poi solo eventualmente aggiungere o ristrutturare chiavi.
- Il JSON CMS di `tests.segnalazione-crea` contiene oggi molte stringhe italiane/inglesi gia materializzate; il dev deve evitare di mescolare in modo incoerente testo pronto e chiavi `fixcity::...` nello stesso flusso.
- Il fix del bottone deve preservare la parity HTML: lavorare prima su CSS page-scoped e solo dopo, se indispensabile, su minimi aggiustamenti view.
- Il checkbox e il CTA devono essere verificati anche su **tablet**, non solo desktop/mobile.

### Verifica minima richiesta

- `curl -s -o /dev/null -w '%{http_code}' http://127.0.0.1:8001/it/tests/segnalazione-crea`
- `php -l` sui file PHP/Blade toccati
- build tema: `npm run build` e `npm run copy` in `laravel/Themes/Sixteen`
- verifica screenshot o evidenze equivalenti desktop/tablet/mobile

## Project context reference

- [7-2 segnalazione-crea step1 parity checkbox navigation](./7-2-segnalazione-crea-step1-parity-checkbox-navigation.md)
- [Ticket Wizard Frontoffice](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md)
- [Fixcity Docs README](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Fixcity/docs/README.md)
- [Sixteen Design Comuni README](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/design-comuni/README.md)
