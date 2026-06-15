# Metodi duplicati — Setting

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **36**
- Metodi duplicati trovati: **14**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `getHeaderActions` | 4 | candidato a trait/helper |
| `casts` | 2 | possibile duplicazione |
| `create` | 2 | possibile duplicazione |
| `definition` | 2 | possibile duplicazione |
| `delete` | 2 | possibile duplicazione |
| `forceDelete` | 2 | possibile duplicazione |
| `getRedirectUrl` | 2 | possibile duplicazione |
| `getViewData` | 2 | possibile duplicazione |
| `mount` | 2 | possibile duplicazione |
| `restore` | 2 | possibile duplicazione |
| `table` | 2 | possibile duplicazione |
| `update` | 2 | possibile duplicazione |
| `view` | 2 | possibile duplicazione |
| `viewAny` | 2 | possibile duplicazione |

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
