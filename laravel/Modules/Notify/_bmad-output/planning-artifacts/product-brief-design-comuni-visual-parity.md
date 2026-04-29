---
title: "Product Brief: Design Comuni Visual Parity — FixCity Tema Sixteen"
status: "draft"
created: "2026-04-03"
updated: "2026-04-03"
project: "FixCity Fila5"
inputs:
  - "laravel/Themes/Sixteen/docs/design-comuni/BATCH_BODY_PARITY_REPORT.md"
  - "laravel/Themes/Sixteen/docs/analysis/BATCH-ANALYSIS-DIAGNOSTIC-REPORT.md"
  - "laravel/Themes/Sixteen/docs/design-comuni/work-plan.md"
  - "laravel/Themes/Sixteen/docs/design-comuni/bmad-gsd-status-2026-04-03.md"
  - "laravel/Themes/Sixteen/docs/design-comuni/ALL_PAGES_ANALYSIS.md"
  - "bashscripts/docs/MULTI_AGENT_COLLABORATION.md"
  - "_bmad-output/design-comuni-prd.md"
  - "docs/MODULE_DOCS_INDEX.md"
---

# Product Brief: Design Comuni Visual Parity — FixCity Tema Sixteen

## Executive Summary

FixCity Fila5 deve essere conforme al **Design Comuni Italia** (standard AGID obbligatorio per le PA italiane). Il progetto consiste nel replicare visivamente **55 pagine statiche** del design system nazionale nel tema Sixteen di FixCity, usando esclusivamente **Tailwind CSS + Alpine.js** — senza Bootstrap Italia come runtime dependency.

Il lavoro non è da zero: l'infrastruttura Blade/JSON/Folio è già in piedi, agenti AI multipli hanno già lavorato su homepage e poche altre pagine. Quello che manca è un'esecuzione sistematica, coordinata e verificata su tutte le 55 pagine.

Il brief definisce la strategia, le priorità e le metriche per portare a zero il deficit visivo rispetto alla reference AGID in modo misurabile, iterativo e multi-agente.

---

## Il Problema

Le PA italiane che adottano FixCity sono **obbligate per legge** a rispettare il Design Comuni Italia (AGID/CAD). Oggi la piattaforma non rispetta quella conformità visiva: il tema Sixteen usa un proprio design system invece di replicare i pattern del design nazionale.

**Stato attuale verificato (2026-04-03):**

| Gruppo | Descrizione | Pagine | Stato |
|--------|-------------|--------|-------|
| A | HTML ≥60% match, CSS/JS phase ready | ~8 pagine | CSS/JS phase |
| B | HTML 30-60%, struttura parzialmente corretta | ~10 pagine | Blade/JSON fix |
| C | HTTP 500 locale, JSON mancante o errore | ~12 pagine | Creazione JSON |
| D | HTTP 200 locale + reference 404 (AGID non pubblicato) | ~7 pagine | Reference da trovare |
| E | 0% match, pagine non implementate | ~18 pagine | Da implementare |

Nessuna pagina è oggi dichiarata READY (≥90% visual parity). La homepage — la più lavorata dagli agenti — è al ~83% strutturale ma ancora non pixel-identica nella hero.

**Root causes identificate:**
1. **JSON mancanti** → HTTP 500 su pagine non ancora create
2. **Struttura Blade non aggiornata** → template generico invece di layout specifico per pagina
3. **CSS/JS override incompleti** → colori, spacing, tipografia non allineati al Design Comuni
4. **Alpine.js stripping** → le direttive `x-data` vengono rimosse a runtime (bug identificato in Phase 8)

---

## La Soluzione

Esecuzione sistematica in **4 percorsi paralleli**, coordinati da documentazione condivisa nei `docs/` di moduli e temi:

### Percorso 1 — CSS/JS Visual Fix (Gruppo A, ~8 pagine)
Per le pagine con buona struttura HTML, lavorare solo su `resources/css/app.css` e `resources/js/app.js` nel tema Sixteen. Ogni ciclo: modifica → `npm run build` → `npm run copy` → screenshot → confronto → documento.

### Percorso 2 — JSON Creation (Gruppo C, ~12 pagine)
Creare i file JSON mancanti in `laravel/config/local/fixcity/database/content/pages/tests.<pagina>.json` partendo dalla struttura HTML della reference. Verificare che la pagina torni HTTP 200.

### Percorso 3 — Blade/HTML Structure Fix (Gruppo B + E, ~28 pagine)  
Aggiornare il file `[slug].blade.php` e i JSON per replicare la struttura HTML di riferimento. Target: portare ogni pagina a ≥90% prima del pass CSS.

### Percorso 4 — Alpine.js Fix (cross-cutting)
Risolvere il bug di stripping delle direttive `x-data` (probabilmente in `SixteenComposer.php` o middleware). Blocca l'interattività su TUTTE le pagine.

---

## Cosa Rende Questo Approccio Diverso

**Stack scelta:** Tailwind CSS `@apply` invece di Bootstrap Italia CDN — più performante, manutenibile, e non introduce dipendenze esterne non necessarie.

