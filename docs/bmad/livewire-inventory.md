---
title: "Inventario Http/Livewire → Filament widget — Geo"
type: inventory
module: Geo
status: approved
related:
  - ./livewire-widget-conversion.md
  - ./livewire-widget-prd.md
  - ./livewire-widget-architecture.md
  - ./livewire-widget-epics.md
  - ../stories/12.1.retire-geo-test-livewire.story.md
---

# Inventario: Livewire HTTP → Filament (modulo Geo)

**Perché.** Auto-discover Livewire monta ogni classe in `app/Http/Livewire`. `Test` era un residuo di sviluppo senza punti di richiamo: ritirarlo toglie un alias globale `test` e una vista orfana. `FormSearchAddressCategories` resta HTTP front-office: non è un widget dashboard.

## Le classi Livewire del modulo

Dopo 12.1 resta una sola classe sotto `app/Http/Livewire`:

1. `Modules\Geo\Http\Livewire\FormSearchAddressCategories` — `app/Http/Livewire/FormSearchAddressCategories.php`.

`Modules\Geo\Http\Livewire\Test` è **ritirato** (PHP, vista `livewire/test.blade.php`, copie `.test`, voce `_components.json`). `_components.json` contiene solo `form-search-address-categories`.

## Come vengono montate (o non montate)

Il modulo non registra manualmente nessun componente Livewire: `GeoServiceProvider` estende `XotBaseServiceProvider` senza override di `registerLivewireComponents()`. La registrazione ereditata scandisce `app/Http/Livewire` e `_components.json`.

`AdminPanelProvider` non contiene render hook verso queste classi. I tre `@livewire(` nel modulo Geo puntano a widget Filament con FQCN esplicito (`LocationMapWidget`, `LocationMapTableWidget`, `Modules\Blog\Filament\Widgets\SampleChartWidget`) nelle viste mappa. Nessuna rotta attiva in `routes/web.php` / `api.php`.

### `Test` — ritirato (Cluster C, story 12.1)

Componente strutturale morto: nessun `mount()`, nessuna proprietà pubblica, vista disallineata (`createAddress` / `$lookup` inesistenti sulla classe). Zero chiamanti repo-wide. Non è candidato a widget: non c'era logica viva da preservare.

**Stato 12.1:** file assenti. Pest `HttpLivewireTestRetiredTest` asserisce `class_exists(..., false)` e file assente.

### `FormSearchAddressCategories` — form FO ricerca indirizzi/categorie, non widget KPI

Form front-office "cerca il tuo indirizzo": autocomplete Google Address, filtro categorie (query reale commentata), fallback `saveNotServed()`. Vista hero homepage, non pannello admin. Wrapper Blade `x-geo::form-search-address-categories` oggi non incluso da nessun tema/modulo.

Nessun gemello Filament copre ricerca indirizzo + categorie + `not_served`. I widget mappa (`GeoMapWidget`, `LocationMapWidget`, `LocationMapTableWidget`, …) sono visualizzazione admin, non questo form.

**Verdetto: Cluster C. Non convertito a widget in 12.1** (FR-G003). Resta Livewire HTTP finché una story di prodotto non decide ritiro, ripristino FO, o altro — mai come `XotBaseWidget` KPI.

## Tabella riassuntiva

| Classe | Definizione | Montata in chrome Filament? | Gemello widget esistente? | Cluster | Azione |
|---|---|---|---|---|---|
| `Http\Livewire\Test` | ritirato | No | N/A | C | **Done 12.1** — PHP, vista, `_components.json` |
| `Http\Livewire\FormSearchAddressCategories` | `app/Http/Livewire/FormSearchAddressCategories.php` | No | No | C | **Non convertito** in 12.1; resta HTTP FO |

## Nessun candidato Cluster A o B

Nessuna classe Livewire Geo è montata via render hook nel panel provider. I map widget FQCN nelle viste restano intatti (fuori scope 12.1).
