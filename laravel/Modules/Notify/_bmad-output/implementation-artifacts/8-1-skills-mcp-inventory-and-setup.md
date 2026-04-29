# Story 8.1: Skills & MCP — Inventario e configurazione ottimale

Status: ready-for-dev

## Story

Come **sviluppatore AI-assisted** su questo progetto,
voglio avere un inventario completo degli skills e MCP già installati e sapere quali aggiungere,
così da massimizzare le capacità di Claude Code senza configurazioni ridondanti o mancanti.

## Contesto

### Skills già installati (224 total)

Percorso: `/var/www/_bases/base_fixcity_fila5/.claude/skills/`

Categorie rilevanti già presenti:

| Categoria | Skills presenti |
|-----------|-----------------|
| BMAD agents | `bmad-create-story`, `bmad-create-ux-design`, `bmad-sm`, `bmad-dev`, `bmad-po`, `bmad-qa`, `bmad-architect` |
| PHP / Laravel | `laravel-specialist`, `laravel-tdd`, `laravel-testing`, `laravel-best-practices`, `php-best-practices`, `php-pro`, `php-mcp-server-generator` |
| Frontend | `ui-ux-pro-max`, `webapp-testing`, `shadcn-vue`, `fluxui-development`, `volt-development` |
| Testing/QA | `playwright-expert`, `webapp-testing`, `pest-testing` |
| API/Infra | `api-resource-patterns`, `laravel-multi-tenancy`, `folio-routing` |

**Registri skills da monitorare:**
- agentskills.io — registro aperto con 1000+ skills
- github.com/VoltAgent/awesome-agent-skills — curated list
- github.com/anthropics/skills — official Anthropic skills

### MCP già configurati (10 server)

File: `laravel/.mcp.json`

| MCP | Package | Stato |
|-----|---------|-------|
| `laravel-boost` | `php artisan boost:mcp` | ✅ Attivo |
| `fetch` | `@modelcontextprotocol/server-fetch` | ✅ Attivo |
| `filesystem` | `@modelcontextprotocol/server-filesystem` | ✅ Attivo |
| `sqlite` | `@modelcontextprotocol/server-sqlite` | ✅ Attivo |
| `sequential-thinking` | `@modelcontextprotocol/server-sequential-thinking` | ✅ Attivo |
| `memory` | `@modelcontextprotocol/server-memory` | ✅ Attivo |
| `github` | `@modelcontextprotocol/server-github` | ✅ Attivo (richiede `GITHUB_TOKEN`) |
| `context7` | `@upstash/context7-mcp` | ✅ Attivo (richiede `CONTEXT7_API_KEY`) |
| `memory-bank` | `memory-bank-mcp` | ✅ Attivo |
| `supermemory` | `supermemory` | ✅ Attivo (API key già configurata) |

**Global MCP** (`~/.claude/settings.json`): vuoto `{}` — nessun MCP globale.

---

## Acceptance Criteria

1. **Playwright MCP installato**: `claude mcp add playwright npx @playwright/mcp@latest` eseguito e verificato con `claude mcp list`.
2. **Playwright MCP funzionante**: Claude Code riesce a fare screenshot di `http://127.0.0.1:8000/it/tests/segnalazione-02-dati` a 1440px, 768px, 375px senza errori.
3. **Env vars documentate**: File `.env.mcp.example` (o sezione in README) elenca le variabili necessarie: `GITHUB_TOKEN`, `CONTEXT7_API_KEY`.
4. **No duplicazioni**: Nessun MCP installato due volte (globale + locale).
5. **MCP opzionali valutati**: Decision log per Linear, Figma, Mermaid (accettati o rifiutati con motivazione).

---

## Tasks / Subtasks

- [ ] **Task 1 — Installa Playwright MCP** (CRITICO — abilita Epic 6 visual testing)
  - [ ] Eseguire: `claude mcp add playwright npx @playwright/mcp@latest`
  - [ ] Verificare: `claude mcp list` mostra `playwright`
  - [ ] Testare: screenshot di `http://127.0.0.1:8000/it/tests/segnalazione-02-dati` a 1440px
  - [ ] Aggiornare `sprint-status.yaml`: `6-1-playwright-visual-testing-setup: ready-for-dev`