**Architettura JSON-driven:** I contenuti sono in file JSON separati dalla struttura Blade — permette agli agenti AI di lavorare in parallelo senza conflitti di merge su un singolo file.

**Multi-agent by design:** La struttura `docs/` in ogni modulo e tema è il canale di coordinamento tra agenti. Chi lavora su `amministrazione` documenta in `docs/design-comuni/AMMINISTRAZIONE_*.md`; chi lavora su `homepage` in `docs/design-comuni/HOMEPAGE_*.md`. Nessun conflitto di lavoro.

**Screenshot-driven verification:** Ogni fix viene verificato con screenshot reali confrontati visivamente. Non si chiude un ciclo senza prova visiva.

---

## Chi Serve

**Primario — Agenti AI (multi-agent team):**  
Ogni agente prende in carico un gruppo di pagine. Legge i docs esistenti, esegue il lavoro, documenta il risultato, aggiorna l'indice. Coordina via `docs/` senza bisogno di comunicazione sincrona.

**Secondario — Comuni/PA italiani:**  
L'utente finale è il cittadino italiano che accede al portale comunale. Deve trovare un'interfaccia identica al design system nazionale — familiare, accessibile (WCAG 2.1 AA), mobile-first.

**Terziario — Xot (product owner):**  
Riceve aggiornamenti di stato dai report nei `docs/` e dalle pagine di coordinamento in `bashscripts/docs/`.

---

## Criteri di Successo

| Metrica | Target | Attuale |
|---------|--------|---------|
| Pagine READY (≥90% visual parity) | 55/55 | 0/55 |
| Pagine con HTML ≥90% strutturale | 55/55 | ~8/55 |
| HTTP 500 su locale | 0 | ~12 |
| Alpine.js funzionante | tutte le pagine | 0 (bug attivo) |
| PHPStan Level 10 mantenuto | pass | pass ✅ |
| npm run build senza errori | pass | da verificare |

**Definizione di DONE per pagina:**
- [ ] HTML struttura ≥90% vs reference (esclusi scripts)
- [ ] Visual parity verificata con screenshot (diff <5% pixel)
- [ ] Alpine.js interattivo funzionante
- [ ] Lighthouse score >90
- [ ] Screenshot + analisi documentata in `docs/design-comuni/`

---

## Scope

**In scope (v1):**
- 55 pagine elencate dall'utente
- Solo CSS/JS in `laravel/Themes/Sixteen`
- JSON content in `laravel/config/local/fixcity/database/content/pages/tests/`
- Blade `[slug].blade.php` modificabile se necessario per struttura
- Fix Alpine.js stripping

**Esplicitamente fuori scope:**
- REST API / JWT / OAuth2 (non rilevanti in questo task)
- Backend Filament / admin panel
- Database migrations
- Performance optimization (TTFB, caching)
- Nuovi moduli Laravel

---

## Roadmap per Milestone

### Milestone 1 — Quick Wins (Gruppo A): ~8 pagine CSS-ready
**Priorità:** homepage, argomenti, domande-frequenti, lista-risorse, risultati-ricerca  
**Lavoro:** CSS/JS fix + screenshot verification  
**Output:** 5-8 pagine READY, pattern CSS documentati per riuso

### Milestone 2 — Foundation Fix: Alpine.js + JSON mancanti
**Priorità:** fix bug Alpine stripping, creare ~12 JSON mancanti  
**Lavoro:** debug `SixteenComposer.php`, script batch JSON creation  
**Output:** 0 HTTP 500, Alpine.js funzionante su tutte le pagine

### Milestone 3 — Blade/HTML Structure: Gruppo B + D (~17 pagine)
**Priorità:** amministrazione, novita, servizi, eventi, argomento  
**Lavoro:** aggiornare HTML in Blade/JSON per replicare struttura reference  
**Output:** 25+ pagine a ≥90% strutturale

### Milestone 4 — Completamento: Gruppo E (~18 pagine wizard/form)
**Priorità:** appuntamento (8 step), segnalazione (7 step), assistenza (2 step)  
**Lavoro:** implementazione completa da zero  
**Output:** 55/55 pagine READY

---

## Note Operative per Agenti AI

**Regola di coordinamento:**
- Prima di iniziare su una pagina, controlla `docs/design-comuni/AGENT-COORDINATION.md` 
- Annota la tua assegnazione prima di lavorare
- Alla fine, aggiorna il file con status e link al tuo report

**Build workflow per ogni fix CSS/JS:**
```bash
cd laravel/Themes/Sixteen
npm run build
npm run copy
# Poi verifica su http://127.0.0.1:8000/it/tests/<pagina>
```

**Screenshot:** salva in `laravel/Themes/Sixteen/docs/design-comuni/screenshots/<pagina>/`  
**Script:** metti in `bashscripts/<categoria>/<script>` e documenta in `bashscripts/docs/`  
**No `/tmp`** — usa sempre percorsi relativi al progetto

---

*Brief preparato da: BMad Product Brief Agent*  
*Data: 2026-04-03*  
*Prossima revisione: dopo Milestone 1*
