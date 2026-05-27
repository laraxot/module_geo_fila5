---
title: "README obbligatorio in docs/ di ogni modulo e tema"
type: rule
status: approved
tags: [docs, readme, module, theme, mandatory, second-brain]
created: "2026-05-27"
updated: "2026-05-27"
qmd: "theme module docs README mandatory entrypoint second brain"
related:
  - "./00-TRIGGER_MAP.md"
  - "./markdown-documentation-standard.md"
  - "../standards/module-theme-release-showcase-standard.md"
  - "../../../laravel/Themes/Three/docs/README.md"
---

# README doppio obbligatorio — root e `docs/` (moduli e temi)

> Canonico esteso: [module-theme-readme-dual.md](../standards/module-theme-readme-dual.md) · batch: `node bashscripts/tools/sync-module-theme-readmes.mjs`

## Perché (due file, due scopi)

| File | Scopo | Pubblico |
| :--- | :--- | :--- |
| **`README.md` (root)** | Vetrina prodotto: valore, release, onboarding | visitatori repo, PM |
| **`docs/README.md`** | Mappa knowledge base: scopo tecnico, indice `docs/`, wiki | sviluppatori, agenti AI |

Senza **entrambi** la memoria locale è incompleta (es. Theme Three `docs/README.md` mancante fino al 2026-05-27).

## Regola (obbligatoria)

Prima di considerare completo un modulo (`laravel/Modules/<Name>/`) o un tema (`laravel/Themes/<Name>/`):

1. Verificare **`README.md`** in root **e** **`docs/README.md`** (maiuscole esatte).
2. Se manca uno dei due: **crearlo subito** (sync script o template Badge/Activity).
3. **`docs/README.md`**: scopo business, struttura, indice `.md` in `docs/`, link a `../README.md` e wiki root.
4. **`README.md` root**: sezione con link a `./docs/README.md`; niente duplicazione lunga dell'indice tecnico.
5. Vietato `docs/readme.md` minuscolo: rinominare in `overview-extended.md` o unificare, poi rimuovere il duplicato.

## Checklist agente

```bash
# Per ogni modulo/tema toccato nel task
test -f laravel/Modules/<Name>/docs/README.md || test -f laravel/Themes/<Name>/docs/README.md
```

Dopo creazione o modifica di qualsiasi `.md` in `docs/` del componente: aggiornare la tabella/indice in `docs/README.md`.

## Riferimenti

- [README doppio (standard)](../standards/module-theme-readme-dual.md)
- [Standard markdown](./markdown-documentation-standard.md)
- [Vetrina release moduli/temi](../standards/module-theme-release-showcase-standard.md)
- Esempi: [Badge](../../../laravel/Modules/Badge/docs/README.md), [Themes/Three](../../../laravel/Themes/Three/docs/README.md)
