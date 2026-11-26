# Archive — documentazione legacy del modulo Geo

Questa cartella conserva la documentazione storica del modulo Geo rimossa da `docs/`
per rispettare il limite di 100 file `.md` (issue #97). Il contenuto e' integralmente
recuperabile anche dalla cronologia git.

## Struttura

- `docs-legacy/root/` — file `.md` che stavano direttamente in `docs/` (guide, analisi,
  report PHPStan, draft, duplicati per suffisso `-N`).
- `docs-legacy/<nome>/` — sottocartelle spostate cosi' come da `docs/` (`raw/`, `chat/`,
  `claude/`, `prompts/`, `roadmap/`, `phpstan/`, `ai/`, `bmad/`, `models/`, `testing/`,
  `filament/`, `development/`, `git/`, `merge-conflicts/`, `laravel-13-upgrade/`, ecc.).
- `docs-legacy/stories/` — story BMAD concluse o senza stato attivo (in `docs/stories/`
  restano solo le story attive: ready-for-dev / review / pending).
- `docs-legacy/wiki/` — pagine della llm-wiki non piu' correnti (`concepts/`,
  `troubleshooting/`, `_templates/`, `_archive/` e file sciolti); in `docs/wiki/`
  restano indice, regole, memories, skills, decisioni, convenzioni ed entities.

## Note

- `docs/chat/` era gia' un archivio dichiarato in sola lettura: spostato qui per intero.
- `docs/raw/` + `docs/wiki/` costituivano la coppia llm-wiki (sorgenti + wiki generata):
  la parte wiki corrente resta in `docs/wiki/`, `docs/raw/` e i concetti generati
  sono qui. Gli script in `docs/scripts/wiki/` e i riferimenti `qmd` possono puntare
  ancora ai vecchi percorsi: da considerare riferimenti storici.
- I file junk (`*.old`, `*.bak`, zero-byte, duplicati `*-N.md`) sono stati eliminati
  direttamente: la cronologia git li conserva.
