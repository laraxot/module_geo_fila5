---
title: "Sweep marcatori merge Git (repo hygiene)"
type: guide
module: "ptvx-project"
tags: [git, merge-conflicts, docs, second-brain]
updated: "2026-05-26"
related:
  - "../sources/git-collision-docs-cleanup-report.md"
  - "../concepts/second-brain-operating-model.md"
  - "../rules/00-TRIGGER_MAP.md"
---

# Sweep marcatori merge Git

## Scopo

Ripristinare tree e **second brain** quando restano righe `<<<<<<<`, `=======`, `>>>>>>>` (anche solo ORFANE, es. `>>>>>>> commit`) dopo merge imperfetti.

## Quando farlo

- Prima di PHPStan Larastan / PHPUnit su percorsi ampi
- Dopo audit documentazione modulo/tema (vedi anche [`git-collision-docs-cleanup-report.md`](../sources/git-collision-docs-cleanup-report.md))
- Quando `git grep` trova marcatori nei sorgenti

## Comandi sicuri

Solo **CODICE**: PHP, Neon, Blade, XML di config (non `.phar`; dentro i Phar compaiono sequenze `=======` casuali — falsi positivi).

```bash
git grep -n '^<<<<<<< ' -- '*.php' '*.neon' '*.xml' '*.blade.php'
git grep -n '^>>>>>>> '  -- '*.php' '*.neon' '*.xml' '*.blade.php'
```

Per **solo righe SEPARATORE lunghezza 7 caratteri** (attenzione: non usare su markdown che impiegano `<hr>` con esattamente sette `=` se presenti):

```bash
git grep -n '^=======$' -- '*.php' '*.neon' '*.blade.php'
```

### Documentazione Markdown

Per archivi storici tipo `docs/raw/history/**/*.md`:

```bash
sed -i '/^<<<<<<< /d;/^>>>>>>> /d;/^=\{7\}$/d' -- path/to/file.md
```

Sostituire sempre la **semantic merge** quando due versioni dovevano essere conciliate; lo strip è accettabile per residui dopo duplicazione o linee spurie.

### Config path `docs/`

Il folder `docs/` ospita anche template Composer/PHPStan/PHPUnit (`phpstan.neon.dist`, `phpunit.xml.dist`, `.php_cs.dist.php`). Devono essere **validi sintatticamente**. Se sono pasticcio irreversibile, ricostruirli dai template Laravel in `laravel/` o dai file canonici nella stessa directory (`.php-cs-fixer.dist.php`).

## Chiusura

- Aggiornare [`../log.md`](../log.md)
- Allegare audit su issue correlata quando la policy pubblica cambia (vedi [`github-issue-agent-discipline.md`](./github-issue-agent-discipline.md))
