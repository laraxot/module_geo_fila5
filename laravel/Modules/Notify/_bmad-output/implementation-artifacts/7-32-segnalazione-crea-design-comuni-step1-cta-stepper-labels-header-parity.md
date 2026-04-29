# Story 7-32: segnalazione-crea — parity Design Comuni (step 1 CTA, label stepper, header/search/tablet-mobile)

**Stato**: review  
**Epic**: 7 (Ticket wizard — `tests.segnalazione-crea`)  
**URL verifica**: `http://127.0.0.1:8000/it/tests/segnalazione-crea`  
**Reference ufficiale**: [segnalazione-01-privacy](https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html), [segnalazione-02-dati](https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html) (navigazione step 2+)

**Ultimo aggiornamento documento**: 2026-04-09

---

## Story

Come **sviluppatore tema Sixteen + modulo Fixcity**,  
voglio allineare `segnalazione-crea` al markup e alle copy del **Design Comuni** (reference statico),  
così che **primo step dello stepper**, **CTA “Avanti” allo step 1**, **header (hamburger + Cerca)** e **layout mobile/tablet** siano coerenti con il modello di riferimento e con la documentazione interna già concordata.

---

## Contesto e vincoli

- **Business logic**: invariata (Livewire `CreateTicketWizardWidget`, tre step, submit allo step 3). Solo markup/CSS/copy/parity.
- **HTML parity**: il `<body>` resta senza classi custom (policy body plain); eventuali scope in `segnalazione-parity.css` su wrapper pagina / data-attribute (vedi story 7-27, `html-parity-body-policy.md`).
- **Story correlate** (non duplicare scope; coordinarsi):
  - **7-29**: header responsive, hamburger centrato, testo “Cerca”, lingua, colori icona — **implementare prima o in parallelo** se i problemi sono condivisi.
  - **7-30 / 7-31**: runtime, checkbox, chiavi i18n mancanti su CTA — verificare sovrapposizione con questa story.

---

## Gap rilevati (expected vs attuale)

### 1) Primo step dello stepper — etichetta errata

| Fonte | Testo primo step |
|--------|-------------------|
| **Reference** `segnalazione-01-privacy` (HTML Design Comuni) | **Autorizzazioni e condizioni** |
| **Documentazione tema** `laravel/Themes/Sixteen/docs/design-comuni/stepper-component.md` | `steps.privacy.label` → IT: **Autorizzazioni e condizioni** |
| **Attuale in app** | `fixcity::segnalazione.steps.privacy.label` = **Informativa sulla privacy** (`lang/it/segnalazione.php`) |

**Root cause**: le traduzioni del modulo non sono allineate alla tabella ufficiale del tema; il block statico `segnalazione-01-privacy.blade.php` usa le stesse chiavi del widget, quindi oggi mostra la copy sbagliata ovunque si usi `steps.privacy.label`.

**Fix atteso**: aggiornare **IT e EN** (`laravel/Modules/Fixcity/lang/it|en/segnalazione.php`) per `steps.privacy.label` (e verificare `fields.step.privacy.label` se ancora usata: deve essere coerente o deprecata a favore di una sola chiave “canonica” per lo stepper).

---

### 2) Pulsante “Avanti” allo step 1 — pattern diverso dal reference

| Fonte | Pattern |
|--------|---------|
| **Reference step 1** (`segnalazione-01-privacy`) | Dopo checkbox: un solo `<button type="button" class="btn btn-primary mobile-full">` con testo “Avanti”, **senza** `cmp-nav-steps` / chevron. |
| **Attuale wizard** (`ticket-create-wizard.blade.php`) | Per ogni step `< 3` viene renderizzato **sempre** il blocco `cmp-nav-steps` → `steppers-btn-confirm` con **icona chevron-right** come negli step successivi. |

**Fix atteso**: per **`$currentStep === 1`**, rendere la CTA come nel reference (stesso container colonna del contenuto, classi `btn btn-primary mobile-full`, testo da `fixcity::segnalazione.actions.next.label`), **senza** duplicare il pattern “steppers-nav” dello step 2.  
Per **`$currentStep >= 2`** mantenere (o affinare) il pattern `cmp-nav-steps` allineato a `segnalazione-02-dati` (Indietro, eventuali “Salva”, Avanti con chevron — come in `ref_raw.html` del tema).

---

### 3) Header: hamburger e voce “Cerca”

Copertura principale: **story 7-29** (CSS/header, `.search-label`, `.custom-navbar-toggler`, breakpoint).

**Verifica incrociata**: dopo fix 7-29, su `segnalazione-crea` deve essere visibile il testo **“Cerca”** accanto alla lente ove previsto dal reference (nessun `display:none` indebito su `.search-label` nei breakpoint mobile/tablet).

---

### 4) Stepper responsive — mobile e tablet

Il markup stepper nel widget è analogo al reference; la **responsività** dipende da CSS in `segnalazione-parity.css` e da selettori che includano il wrapper della pagina `segnalazione-crea` (vedi analisi in 7-29: estendere selettori se oggi limitati a `segnalazione-02-dati`).

**Acceptance**: confronto visivo a **375px**, **768px**, **1024px** (DevTools o screenshot in `storage/visual-parity` / docs come da convenzione progetto).

---

## File principali toccati (prevedere)

