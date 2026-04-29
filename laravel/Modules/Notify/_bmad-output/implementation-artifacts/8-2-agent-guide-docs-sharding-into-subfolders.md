# Story 8.2: Shard dei file guida agent in sottocartelle `.agents/docs` con link relativi bidirezionali

Status: ready-for-dev

## Story

Come **maintainer della documentazione agentica** del progetto,
voglio spezzare `CLAUDE.md`, `AGENTS.md`, `QWEN.md` e l'eventuale `GEMINI.md` in file `.md` più piccoli dentro sottocartelle dedicate sotto `./.agents/docs/`,
così da avere documentazione navigabile, modulare e mantenibile con collegamenti relativi bidirezionali coerenti.

## Contesto

### Input richiesti dall'utente

L'utente ha richiesto esplicitamente di:
- spezzare `CLAUDE.md`
- spezzare `AGENTS.md`
- spezzare `QWEN.md`
- spezzare `GEMINI.md`
- mettere i file risultanti dentro una **sottocartella** di `./.agents/docs`
- aggiungere **collegamenti relativi bidirezionali**

### Stato attuale del repository

Percorso doc target: `/var/www/_bases/base_fixcity_fila5/.agents/docs`

Situazione rilevata:
- `.agents` è un symlink a `bashscripts/ai/.agents`
- in `.agents/docs` esistono già vari file split in formato piatto, ad esempio:
  - `claude-split-index.md`
  - `qwen-split-index.md`
  - `agents-split-index.md`
  - `claude-overview.md`, `claude-patterns.md`, `claude-pitfalls.md`, ...
  - `qwen-overview.md`, `qwen-critical-rules.md`, `qwen-memories.md`, ...
  - `agents-overview.md`, `agents-coding-standards.md`, `agents-project-rules.md`, ...
- il pattern attuale è quindi **parzialmente shardato ma non organizzato in sottocartelle dedicate**, che è il requisito nuovo dell'utente

### Input sorgente rilevati

- `AGENTS.md`: presente, circa 5349 righe, candidato principale allo shard strutturato
- `CLAUDE.md`: presente, circa 28 righe, piccolo ma comunque richiesto esplicitamente dall'utente
- `QWEN.md`: presente, circa 47 righe nel file attuale ma con contenuto operativo denso
- `GEMINI.md`: **non presente** nel repository al momento della creazione della story

### Implicazione importante

L'implementazione NON deve inventare contenuti per `GEMINI.md`.
Se il file rimane assente anche in fase dev, il lavoro corretto è:
- verificare che non esista in altra posizione canonica del repo
- documentare l'assenza
- creare al massimo un indice/README della sottocartella `gemini/` che dichiari esplicitamente il source mancante
- NON fabbricare shard fittizi privi di sorgente

### Direzione architetturale desiderata

La documentazione shardata deve convergere verso una struttura del tipo:

```text
.agents/docs/
  claude/
    index.md
    overview.md
    ...
  agents/
    index.md
    overview.md
    ...
  qwen/
    index.md
    overview.md
    ...
  gemini/
    index.md
    ...
```

I file piatti legacy vanno:
- migrati o sostituiti da file nelle sottocartelle
- lasciati come redirect stub solo se necessario per backward compatibility
- comunque aggiornati con link relativi verso la nuova posizione se rimangono in repo

---

## Acceptance Criteria

1. **Sottocartelle dedicate create**: esistono sottocartelle dedicate sotto `./.agents/docs/` per almeno `claude/`, `agents/`, `qwen/` e, se gestito, `gemini/`.
2. **Shard reali e non monolitici**: ciascun file sorgente disponibile (`CLAUDE.md`, `AGENTS.md`, `QWEN.md`) è stato spezzato in più file `.md` semanticamente coerenti, non in un solo duplicato rinominato.
3. **Indice per sorgente**: ogni sottocartella ha un `index.md` o `split-index.md` che elenca gli shard generati e il loro contenuto.
4. **Link relativi bidirezionali interni**: ogni shard punta almeno a:
   - indice della propria sottocartella
   - file sorgente originale
   e l'indice punta a tutti gli shard.
