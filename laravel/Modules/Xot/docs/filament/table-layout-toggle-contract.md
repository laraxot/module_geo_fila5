---
module: Xot
topic: table-layout-toggle
status: open
---

# Contratto layout tabella (HasXotTable + UI)

## Perché esiste

Le liste Filament che usano `HasXotTable` espongono il bottone **Cambia layout** (modulo UI). Xot definisce **come** la tabella viene renderizzata; UI definisce **l’azione** di toggle e la persistenza in sessione.

## Responsabilità

| Modulo | Ruolo |
|--------|-------|
| **Xot** | `HasXotTable` usa `$layoutView` per `columns()` e `contentGrid()` |
| **UI** | `TableLayoutToggleTableAction`, `TableLayoutEnum`, `TableLayoutTrait` |

## Regola critica

`$layoutView` sulla pagina (`XotBaseListRecords`) è la **fonte di verità a runtime**. La sessione serve solo a **ripristinare** la preferenza al mount e a **salvarla** al toggle.

Senza sync mount/toggle → il bottone appare ma non cambia la vista (bug documentato in [UI bugfix](../../UI/docs/bugfix-table-layout-toggle-not-working.md)).

## Integrazione nelle ListRecords

`XotBaseListRecords` usa il trait `HasTableLayoutPage` (UI) per:

- `mount()` → `$this->layoutView = getCurrentLayout()`
- allineamento default `LIST` con `TableLayoutEnum::init()`

## Collegamenti

- [HasXotTable trait](./traits/has-xot-table.md)
- [UI — bugfix toggle non funzionante](../../../UI/docs/bugfix-table-layout-toggle-not-working.md)
- [UI — TableLayoutToggleTableAction](../../UI/docs/actions/table-layout-toggle.md)
