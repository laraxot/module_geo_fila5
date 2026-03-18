# BMAD Method Integration

## Overview

Questo progetto usa il **BMAD Method** (Breakthrough Method for Agile AI Driven Development) per workflow strutturati di sviluppo AI-driven.

## Risorse

- **Repo BMAD**: [github.com/bmad-code-org/BMAD-METHOD](https://github.com/bmad-code-org/BMAD-METHOD)
- **Docs BMAD**: [docs.bmad-method.org](https://docs.bmad-method.org)
- **Discord**: [discord.gg/gk8jAdXWmj](https://discord.gg/gk8jAdXWmj)

## Configurazione Locale

```
_bmad/                    # Configurazione BMAD
  _config/
    bmad-help.csv       # Catalog workflow
  bmm/                   # BMM module
    config.yaml         # Configurazione progetto
    agents/              # Agent definitions
    workflows/           # Workflow definitions
  core/                  # Core skills
.claude/skills/           # Skills BMAD
```

## Workflow Consigliati

### Per nuove feature
1. `bmad-brainstorming` - Per ideazione
2. `bmad-create-prd` - Per requisiti
3. `bmad-create-architecture` - Per architettura
4. `bmad-create-epics-and-stories` - Per task
5. `bmad-sprint-planning` - Per piano sprint
6. `bmad-quick-dev` - Per implementazione rapida

### Per bug fix
- `bmad-quick-dev-new-preview` - Workflow unificato (sperimentale)

### Per documentazione
- `bmad-document-project` - Analizza progetto esistente
- `bmad-generate-project-context` - Genera contesto per LLM
- `bmad-index-docs` - Crea indice documentazione

## Agent Disponibili

| Agent | Ruolo | Command |
|-------|-------|---------|
| **analyst** | Business Analyst | Ricerche di mercato, analisi competitiva |
| **architect** | Architect | Sistemi distribuiti, cloud, API design |
| **dev** | Developer Agent | Esecuzione story, TDD, implementazione |
| **pm** | Product Manager | PRD, requisiti, stakeholder alignment |
| **qa** | QA Engineer | Test automation, API/E2E testing |
| **sm** | Scrum Master | Sprint planning, story preparation |
| **ux-designer** | UX Designer | User research, interaction design |

## Quick Commands

| Azione | Comando |
|--------|---------|
| Chiedere aiuto BMAD | `bmad-help` o "cosa devo fare dopo?" |
| Brainstorming | `bmad-brainstorming` |
| Quick Dev | `bmad-quick-dev` |
| Party Mode | `bmad-party-mode` (multi-agent discussion) |

## Integrazione Laravel/Laraxot

BMAD è configurato con skill specifiche per Laravel/Laraxot:

### Skills Laravel
- `bmad-laravel-tdd` - TDD workflow
- `bmad-laravel-best-practices` - Best practices Laravel
- `bmad-laravel-architecture` - Architecture decisions
- `bmad-laravel-testing` - Testing patterns
- `bmad-laravel-quality` - Code quality (PHPStan, Pint)

### Skills Laraxot
- `bmad-laraxot-module-dev` - Module development
- `bmad-laraxot-filament-rules` - Filament conventions
- `bmad-laraxot-testing-pest` - Pest testing

## Best Practices

1. **Usa `bmad-help`** quando non sai cosa fare dopo
2. **Parti da brainstorming** per feature complesse
3. **Tieni i spec brevi** (900-1600 tokens)
4. **Segui la sequenza** dei workflow BMAD
5. **Documenta tutto** con `bmad-document-project`

## Aggiornamento

Per sincronizzare con l'ultima versione BMAD:

```bash
# Clona repo BMAD
cd /tmp && rm -rf BMAD-METHOD && git clone --depth 1 https://github.com/bmad-code-org/BMAD-METHOD.git

# Copia skill aggiornate
cp -r /tmp/BMAD-METHOD/src/core-skills/* .claude/skills/
cp -r /tmp/BMAD-METHOD/src/bmm-skills/* .claude/skills/

# Aggiorna config se necessario
diff _bmad/_config/bmad-help.csv /tmp/BMAD-METHOD/src/bmm-skills/module-help.csv
```
