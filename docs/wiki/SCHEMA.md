---
title: Wiki Schema
description: Schema e convenzioni per la manutenzione della wiki
tags:
  - schema
  - conventions
  - llm-instructions
created: 2026-04-15
---

# Wiki Schema

Questo documento istruisce l'LLM su come strutturare e mantenere la wiki.

## Struttura Directory

```
docs/
├── wiki/
│   ├── index.md           # Catalogo (aggiornare su ogni ingest)
│   ├── log.md             # Registro cronologico (append-only)
│   ├── SCHEMA.md          # Questo file
│   ├── concepts/          # Pagine concetto (pattern, architettura)
│   ├── entities/          # Pagine entità (modelli, azioni)
│   ├── sources/           # Riferimenti documentazione esterna
│   └── comparisons/       # Tabelle comparative
└── raw/                   # Sorgenti immutable
    ├── papers/
    ├── articles/
    └── notes/
```

## Convenzioni Naming

### File Markdown

- usare kebab-case: `authentication-flow.md`
- entities: `entity-<name>.md`
- concepts: `concept-<name>.md`
- sources: `source-<name>.md`

### Frontmatter

```yaml
---
title: Titolo Descrittivo
description: Breve descrizione
tags:
  - tag1
  - tag2
created: 2026-04-15
updated: 2026-04-15
sources:
  - docs/raw/papers/laravel-auth.md
---
```

## Workflow Ingest

1. Leggi source in `docs/raw/`
2. Estrai key information
3. Crea/aggiorna pagine in `docs/wiki/`
4. Aggiorna `index.md`
5. Appendi a `log.md`

## Workflow Query

1. Leggi `index.md` per trovare pagine rilevanti
2. Drill-down nelle pagine
3. Sintetizza risposta con citazioni

## Workflow Lint

1. Cerca contraddizioni tra pagine
2. Identifica claim obsoleti
3. Trova orphan pages (nessun inbound link)
4. Suggerisci cross-references mancanti

## Cross-Reference Format

```markdown
Vedi anche: [Authentication Flow](../concepts/authentication-flow.md)
```

## Cosa Evitare

- Non modificare file in `docs/raw/`
- Non sovrascrivere pagine esistenti senza ragione
- Non creare pagine duplicate
- Non rimuovere contenuto (marchia come deprecated)
