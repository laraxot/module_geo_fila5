# Story 8.9: segnalazione-crea step 2 — visibilità mappa, spacing titoli e guardrail header desktop

**Status**: ready-for-dev  
**Epic**: 8 — Tooling & Developer Experience  
**Story ID**: 8-9  
**Story Key**: 8-9-segnalazione-crea-step2-map-visibility-spacing-and-desktop-header-guard  
**Data creazione**: 2026-04-15  
**Dipendenze**: 7-29, 7-51, 7-52, 8-7, 8-8

---

## Story

Come **cittadino che apre lo step 2 del wizard pubblico Filament**,
voglio che nella URL reale
`http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step`
la mappa sia visibile, il ritmo verticale tra titoli e box sottostanti sia compatto,
e l'header resti in assetto desktop senza mostrare l'hamburger menu fuori breakpoint,
così da avere una UI coerente, leggibile e allineata al reference Design Comuni.

Riferimento:
- `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`

---

## Problema consolidato

L'analisi utente segnala tre regressioni concrete sulla pagina runtime reale:

1. **la mappa nello step 2 non si vede** oppure risulta collassata/invisibile;
2. **lo spazio tra i titoli di sezione e il box sotto è troppo ampio** e rompe il ritmo visivo;
3. **l'hamburger menu è visibile anche in visualizzazione desktop**, segnale che l'header sta applicando logica mobile fuori breakpoint.

Questi problemi vanno trattati come un unico cluster di parity/runtime hardening, non come tre fix scollegati, perché toccano la stessa URL reale e la stessa percezione di qualità della pagina.

---

## Regola / Visione / Filosofia / Zen

- Il wizard e lo stepper restano **Filament-first**: `Wizard` / `Step` sono la fonte di verità.
- Blade del widget = **shell di parity**, non macchina a stati.
- La mappa è **Geo-owned**: Fixcity la consuma, non la reinventa.
- L'header desktop non deve degradare in header mobile per colpa di CSS troppo aggressivi.
- La parity non si ottiene con hack locali o selector fragili: si ottiene con hook stabili, breakpoint coerenti e controllo del render path reale.

In sintesi:
- **regola**: una sola fonte di verità per wizard e breakpoint;
- **politica**: niente fix opportunistici che rompono desktop per sistemare mobile;
- **zen**: parity sì, regressioni di layout no.

---

## Acceptance Criteria

### AC1 — Mappa visibile nello step 2
**Given** la URL target è aperta sul passo `form.dati-della-segnalazione::data::wizard-step`  
**When** la sezione `Luogo` viene renderizzata  
**Then** la mappa è visibile con altezza reale non collassata  
**And** non è nascosta da CSS, overflow, `display:none`, dimensioni zero o problemi di `invalidateSize()`.

### AC2 — Spacing verticale corretto
**Given** i titoli e le descrizioni delle sezioni Filament (`Luogo`, `Disservizio`, `Autore`)  
**When** confronto la distanza tra heading/description e il box sottostante  
**Then** lo spacing è compatto e coerente col reference  
**And** non restano vuoti eccessivi tra titolo sezione e contenuto.

### AC3 — Header desktop senza hamburger mobile
**Given** un viewport desktop  
**When** la pagina è renderizzata  
**Then** l'hamburger menu mobile non è visibile  
**And** il layout header/topbar è quello desktop previsto.

### AC4 — Breakpoint coerenti
**Given** desktop, tablet e mobile  
**When** verifico header e wizard  
**Then** ogni controllo appare solo nel breakpoint corretto  
**And** non ci sono ibridi desktop/mobile contemporanei.

### AC5 — Nessuna regressione Filament
**Given** il wizard usa Filament come sorgente di verità  
**When** applico i fix  
**Then** non viene reintrodotta navigazione manuale degli step in Blade  
**And** lo stepper continua a seguire il flusso Filament.

### AC6 — Docs anti-regressione aggiornate
**Given** la patch conclusa  
**When** aggiorno la documentazione  
**Then** i docs canonici di modulo/tema descrivono:
- mappa visibile come requisito runtime;
- spacing section-first come regola parity;
- header desktop/mobile come guardrail di breakpoint;
- divieto di selector fragili per questa pagina.

