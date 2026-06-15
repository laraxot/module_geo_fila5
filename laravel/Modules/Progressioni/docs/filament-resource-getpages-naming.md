# Progressioni — `getPages()` e convenzione Page

## Scopo

Nel modulo Progressioni molte Resource dichiarano ancora `getPages()` anche quando potrebbero delegare a `XotBaseResource`. Questo documento elenca i casi del modulo e come allinearsi alla regola globale.

Regola completa: [Xot — getPages ridondante](../../Xot/docs/filament/getpages-redundancy-rule.md).

## Regola rapida

| Situazione | Azione |
| :--- | :--- |
| Page = `List{plural}`, `Create{name}`, `Edit{name}` e solo route CRUD | **Rimuovere** `getPages()` dalla Resource |
| Page con nome singolare diverso dal `$name` della Resource | **Mantenere** override finché non si rinomina |
| Presenza di `view` o pagine custom | **Mantenere** override |

`$name` = nome classe Resource senza `Resource` (es. `Assenze` da `AssenzeResource`).

## Pilota: `AssenzeResource` vs `CoeffResource`

### `CoeffResource` — override rimovibile

- Page attese dalla base: `ListCoeffs`, `CreateCoeff`, `EditCoeff`
- Page presenti: stessi nomi
- **Azione consigliata:** eliminare `getPages()` da `CoeffResource.php` dopo smoke test su list/create/edit

### `AssenzeResource` — override necessario (stato attuale)

- Page attese: `ListAssenzes`, `CreateAssenze`, `EditAssenze`
- Page presenti: `ListAssenza`, `CreateAssenza`, `EditAssenza`
- **Azione consigliata:** mantenere `getPages()` oppure rinominare le tre Page (e aggiornare riferimenti) prima di rimuovere l'override

Collegamento wire fase 3 (schemas/tables): [filament-resource-wire-assenze.md](./filament-resource-wire-assenze.md) — indipendente dalla regola `getPages`, ma stesso pilota Resource.

## Resource Progressioni analizzate (script)

Eseguire:

```bash
cd laravel
php ../bashscripts/filament/analyze-redundant-getpages.php | rg Progressioni
```

### Tipicamente `SAFE_TO_REMOVE` (solo CRUD standard + naming ok)

Include, tra le altre: `CoeffResource`, `CategoriaProproResource`, `CedDiffResource`, `CriteriOptionResource`, `CriteriPrecedenzaResource`, `CriteriValutazioneResource`, `EsclusiExtraResource`, `MaxCatecoPosfunAnnoResource`, `MyLogResource`, `PesiResource`, `SchedaCriteriResource`, `StabiDirigenteResource`, `StipendioTabellareResource`, `ValutatoreResource`.

### Tipicamente `MUST_KEEP`

| Resource | Motivo |
| :--- | :--- |
| `AssenzeResource` | Naming Page `*Assenza` vs plural `Assenzes` |
| `CriteriEsclusioneResource` | Chiavi duplicate / non standard nello override |
| `CriteriMaggiorazioneResource` | Chiavi duplicate nello override |
| `ProgressioniResource` | Solo pagine custom (`ListSchedaLogActivities`) |
| `BaseSchedaResource` | Pagina custom `CompilaScheda` |
| `MyLogResource` (se override con `view`) | Solo index/view, non CRUD completo |

Verificare sempre con lo script prima di ogni rimozione: lo stato del codice può cambiare.

## Ordine di intervento consigliato

1. Rimuovere `getPages()` dalle Resource in `SAFE_TO_REMOVE` (batch per PR piccole).
2. Allineare naming `AssenzeResource` / Page Assenza (decisione di dominio: singolare vs plurale nel modello).
3. Documentare in questa pagina ogni Resource che passa da `MUST_KEEP` a conforme.

## `SchedaResource` — ereditarietà pagine

Le Page CRUD di `SchedaResource` (Progressioni) **non** estendono le classi Xot direttamente:

| Page | Classe base (modulo Ptv) |
| :--- | :--- |
| `ListSchedas` | `Modules\Ptv\Filament\Resources\SchedaResource\Pages\BaseListSchedas` |
| `EditScheda` | `BaseEditScheda` |
| `CreateScheda` | `BaseCreateScheda` |

`ListScheda.php` duplicato è stato rimosso: l'index Filament è solo `ListSchedas`.

Regola completa e anti-pattern: [Ptv — scheda-resource-pages-inheritance.md](../../Ptv/docs/scheda-resource-pages-inheritance.md).

## Collegamenti

- [filament-resource-schemas-tables.md](./filament-resource-schemas-tables.md)
- [filament-resource-navigation.md](./filament-resource-navigation.md)
- [Ptv — scheda-resource-pages-inheritance.md](../../Ptv/docs/scheda-resource-pages-inheritance.md)
- [Xot — getpages-redundancy-rule.md](../../Xot/docs/filament/getpages-redundancy-rule.md)

*Ultimo aggiornamento: giugno 2025*
