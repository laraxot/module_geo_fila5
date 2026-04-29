# Story 8.12: LatitudeLongitudeInput — selettore `jsFramework()` con renderer Lit opzionale

**Status**: ready-for-dev  
**Epic**: 8 — Tooling & Developer Experience  
**Story ID**: 8-12  
**Story Key**: 8-12-latitude-longitude-input-js-framework-switch-with-lit-renderer  
**Data creazione**: 2026-04-15  
**Dipendenze**: 8-1, 8-10

---

## Story

Come **sviluppatore che usa `Modules\Geo\Filament\Forms\Components\LatitudeLongitudeInput` in form Filament pubblici**,
voglio poter dichiarare in modo esplicito un renderer JS, ad esempio `->jsFramework('lit')`,
così da mantenere Filament come sorgente di verità lato PHP ma scegliere se rendere la UI mappa con la Blade/Alpine legacy oppure con un Web Component Lit dedicato.

---

## Problema consolidato

Oggi `LatitudeLongitudeInput` ha un solo percorso di rendering:

- view fissa: `geo::filament.forms.components.latitude-longitude-input`
- implementazione fortemente accoppiata a Blade + Alpine + Leaflet
- assenza di un contratto backend per scegliere una diversa strategia frontend

Questo crea tre limiti:

1. il componente **non dichiara** se la UI JS sia Blade/Alpine o Web Component;
2. non possiamo introdurre una variante Lit in modo pulito senza hijack sulla view corrente;
3. il modulo Geo non offre ancora una **politica ufficiale di renderer selection** per componenti JS-heavy.

La richiesta utente non è “eliminare Blade” in assoluto, ma:

- tenere Filament/PHP come governance del field;
- aggiungere un metodo semantico tipo `->jsFramework('lit')`;
- usare un’altra Blade minimale che monta un Web Component Lit, invece della view Alpine corrente;
- preservare backward compatibility per tutti i consumer esistenti.

---

## Regola / Visione / Filosofia / Zen

- **Filament-first**: stato, schema, validazione e API pubblica restano nel componente PHP.
- **Renderer pluggable**: Blade non è il dominio; è il bridge tra Filament e il renderer JS scelto.
- **Backward compatibility**: il percorso attuale Blade/Alpine resta default finché la variante Lit non è stabile.
- **No big bang rewrite**: introdurre un selection contract sul field è corretto; sostituire tutto in-place senza selettore sarebbe regressivo.
- **One field, multiple renderers**: stessa semantica di `statePath`, stessa dehydratazione, stesse coordinate, diverso motore UI.

In sintesi:

- la **regola** è scegliere il renderer dal field PHP, non da hack tematici;
- la **visione** è avere componenti Geo evolvibili senza forkare il dominio;
- la **politica** è default conservativo + opt-in esplicito;
- lo **zen** è separare “cosa fa il field” da “come viene renderizzato”.

---

## Acceptance Criteria

### AC1 — API pubblica del field
**Given** un developer usa `LatitudeLongitudeInput`  
**When** chiama `->jsFramework('lit')`  
**Then** il field accetta il valore e seleziona il renderer Lit  
**And** senza chiamata esplicita continua a usare il renderer legacy corrente.

### AC2 — View selection governata dal componente PHP
**Given** il field viene renderizzato in Filament  
**When** il framework JS selezionato è `lit`  
**Then** il field usa una view dedicata distinta da `latitude-longitude-input.blade.php`  
**And** la scelta avviene nel componente PHP, non tramite if sporchi in tema o pagina.

### AC3 — Renderer Lit minimale ma compatibile
**Given** la variante Lit è abilitata  
**When** il field viene montato  
**Then** la nuova Blade Lit passa al Web Component almeno:
- coordinate iniziali,
- zoom,
- configurazione altezza,
- path/stato necessario per il sync con Filament/Livewire  
**And** il comportamento dati rimane coerente con il field legacy.

### AC4 — Contract esplicito e validato
**Given** il metodo `->jsFramework()`  
**When** riceve un valore non supportato  
**Then** il componente lo rifiuta in modo esplicito oppure fa fallback documentato al default  
**And** i renderer supportati sono documentati (`blade`/`alpine`, `lit`, eventuali futuri).

### AC5 — Nessuna regressione sui consumer attuali
**Given** i form e wizard esistenti che usano `LatitudeLongitudeInput` senza `->jsFramework()`  
**When** il codice viene aggiornato  
**Then** continuano a usare la view legacy esistente  
**And** non cambiano API, stato, output o flusso runtime inaspettatamente.

### AC6 — Pipeline tema esplicitata per i renderer Lit
**Given** il renderer Lit viene introdotto per un field Filament pubblico  
**When** si aggiorna la documentazione  
**Then** è chiarito che gli asset JS del Web Component passano dal bundle `Sixteen`  
**And** la pipeline ufficiale resta:
- `npm run build`
- `npm run copy`
dal tema `laravel/Themes/Sixteen/`.

### AC7 — Documentazione anti-duplicazione
**Given** la nuova capacità `jsFramework('lit')`  
**When** aggiorno la documentazione  
**Then** i docs Geo e Sixteen chiariscono:
- quando usare il renderer legacy;
- quando usare Lit;
- come evitare doppie implementazioni o fork ridondanti del field.

---

## Tasks / Subtasks