5. **Link relativi bidirezionali globali**: i file sorgente originali (`CLAUDE.md`, `AGENTS.md`, `QWEN.md`, e `GEMINI.md` se presente) contengono link relativi verso il nuovo indice nella sottocartella dedicata.
6. **Nessun link assoluto locale**: nei documenti toccati non si usano path assoluti filesystem; i collegamenti sono relativi.
7. **Consolidamento dell'esistente**: i file split piatti già presenti in `.agents/docs` per Claude/Qwen/Agents vengono migrati, riusati o rimpiazzati in modo da evitare doppioni incoerenti tra root di `.agents/docs` e nuove sottocartelle.
8. **Gestione corretta di `GEMINI.md` mancante**: se `GEMINI.md` non esiste, la documentazione risultante esplicita l'assenza della sorgente senza inventare contenuto.
9. **Indice superiore aggiornato**: un indice esistente in `.agents/docs` (ad esempio `index.md` o `00-INDEX.md`) viene aggiornato con link relativi alle nuove sottocartelle o ai loro indici.
10. **Verifica repository-safe**: i link risultanti sono navigabili dal repo e non rompono il pattern documentale già presente in `.agents/docs`.

---

## Tasks / Subtasks

- [ ] **Task 1 - Analisi e mappatura delle sorgenti agent**
  - [ ] Leggere `CLAUDE.md`, `AGENTS.md`, `QWEN.md`
  - [ ] Verificare se `GEMINI.md` esiste davvero o se esiste un sostituto canonico nel repository
  - [ ] Mappare i file split già presenti in `.agents/docs` che derivano da Claude, Agents e Qwen
  - [ ] Definire una tassonomia di shard per ciascuna sorgente

- [ ] **Task 2 - Struttura sottocartelle target**
  - [ ] Creare le sottocartelle target sotto `.agents/docs/`
  - [ ] Definire naming consistente dei file shard (`overview.md`, `rules.md`, `patterns.md`, ecc.)
  - [ ] Evitare collisioni con i file piatti già esistenti

- [ ] **Task 3 - Shard di `AGENTS.md`**
  - [ ] Spezzare `AGENTS.md` in file più piccoli organizzati per sezioni logiche
  - [ ] Creare indice locale della sottocartella `agents/`
  - [ ] Inserire link relativi bidirezionali tra indice, shard e `../../../AGENTS.md` o path relativo corretto
  - [ ] Aggiornare `AGENTS.md` con collegamento relativo al nuovo indice shardato

- [ ] **Task 4 - Shard di `CLAUDE.md`**
  - [ ] Spezzare `CLAUDE.md` in file piccoli ma sensati anche se la sorgente è breve
  - [ ] Creare indice locale della sottocartella `claude/`
  - [ ] Inserire link relativi bidirezionali tra indice, shard e file originale
  - [ ] Aggiornare `CLAUDE.md` con collegamento relativo al nuovo indice shardato

- [ ] **Task 5 - Shard di `QWEN.md`**
  - [ ] Spezzare `QWEN.md` in file più piccoli per argomento
  - [ ] Creare indice locale della sottocartella `qwen/`
  - [ ] Inserire link relativi bidirezionali tra indice, shard e file originale
  - [ ] Aggiornare `QWEN.md` con collegamento relativo al nuovo indice shardato

- [ ] **Task 6 - Gestione `GEMINI.md`**
  - [ ] Se `GEMINI.md` esiste, shardarlo con lo stesso standard
  - [ ] Se `GEMINI.md` non esiste, creare documentazione minima che dichiari il source mancante senza inventare contenuti
  - [ ] Garantire comunque una navigazione coerente dalla root docs verso `gemini/`

- [ ] **Task 7 - Consolidamento dei file split legacy**
  - [ ] Valutare i file piatti legacy (`claude-split-index.md`, `qwen-split-index.md`, `agents-split-index.md`, ecc.)
  - [ ] Decidere se trasformarli in stub/redirect, migrarli o rimuoverli se ridondanti
  - [ ] Assicurare che non restino due fonti divergenti per la stessa documentazione

