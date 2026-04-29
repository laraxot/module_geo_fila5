---
title: "Second Brain External Benchmarks"
module: "ptvx-project"
type: source
created: "2026-04-29T09:19:00Z"
updated: "2026-04-29T09:19:00Z"
qmd: "second brain, code method, para framework, progressive summarization, karpathy llm wiki, knowledge compounding"
related:
  - "[[Second Brain Operating Model]]"
  - "[[Second Brain Continuous Improvement]]"
  - "[[BMAD Operating Model]]"
---

# Second Brain External Benchmarks

> Sintesi di benchmark esterni per migliorare efficienza ed efficacia del second brain del repository.

## Fonti sintetizzate

- Forte Labs: Building a Second Brain (metodo CODE, organizzazione orientata all'azione)
- Forte Labs: Progressive Summarization (compressione iterativa delle note)
- Karpathy LLM Wiki gist (wiki compilata e incrementale come memoria persistente)

## Principi trasferibili al progetto

1. **Capture selettivo, non esaustivo**  
   Nelle passate di ingest salvare solo conoscenza riusabile per sviluppo e manutenzione, evitando dump narrativi.

2. **Organizzazione per azionabilita'**  
   Classificare le note in base a task attivi (bugfix, story, refactor) invece di categorie astratte.

3. **Distill progressivo**  
   Ogni volta che una pagina viene toccata, ridurre testo, ambiguita' e duplicazioni.

4. **Express in artifact di delivery**  
   Ogni insight deve sfociare in output operativo: story BMAD, regola wiki, checklist modulo/tema.

5. **Wiki compilata e incrementale**  
   Il valore cresce quando i risultati restano in `docs/wiki/` e non solo nel contesto temporaneo della sessione.

## Mapping operativo (root/moduli/temi)

- **Root wiki (`docs/wiki/`)**: regole cross-modulo e processo BMAD.
- **Wiki modulo (`laravel/Modules/*/docs/wiki/`)**: logica di business locale e vincoli architetturali.
- **Wiki tema (`laravel/Themes/*/docs/wiki/`)**: comportamento UX/presentazione e policy di delivery frontend.

## Decisione operativa

Per ogni `/bmad-create-story`:

1. leggere prima `docs/wiki/` pertinente
2. consultare solo le fonti raw necessarie
3. creare/aggiornare story in `_bmad-output/implementation-artifacts/`
4. aggiornare indice wiki locale
5. append su `log.md` locale e root se insight cross-cutting

## Riferimenti

- [Second Brain Operating Model](../concepts/second-brain-operating-model.md)
- [Second Brain Continuous Improvement](../concepts/second-brain-continuous-improvement.md)
- [BMAD Operating Model](../concepts/bmad-operating-model.md)
