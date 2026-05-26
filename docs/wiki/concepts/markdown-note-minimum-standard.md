---
title: "Standard minimo per note Markdown (.md)"
module: "ptvx-project"
type: concept
status: approved
tags: [markdown, yaml, front-matter, second-brain, ai-retrieval, documentation]
created: "2026-05-19T00:00:00Z"
updated: "2026-05-26T00:00:00Z"
qmd: "markdown front matter, YAML metadata, atomic note, second brain tip 020, HackerNoon"
related:
  - "../rules/markdown-documentation-standard.md"
  - "./second-brain-operating-model.md"
  - "../sources/second-brain-external-benchmarks.md"
  - "../how-to/module-wiki-documentation.md"
  - "../how-to/theme-wiki-documentation.md"
---

# Standard minimo per note Markdown (.md)

> **Normativa completa:** [Standard Markdown — scrittura e denominazione dei file (.md)](../rules/markdown-documentation-standard.md) — obbligatoria per gli agenti; questo foglio è il riassunto filosofico/minimo più mapping PARA.
>
> Contratto minimo allineato a [AI Coding Tip 020 — Create a Second Brain](https://hackernoon.com/ai-coding-tip-020-create-a-second-brain) (Maxi Contieri, 2026): metadati YAML strutturati + note atomiche + collegamenti espliciti al **perché** due concetti si legano. Qui è adattato alle convenzioni **Laraxot / wiki root** (nomi file, `qmd`, federazione modulo/tema).

## Perché esiste

Il front matter è la «scheda bibliografica» machine-readable della pagina: migliora retrieval (`qmd`, grep, agent), ranking semantico e consistenza tra sessioni LLM (memoria esterna su disco, non solo contesto).

## Front matter — chiavi minime

Ogni nuovo file `.md` in **`docs/wiki/`** (e, dove applicabile, wiki modulo/tema) deve aprire con YAML tra `---`:

| Chiave | Obbligatorio | Ruolo |
|--------|--------------|--------|
| `title` | sì | Titolo umano della nota |
| `type` | sì | Es. `concept`, `rule`, `source`, `how-to`, `memory`, `index` |
| `tags` | consigliato | Lista stringhe per ricerca e clustering |
| `created` | consigliato | Data ISO (`YYYY-MM-DD` o `YYYY-MM-DDTHH:mm:ssZ`) |
| `related` | consigliato | Path relativi ad altre pagine wiki (non solo titoli «orfani») |
| `qmd` | consigliato (wiki root) | Frase chiave breve per `qmd search` |
| `status` | opzionale | `draft` \| `approved` \| `deprecated` |
| `module` | opzionale | Es. `ptvx-project` o nome modulo |
| `updated` | opzionale | Ultimo aggiornamento significativo |

**Esempio (estratto):**

```yaml
---
title: "JWT Authentication Design"
type: concept
status: approved
component: auth-service
tags: [security, backend]
created: 2026-05-19
related:
  - "../rules/session-policy.md"
  - "./oauth-flow.md"
---
```

Aggiungere altre chiavi (`component`, `author`, `status`, `director`, …) solo se portano valore di retrieval o ownership; evitare duplicate concettuali con `tags`.

Chiavi **opzionali utili** (ispirate all’articolo): `component`, `status` (`draft` \| `approved` \| `deprecated`), date `created` / `updated` in ISO.

## PARA → mapping in questo monorepo

L’articolo usa PARA (Projects, Areas, Resources, Archives). Qui non copiamo cartelle Obsidian; mappiamo **ruoli**:

| PARA | Dove nel repo | Esempio |
|------|----------------|---------|
| **Projects** | issue GitHub, `docs/chat/<slug>.md`, task attivi | hardening wiki, feature branch |
| **Areas** | `docs/wiki/rules/`, `docs/wiki/concepts/` | namespace, Filament, second brain |
| **Resources** | `docs/wiki/sources/`, `docs/raw/`, how-to | benchmark esterni, evidenza |
| **Archives** | **non** cartelle `archive/` / `_archive/` nel repo | storico = `git log`; forward-only |

## Buona vs cattiva nota (Tip 020)

| Cattiva | Buona |
|---------|--------|
| Titolo vaglio + corpo senza metadati | YAML completo + H1 + sezioni mirate |
| «Crea una nota sul film X» senza struttura | `title`, `type`, `tags`, `related`, sezioni Summary / Themes / Related |
| Solo wikilink `[[Nome]]` senza file | `related:` con path relativi verificati (`test -f`) |
| Incollare chat intera | Distillare: decisione, ambito, verifica, link |

## Corpo della nota — struttura minima

1. **Titolo H1** ripetuto o coerente col `title` nel front matter.
2. **Blocco citazione** opzionale con intento / contesto operativo (una riga).
3. **Sezioni brevi** adatte al compito: contesto, decisione, procedure, verifica, riferimenti.
4. **`## Related` / `## References`** in coda con link markdown relativi e, se serve, motivazione in-line («collegato perché …»).

Lo spirito **Zettelkasten / atomicità**: **un’idea o workflow durabile per file**; se la pagina diverge su due temi distinti, splittare e collegare.

## Convenzioni **solo Laraxot / questo repo**

- **Nomi file**: minuscolo, kebab-case; **nessuna data nel nome**; eccezione **`README.md`** dove già contratto attivo ([naming conventions](../rules/naming-conventions.md)).
- **`docs/chat/<slug>.md`**: stesso standard YAML+corpo; slug = argomento stabile (vedi `llm-wiki.txt` § Inter-Agent).
- Non sostituire la wiki con paste lunghi da chat: distillare e aggiornare **una** pagina atomica + riga in `docs/wiki/log.md` se decisione riusabile.
- **Stub per scope** (Tip 014): `CLAUDE.md` / `AGENTS.md` ≤50 righe → trigger map; non duplicare il corpora nel bootstrap.
- **Accesso AI**: preferire file locali versionati + `qmd search --limit N`; non MCP remoti per la wiki canonica.

## Checklist agent (prima di considerare la pagina pronta)

- [ ] File inizia con `---` YAML valido (`title`, `type`, almeno `tags` o `qmd`)
- [ ] Un solo tema principale; se >~80 righe utili, valutare split
- [ ] `related` e sezione References usano path relativi esistenti
- [ ] Nessuna cartella vietata (`_archive/`, `.cache/` in root)
- [ ] Dopo >10 pagine nuove o refactor strutturale: `qmd update`

## Riferimenti

- [Standard Markdown — scrittura e denominazione (norma agenti)](../rules/markdown-documentation-standard.md)
- [Second Brain Operating Model](./second-brain-operating-model.md)
- [Second Brain External Benchmarks](../sources/second-brain-external-benchmarks.md) — include il link verificato all’articolo HackerNoon
- [Module Wiki Documentation](../how-to/module-wiki-documentation.md)
- [Theme Wiki Documentation](../how-to/theme-wiki-documentation.md)