### [ ] 1. Introdurre il contract backend del renderer
- [ ] 1.1. Aggiungere una proprietà configurabile sul field (`jsFramework`, enum/stringa tipizzata o equivalente)
- [ ] 1.2. Esporre un fluent method del tipo `->jsFramework('lit')`
- [ ] 1.3. Definire default stabile (`blade`, `alpine`, o naming equivalente documentato)
- [ ] 1.4. Aggiungere getter/metodo di supporto per la view selection

### [ ] 2. Separare la view legacy dalla variante Lit
- [ ] 2.1. Lasciare `latitude-longitude-input.blade.php` come renderer legacy
- [ ] 2.2. Creare una seconda Blade per il renderer Lit
- [ ] 2.3. Evitare branching ingestibili dentro una sola Blade gigante
- [ ] 2.4. Mantenere naming e responsibility chiari tra le due view

### [ ] 3. Definire il bridge Filament/Livewire ↔ Web Component Lit
- [ ] 3.1. Stabilire quali props/attributes passare al Web Component Lit
- [ ] 3.2. Stabilire come il Web Component aggiorna `latitude` / `longitude`
- [ ] 3.3. Verificare che il sync dati sia compatibile con il field Filament esistente
- [ ] 3.4. Evitare doppio source of truth tra componente PHP, DOM e Web Component

### [ ] 4. Documentare renderer policy e pipeline
- [ ] 4.1. Aggiornare docs Geo del field `LatitudeLongitudeInput`
- [ ] 4.2. Aggiornare docs Sixteen lato build/publish dei Web Components
- [ ] 4.3. Esplicitare la regola “Filament governa, Lit renderizza”
- [ ] 4.4. Annotare limiti, tradeoff e fallback del renderer Lit

### [ ] 5. Preparare la strada a una migrazione incrementale
- [ ] 5.1. Identificare almeno un consumer candidato per `->jsFramework('lit')`
- [ ] 5.2. Non migrare tutti i consumer nella stessa story salvo necessità
- [ ] 5.3. Lasciare una traiettoria chiara per story successive di adozione runtime

---

## File target previsti

- `laravel/Modules/Geo/app/Filament/Forms/Components/LatitudeLongitudeInput.php`
- `laravel/Modules/Geo/resources/views/filament/forms/components/latitude-longitude-input.blade.php`
- `laravel/Modules/Geo/resources/views/filament/forms/components/latitude-longitude-input-lit.blade.php`  
  oppure naming equivalente coerente
- `laravel/Modules/Geo/resources/js/components/` (eventuali adattamenti bridge/component)
- `laravel/Modules/Geo/docs/filament-forms-components.md`
- `laravel/Modules/Geo/docs/wiki/concepts/lit-web-components.md`
- `laravel/Themes/Sixteen/docs/architecture/README.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

---

## Dev Notes

### Contesto tecnico da riusare

- `laravel/Modules/Geo/app/Filament/Forms/Components/LatitudeLongitudeInput.php`
- `laravel/Modules/Geo/resources/views/filament/forms/components/latitude-longitude-input.blade.php`
- `laravel/Modules/Geo/resources/js/components/my-map-lit.js`
- `_bmad-output/implementation-artifacts/8-10-segnalazione-crea-map-bidirectional-sync-and-no-refresh-on-marker-drag.md`
- `laravel/Modules/Geo/docs/filament-forms-components.md`
- `laravel/Modules/Geo/docs/wiki/concepts/lit-web-components.md`
- `laravel/Themes/Sixteen/docs/architecture/README.md`

### Guardrail specifici

- Non rimuovere il renderer legacy in questa story.
- Non spostare la governance del field fuori da Filament/PHP.
- Non usare la pagina o il tema come posto dove decidere la view del field.
- Non creare un componente Lit scollegato dal field senza contract backend.
- Non duplicare la logica dominio del field in due implementazioni divergenti.

### Decisioni da esplicitare in implementazione

- Naming del framework supportato:
  - `blade`
  - `alpine`
  - `lit`
  - o enum equivalente  
  deve essere coerente e non ambiguo.
- La scelta della view può vivere in:
  - `getView()`,
  - una computed view interna,
  - o altra strategia Filament pulita,  
  ma deve restare centralizzata nel componente PHP.
- Il Web Component Lit non deve aggirare Filament: deve integrarsi con lo stato del field, non sostituirlo.

### Rischi principali

- introdurre `->jsFramework('lit')` senza policy chiara sui valori supportati;
- avere due renderer che evolvono in modo divergente;
- spostare troppo codice nella Blade Lit e perdere la semantica del field;
- confondere pipeline JS del modulo Geo con quella del tema Sixteen.

---

## Definition of Done

- `LatitudeLongitudeInput` espone un contract backend per la scelta del renderer JS;
- esiste una view Lit separata dalla legacy;
- il default resta backward compatible;
- la documentazione spiega chiaramente perché Filament resta il layer di governo;
- la pipeline `build` + `copy` del tema è richiamata nei docs come requisito operativo per i Web Components Lit.

---

## Dev Agent Record

### Agent Model Used
GPT-5 Codex

### Completion Notes List
- Story creata per introdurre renderer selection esplicita su `LatitudeLongitudeInput` con opt-in Lit e backward compatibility.

### File List
- `_bmad-output/implementation-artifacts/8-12-latitude-longitude-input-js-framework-switch-with-lit-renderer.md`

### Change Log
| Data | Descrizione |
|---|---|
| 2026-04-15 | Creata story 8-12 per introdurre `->jsFramework('lit')` su `LatitudeLongitudeInput` con view dedicata Lit, contract backend esplicito e documentazione della pipeline Sixteen. |
