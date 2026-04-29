# Story 7.22: Token Optimization — Ridurre il consumo di token nelle sessioni Claude Code

Status: ready-for-dev

## Story

Come **developer che usa Claude Code su questo progetto**,
voglio applicare tecniche validate di risparmio token nelle sessioni di lavoro,
così da estendere la durata delle sessioni, ridurre i costi e rendere il workflow BMAD più efficiente.

---

## Ricerca — Tecniche trovate (fonti web, aprile 2026)

### A. Ottimizzazione CLAUDE.md

> *"CLAUDE.md gets injected into every single request—every turn and follow-up—so if it's 5,000 tokens, you're taxed 5,000 tokens on every interaction."*  
> — [Branch8 Token Limits Guide](https://branch8.com/posts/claude-code-token-limits-cost-optimization-apac-teams)

**Regola:** mantenere CLAUDE.md ≤ 2,000 token. Usare link a file separati per dettagli.

**Stato attuale del progetto:**
- `laravel/CLAUDE.md` = **~10,000 token** (auto-generato da Laravel Boost — NON modificabile)
- Nessun `CLAUDE.md` a livello root del progetto
- `_bmad/bmm/config.yaml` non ha direttive per output conciso

**Opportunità:** creare un `CLAUDE.md` root < 500 token con regole terse per le sessioni BMAD.

---

### B. Direttive di risposta concisa

> *"Replace prose-style instructions with terse role definitions and bulleted constraints — the model needs clear directives, not polite framing."*  
> — [drona23/claude-token-efficient (GitHub)](https://github.com/drona23/claude-token-efficient)

Tecniche applicabili:
- Istruire Claude a non ripetere il contenuto già fornito
- Eliminare le sezioni "riassunto di quello che ho fatto" alla fine delle risposte
- Usare `diff` invece di riscrivere file interi
- Preferire output strutturati (tabelle, bullet) alla prosa

---

### C. Gestione del contesto / sessione

> *"Use /clear as often as possible when you complete a task or switch to an unrelated one."*  
> — [Sabrina.dev — 6 Ways I Cut My Claude Token Usage in Half](https://www.sabrina.dev/p/6-ways-i-cut-my-claude-token-usage)

> *"Breaking large codebases into focused sessions rather than trying to work across the whole codebase at once."*  
> — [Mindstudio — 18 Token Management Hacks](https://www.mindstudio.ai/blog/claude-code-token-management-hacks-3)

Applicabile qui:
- Ogni story BMAD = sessione separata con `/clear` iniziale
- Non caricare in contesto file CSS da 40,000+ righe se non strettamente necessario
- Usare `Grep` per trovare il blocco specifico invece di leggere tutto il file

---

### D. Serializzazione efficiente

> *"CSV outperforms JSON by 40–50% for tabular data."*  
> — [The New Stack — Token-Efficient Data Prep](https://thenewstack.io/a-guide-to-token-efficient-data-prep-for-llm-workloads/)

Applicabile qui:
- I file CSV di BMAD config (`bmad-help.csv`, `files-manifest.csv`) già usano il formato corretto
- Le tabelle nei file `.md` di story sono più efficienti di blocchi JSON descrittivi
- Negli epic e nelle story, preferire tabelle a liste verbose

---

### E. Prompt caching (infrastruttura)

> *"Cached tokens cost $0.30/M vs $3.00/M uncached — 10x reduction."*  
> — [Sitepoint — Claude API Token Optimization](https://www.sitepoint.com/claude-api-token-optimization/)

Il prompt caching si applica automaticamente su sessioni con stesso contenuto iniziale (CLAUDE.md, config). Non richiede azione diretta da parte del dev.

---

## Acceptance Criteria

1. **Root CLAUDE.md creato** in `/var/www/_bases/base_fixcity_fila5/CLAUDE.md` con direttive terse (< 500 token): risposta concisa, niente riassunti finali, preferire diff/tabelle.
2. **BMAD config aggiornato:** `_bmad/config.user.yaml` contiene una chiave `output_style: terse` o equivalente per istruire gli agenti BMAD a risposte compatte.
3. **Documento di riferimento creato:** `docs/token-optimization.md` con le tecniche trovate, i risultati attesi e le regole di sessione per questo progetto.
4. **Memory salvata:** le regole principali vengono salvate nella memory di Claude Code (auto-memory) per persistenza tra sessioni.
5. **Nessuna regressione:** le stories BMAD esistenti e i workflow non vengono alterati; solo aggiunte, non rimozioni.

---

## Tasks / Subtasks

- [ ] **Task 1 — Crea `/var/www/_bases/base_fixcity_fila5/CLAUDE.md` root (AC: 1)**
  ```markdown
  # Regole progetto base_fixcity_fila5
  
  ## Output
  - Risposte concise. No riassunti finali ("ho fatto X, Y, Z").
  - Preferire diff parziale a riscrittura completa di file.
  - Usare tabelle e bullet, non prosa.
  - Non leggere file interi se basta Grep su un blocco specifico.
  
  ## Sessioni
  - /clear tra task non correlati.
  - Una story BMAD = una sessione focalizzata.
  - Non caricare CSS > 5000 righe intero: usare offset+limit o Grep.
  
  ## Build CSS/JS
  - Dopo ogni modifica CSS: `cd laravel/Themes/Sixteen && npm run build && npm run copy`
  ```

- [ ] **Task 2 — Aggiorna `_bmad/config.user.yaml` (AC: 2)**
  - Aprire `_bmad/config.user.yaml`
  - Aggiungere sotto `user_skill_level` una nuova chiave:
    ```yaml
    output_style: terse   # risposte compatte, no riassunti, prefer tables/bullets
    ```

- [ ] **Task 3 — Crea `docs/token-optimization.md` (AC: 3)**
  - Sintetizzare le 5 tecniche trovate in formato tabella
  - Includere le metriche di risparmio atteso per ogni tecnica
  - Sezione "Regole per questo progetto" con workflow specifico

- [ ] **Task 4 — Salva memory (AC: 4)**
  - Salvare feedback memory: "risposte terse, no riassunti finali, preferire Grep+offset su file grandi"
  - Salvare project memory: "token optimization implementata in CLAUDE.md root e config.user.yaml"

---

## Dev Notes

### File da creare/modificare

| File | Azione | Note |
|------|--------|------|
| `/var/www/_bases/base_fixcity_fila5/CLAUDE.md` | CREATE | Root del progetto; < 500 token |
| `_bmad/config.user.yaml` | EDIT | Aggiungere `output_style: terse` |
| `docs/token-optimization.md` | CREATE | Documento di riferimento |

### File da NON toccare

| File | Motivo |
|------|--------|
| `laravel/CLAUDE.md` | Auto-generato da Laravel Boost; non modificabile |
| `_bmad/bmm/config.yaml` | Config BMAD core; modifiche separate |
| Story e epic esistenti | Nessuna retrocompatibilità necessaria |

### Risparmio atteso

| Tecnica | Risparmio stimato |
|---------|-------------------|
| CLAUDE.md terse (root, 500 token) | -40% input/sessione su task BMAD |
| `/clear` tra task non correlati | -30-60% contesto accumulato |
| Grep+offset invece di Read intero | -60-80% token per navigare CSS grandi |
| Tabelle vs prosa nelle story | -20-30% output token |
| Sessioni focalizzate per story | -50% contesto irrelevante |

### Fonte ricerca

- [Branch8 Token Guide](https://branch8.com/posts/claude-code-token-limits-cost-optimization-apac-teams) — ottimizzazione sessioni team
- [Sabrina.dev — 6 Ways](https://www.sabrina.dev/p/6-ways-i-cut-my-claude-token-usage) — tecniche pratiche
- [Mindstudio — 18 Hacks](https://www.mindstudio.ai/blog/claude-code-token-management-hacks-3) — selezione modello + architettura sessione
- [drona23/claude-token-efficient](https://github.com/drona23/claude-token-efficient) — CLAUDE.md template terse
- [The New Stack — Data Prep](https://thenewstack.io/a-guide-to-token-efficient-data-prep-for-llm-workloads/) — serializzazione efficiente

---

## Dev Agent Record

### Agent Model Used

claude-sonnet-4-6

### Debug Log References

### Completion Notes List

### File List

- `/var/www/_bases/base_fixcity_fila5/CLAUDE.md`
- `_bmad/config.user.yaml`
- `docs/token-optimization.md`

---

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-12 | Creata story 7.22: ricerca web su tecniche token optimization, analisi dello stato attuale del progetto, tasks specifici per CLAUDE.md root + BMAD config + documentazione. |