- [ ] **Task 8 - Aggiornamento indici e cross-link**
  - [ ] Aggiornare `./.agents/docs/index.md` e/o `./.agents/docs/00-INDEX.md`
  - [ ] Assicurare link relativi bidirezionali tra indice root, indici di sottocartella e shard
  - [ ] Verificare manualmente che i link non puntino a path assoluti

- [ ] **Task 9 - Verifica finale**
  - [ ] Verificare che ogni shard abbia backlink all'indice locale e al file sorgente
  - [ ] Verificare che ogni file sorgente abbia forward link all'indice shardato
  - [ ] Verificare che i link siano tutti relativi
  - [ ] Aggiornare `sprint-status.yaml` portando la story a `done` quando completata

---

## Dev Notes

### Vincoli progettuali rilevanti

- L'utente ha chiesto esplicitamente **sottocartelle** sotto `./.agents/docs`, quindi la soluzione NON può limitarsi ad aggiungere altri file piatti in `.agents/docs/`.
- La richiesta parla di **collegamenti relativi bidirezionali**: è un requisito esplicito, non opzionale.
- La documentazione già presente in `.agents/docs` mostra che esiste un precedente tentativo di split, ma non nel formato richiesto ora.
- `AGENTS.md` è molto più grande delle altre sorgenti e va considerato il candidato principale per uno shard più granulare.
- `CLAUDE.md` e `QWEN.md` sono piccoli, ma la richiesta è esplicita: vanno comunque portati dentro la nuova struttura a sottocartelle.
- `GEMINI.md` al momento non è presente: non va inventato.

### Strategia suggerita per i path relativi

Esempio se si crea `.agents/docs/agents/index.md`:
- da `AGENTS.md` verso indice shardato: `./.agents/docs/agents/index.md`
- da `agents/index.md` verso sorgente: `../../../AGENTS.md`
- da `agents/rules.md` verso indice locale: `./index.md`
- da `agents/rules.md` verso sorgente: `../../../AGENTS.md`
- da indice root `.agents/docs/index.md` verso `agents/index.md`: `./agents/index.md`

### Non fare

- Non usare path assoluti filesystem nei link markdown
- Non duplicare gli stessi contenuti in root `.agents/docs` e nella sottocartella finale senza chiarire quale sia la source of truth
- Non creare shard fittizi per `GEMINI.md` se la sorgente manca
- Non lasciare indici monchi senza backlink ai file originali

### File candidati da toccare

- `AGENTS.md`
- `CLAUDE.md`
- `QWEN.md`
- `GEMINI.md` se presente in fase implementativa
- `.agents/docs/index.md`
- `.agents/docs/00-INDEX.md`
- `.agents/docs/agents/`
- `.agents/docs/claude/`
- `.agents/docs/qwen/`
- `.agents/docs/gemini/`
- eventuali file split legacy in `.agents/docs/` da convertire in redirect o consolidare

---

## Dev Agent Record

### Agent Model Used

gpt-5

### Debug Log References

- `.agents` rilevato come symlink a `bashscripts/ai/.agents`
- `.agents/docs` contiene già split docs piatti per Claude, Qwen e Agents
- `AGENTS.md` presente e molto grande (~5349 righe)
- `CLAUDE.md` presente (~28 righe)
- `QWEN.md` presente (~47 righe nel file corrente)
- `GEMINI.md` non trovato al momento della creazione story

### Completion Notes List

- Story creata come refactor documentale strutturale, non come semplice task di copy-edit
- Acceptance criteria forzano sottocartelle, bidirezionalità e link relativi
- Inclusa gestione esplicita del caso `GEMINI.md` mancante

### File List

- `_bmad-output/implementation-artifacts/8-2-agent-guide-docs-sharding-into-subfolders.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-12 | Creata story 8.2 per spezzare `CLAUDE.md`, `AGENTS.md`, `QWEN.md` e gestire `GEMINI.md` in sottocartelle dedicate sotto `.agents/docs` con link relativi bidirezionali e consolidamento dei file split legacy esistenti. |