---

## Tasks / Subtasks

### [ ] 1. Diagnosi mappa invisibile
- [ ] 1.1. Verificare il render path reale di `LatitudeLongitudeInput`
- [ ] 1.2. Controllare se il problema è dovuto a CSS (`display`, `height`, `overflow`, `position`) o a init JS
- [ ] 1.3. Verificare `invalidateSize()` su step visibile / ritorno allo step
- [ ] 1.4. Assicurare un'altezza minima reale e stabile della shell mappa

### [ ] 2. Riduzione spacing tra titoli e box
- [ ] 2.1. Analizzare classi Filament `Section` renderizzate
- [ ] 2.2. Ridurre margin/padding tra header sezione, description e content box
- [ ] 2.3. Applicare fix sui hook stabili del wizard, non su slug runtime

### [ ] 3. Guardrail header desktop/mobile
- [ ] 3.1. Individuare perché l'hamburger resta visibile su desktop
- [ ] 3.2. Correggere breakpoint e regole di visibilità del toggler
- [ ] 3.3. Verificare che il fix non rompa mobile/tablet

### [ ] 4. Verifica runtime e visuale
- [ ] 4.1. Smoke test della URL reale
- [ ] 4.2. Verifica desktop/tablet/mobile
- [ ] 4.3. Controllo visuale specifico su mappa, spacing e header

### [ ] 5. Aggiornamento docs
- [ ] 5.1. Aggiornare `ticket-wizard-frontoffice.md`
- [ ] 5.2. Aggiornare docs tema Sixteen rilevanti per parity/breakpoint
- [ ] 5.3. Aggiornare `sprint-status.yaml` a implementazione completata

---

## File target previsti

- `laravel/Modules/Geo/resources/views/filament/forms/components/latitude-longitude-input.blade.php`
- `laravel/Themes/Sixteen/resources/css/segnalazione-wizard.css`
- `laravel/Themes/Sixteen/resources/css/header-fix.css`
- `laravel/Themes/Sixteen/resources/css/mobile-header-fix.css`
- `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Themes/Sixteen/docs/design-comuni/TICKET-CREATION-WIZARD.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

---

## Dev Notes

### Contesto da riusare

- `_bmad-output/implementation-artifacts/8-7-segnalazione-crea-map-ux-fix-satellite-lat-lng.md`
- `_bmad-output/implementation-artifacts/8-8-segnalazione-crea-cross-breakpoint-visual-parity-and-map-hardening.md`
- `_bmad-output/implementation-artifacts/7-51-segnalazione-crea-step2-columns-header-ultra-parity.md`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Modules/Fixcity/docs/rules/filament-wizard-rules.md`

### Guardrail specifici

- Non introdurre nuovi selector tipo `.page-content[data-slug="tests.segnalazione-crea"]`.
- Non sostituire il Wizard Filament con logica custom Blade.
- Non correggere l'hamburger desktop con `!important` casuali senza sistemare il breakpoint reale.
- Se la mappa è invisibile, verificare prima shell, altezza e resize; non assumere subito un problema Leaflet.

---

## Definition of Done

- mappa visibile nella URL reale dello step 2;
- spacing sezione corretto e più vicino al reference;
- hamburger desktop non visibile fuori breakpoint mobile;
- nessuna regressione Filament/wizard;
- docs canoniche aggiornate;
- story pronta per implementazione o review.

---

## Dev Agent Record

### Agent Model Used
Codex GPT-5

### Completion Notes List
- Story creata per isolare tre regressioni runtime reali della pagina step 2: mappa invisibile, spacing verticale e header desktop/mobile.

### File List
- `_bmad-output/implementation-artifacts/8-9-segnalazione-crea-step2-map-visibility-spacing-and-desktop-header-guard.md`

### Change Log
| Data | Descrizione |
|---|---|
| 2026-04-15 | Creata story 8-9 focalizzata su mappa invisibile, spacing e hamburger visibile su desktop nella URL reale dello step 2. |