| Area | Path |
|------|------|
| Traduzioni | `laravel/Modules/Fixcity/lang/it/segnalazione.php`, `.../en/segnalazione.php` |
| Vista wizard | `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` |
| CSS parity | `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` (solo se necessario per step 1 CTA / wrapper) |
| Block statico (coerenza copy stepper) | `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-01-privacy.blade.php` (usa `$steps` da `steps.*` — beneficia del fix traduzioni) |
| Doc tema | `laravel/Themes/Sixteen/docs/design-comuni/stepper-component.md` (già corretto; aggiungere nota “allineamento modulo Fixcity verificato story 7-32” se serve) |
| Modulo | `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md` (paragrafo breve su label step 1 e CTA step 1 vs step 2+) |

**Build**: dopo modifiche CSS, `npm run build` nel tema Sixteen (e sync asset se previsto dal progetto).

---

## Acceptance criteria (BDD)

```gherkin
Feature: Parity Design Comuni su segnalazione-crea (step 1)

  Scenario: Primo step dello stepper usa la copy ufficiale
    Dato che sono su /it/tests/segnalazione-crea
    Quando visualizzo lo stepper
    Allora il primo elemento di elenco contiene il testo "Autorizzazioni e condizioni"
    E non contiene "Informativa sulla privacy" come titolo dello step

  Scenario: CTA allo step 1 come reference privacy
    Dato che sono allo step 1 del wizard
    Quando cerco il pulsante per proseguire
    Allora è presente un bottone con classi coerenti con "btn btn-primary mobile-full"
    E il testo è "Avanti" (da traduzione)
    E non è richiesto il pattern cmp-nav-steps con chevron destro tipico dello step 2

  Scenario: Step 2+ mantiene navigazione a step multipli
    Dato che sono allo step 2 o 3
    Allora è presente la navigazione tipo cmp-nav-steps / steppers-nav come da reference dati
```

---

## Verifica manuale (checklist)

- [ ] IT: primo step stepper = **Autorizzazioni e condizioni**; EN: allineato a `stepper-component.md`.
- [ ] Step 1: bottone **mobile-full**, niente chevron obbligatorio come unico pattern.
- [ ] Step 2+: **Indietro** + **Avanti** (e eventuali Salva se in scope condiviso con 7-29/altre story).
- [ ] Header: hamburger centrato verticalmente; “Cerca” visibile dove previsto (7-29).
- [ ] 375 / 768 / 1024: stepper leggibile, nessun overflow critico.
- [ ] Nessuna regressione Livewire (`nextStep`, validazione step 1).

---

## Definition of Done

- Traduzioni aggiornate e coerenti con `stepper-component.md`.
- Blade wizard distingue CTA step 1 vs navigazione step 2+.
- Documentazione modulo/tema aggiornata con link relativi; indice tema (`docs/00-index.md`) con puntatore a questa story.
- Test automatici esistenti (`CreateTicketWizardWidgetTest` se presente) aggiornati se assert su stringhe UI.
- Screenshot o nota in docs se parity visiva documentata.

---

## Riferimenti interni

- Estratto reference locale (stepper + CTA step 1): `laravel/Themes/Sixteen/docs/html-parity-reports/segnalazione-01-privacy/ref_raw.html` (linee ~300–344: testi stepper + bottone `mobile-full`).
- Navigazione step 2 reference: `laravel/Themes/Sixteen/docs/html-parity-reports/segnalazione-02-dati/ref_raw.html` (~572–596: `cmp-nav-steps`).
- Tabella traduzioni stepper: `laravel/Themes/Sixteen/docs/design-comuni/stepper-component.md`.

---

## Tasks / Subtasks

- [x] Allineare `steps.privacy.label` e `fields.step.privacy.label` (IT/EN) a Design Comuni
- [x] CTA step 1: `btn btn-primary mobile-full` + `wire:click="nextStep"` fuori da `cmp-nav-steps`
- [x] Navigazione step 2–3: `cmp-nav-steps` solo se `$currentStep >= 2`
- [x] Aggiungere `actions.submit.label` (IT/EN) per evitare chiave mancante sul pulsante invio
- [ ] Verifica manuale header «Cerca» + hamburger (story **7-29**)
- [ ] Screenshot 375/768/1024 oppure conferma dopo 7-29

---

## Dev Agent Record

### Debug log

- Test `CreateTicketWizardWidgetTest`: fallimento ambiente (`SQLite` migration `team_user` / `PRIMARY KEY`) — non legato alle modifiche wizard; rieseguire in ambiente DB valido.

### Completion notes

- Implementazione codice per **gap §1 e §2** della story (copy stepper + pattern CTA step 1 vs step 2+).
- Gap **§3 (header)** e **§4 (responsive/tablet)** restano in carico a **7-29** e verifica manuale.

---

## File List

| File | Modifica |
|------|----------|
| `laravel/Modules/Fixcity/lang/it/segnalazione.php` | `steps.privacy`, `fields.step.privacy`, `actions.submit` |
| `laravel/Modules/Fixcity/lang/en/segnalazione.php` | idem EN |
| `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` | CTA step 1 + `@if($currentStep >= 2)` su nav |

---

## Change Log

| Data | Autore | Descrizione |
|------|--------|-------------|
| 2026-04-09 | Dev | Label step 1 «Autorizzazioni e condizioni», CTA `mobile-full` step 1, nav `cmp-nav-steps` da step 2, chiavi `actions.submit` |

---

## Senior Developer Review (AI)

_(vuoto — da compilare in review)_
