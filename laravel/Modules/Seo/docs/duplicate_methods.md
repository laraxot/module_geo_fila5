# Metodi duplicati — Seo

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **12**
- Metodi duplicati trovati: **17**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `get` | 3 | candidato a trait/helper |
| `__construct` | 2 | possibile duplicazione |
| `getAuthor` | 2 | possibile duplicazione |
| `getCanonical` | 2 | possibile duplicazione |
| `getColors` | 2 | possibile duplicazione |
| `getDescription` | 2 | possibile duplicazione |
| `getImage` | 2 | possibile duplicazione |
| `getKeywords` | 2 | possibile duplicazione |
| `getLocale` | 2 | possibile duplicazione |
| `getModifiedTime` | 2 | possibile duplicazione |
| `getPublishedTime` | 2 | possibile duplicazione |
| `getRobots` | 2 | possibile duplicazione |
| `getSiteName` | 2 | possibile duplicazione |
| `getTitle` | 2 | possibile duplicazione |
| `getType` | 2 | possibile duplicazione |
| `getUrl` | 2 | possibile duplicazione |
| `has` | 2 | possibile duplicazione |

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