- [ ] **Task 2 — Verifica env vars**
  - [ ] Controllare che `GITHUB_TOKEN` sia impostato: `echo $GITHUB_TOKEN`
  - [ ] Controllare che `CONTEXT7_API_KEY` sia impostato: `echo $CONTEXT7_API_KEY`
  - [ ] Se mancanti, documentare dove trovarli (GitHub Settings > Developer tokens; upstash.com)

- [ ] **Task 3 — Valutazione MCP opzionali**
  - [ ] **Linear MCP** (`@modelcontextprotocol/server-linear`): utile se si usa Linear per issue tracking. Decisione: ⬜ Installa / ⬜ Salta (usare file-system tracking attuale)
  - [ ] **Figma MCP** (`@modelcontextprotocol/server-figma`): utile se ci sono design files Figma. Decisione: ⬜ Installa / ⬜ Salta (reference è Design Comuni pubblico)
  - [ ] **Mermaid Chart MCP**: per generare diagrammi in documentazione. Decisione: ⬜ Installa / ⬜ Salta

- [ ] **Task 4 — Documentazione**
  - [ ] Aggiornare `docs/README.md` con sezione "Claude Code Setup" che elenca MCPs installati
  - [ ] Aggiornare `sprint-status.yaml`: questa story `done`

---

## Dev Notes

### Comando installazione Playwright MCP

```bash
# Dalla directory del progetto (scope: project, non globale)
claude mcp add playwright npx @playwright/mcp@latest

# Verifica
claude mcp list

# Test rapido (nella sessione Claude Code)
# Il tool mcp__playwright__screenshot sarà disponibile
```

**Attenzione**: Playwright MCP richiede un browser Chromium installato. Se non presente:
```bash
npx playwright install chromium
```

### Perché Playwright MCP è CRITICO

1. **Sblocca Epic 6** (Visual Testing & Polish — 5 stories in backlog)
2. **Automatizza il workflow** di screenshot per le parity stories (7-13 → 7-22)
3. **Sostituisce** lo script bash manuale `bashscripts/screenshots/`
4. **Abilita** confronto automatico reference vs local a tutti i breakpoint

### Playwright MCP capabilities

Una volta installato, Claude Code può usare:
- `mcp__playwright__screenshot` — cattura screenshot a qualsiasi viewport
- `mcp__playwright__navigate` — naviga a URL
- `mcp__playwright__click`, `mcp__playwright__type` — interazione con la pagina
- `mcp__playwright__evaluate` — esegue JavaScript nella pagina
- `mcp__playwright__get_visible_text` — estrae testo visibile

### MCP già coperti (non reinstallare)

- **Fetch** (`@modelcontextprotocol/server-fetch`): già presente, copre HTTP requests
- **Filesystem** (`@modelcontextprotocol/server-filesystem`): già presente
- **Memory** (`@modelcontextprotocol/server-memory`): già presente (+ supermemory + memory-bank)
- **Sequential-thinking**: già presente

### Skills da considerare per il futuro

Dal registro agentskills.io, skills non ancora installati che potrebbero essere utili:

| Skill | Utilità per questo progetto |
|-------|----------------------------|
| `visual-regression-testing` | Confronto screenshot automatico |
| `accessibility-auditor` | Audit WCAG per Design Comuni compliance |
| `css-architecture` | Ottimizzazione `segnalazione-parity.css` (3951 linee) |
| `i18n-specialist` | Gestione chiavi di traduzione Laravel |

### Registri ufficiali da consultare

- **Anthropic MCP marketplace**: claude.ai/mcp (MCPs verificati: Linear, Figma, Notion, Supabase, Vercel, Stripe, Cloudflare, Sentry, etc.)
- **agentskills.io**: registro aperto per Claude Code skills
- **github.com/modelcontextprotocol/servers**: server MCP ufficiali e community

---

## Dev Agent Record

### Agent Model Used

claude-sonnet-4-6

### Debug Log References

- Ricerca web effettuata il 2026-04-10 per inventario skills e MCP
- 224 skills trovati in `.claude/skills/` (non tutti listati, quelli rilevanti sopra)
- 10 MCP in `laravel/.mcp.json`; 0 globali in `~/.claude/settings.json`

### Completion Notes List

### File List

- `laravel/.mcp.json` — aggiungere entry `playwright` dopo Task 1
- `_bmad-output/implementation-artifacts/sprint-status.yaml` — aggiornare stati

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-10 | Creata story 8.1 con inventario completo skills (224) e MCP (10). Identificato Playwright MCP come priorità critica per sbloccare Epic 6 visual testing. |
