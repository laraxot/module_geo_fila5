# Project Context - FixCity Fila5

**Progetto:** FixCity - Piattaforma civica per segnalazione problemi urbani  
**Framework:** Laravel 12 + Filament v5 (Laraxot Modular Architecture)  
**Tema attivo:** Sixteen  
**Lingua documentazione:** Italiano  

---

## Stack Tecnologico

| Layer | Tecnologia |
|-------|-----------|
| **Backend** | PHP 8.3+, Laravel 12 |
| **Admin Panel** | Filament v5 |
| **Frontend** | Blade + Livewire 4, Tailwind CSS v4, Vite |
| **Database** | MySQL/MariaDB |
| **Modular Architecture** | nwidart/laravel-modules (Laraxot) |
| **Testing** | Pest PHP |
| **Static Analysis** | PHPStan Level 10, Larastan |
| **Code Style** | Laravel Pint (PSR-12) |

## Struttura Progetto

```
/var/www/_bases/base_fixcity_fila5/
├── laravel/                    # App Laravel principale
│   ├── Modules/                # Moduli nwidart
│   │   ├── Xot/               # Core framework Laraxot
│   │   ├── Cms/               # Content Management
│   │   ├── Tenant/            # Multi-tenancy
│   │   ├── UI/                # UI components
│   │   ├── Lang/              # Traduzioni
│   │   ├── Chart/             # Grafici
│   │   ├── Predict/           # Prediction market
│   │   └── ...
│   ├── Themes/
│   │   └── Sixteen/           # Tema attivo
│   └── config/
│       └── local/fixcity/xra.php  # Config tema
├── public_html/               # Document root (NON public/)
├── _bmad/                     # BMAD Method config & agents
├── _bmad-output/              # Artifacts BMAD
├── docs/                      # Documentazione progetto
└── .windsurf/                 # IDE config + skills
```

## Regole Architetturali Critiche

### XotBase Classes (OBBLIGATORIO)
- **MAI** estendere classi base Laravel/Filament direttamente
- **SEMPRE** usare `XotBaseResource`, `XotBaseListRecords`, `XotBaseMigration`, etc.

### Actions over Services
- **MAI** creare classi Service
- **SEMPRE** usare Spatie QueueableAction con metodo `handle()`

### Filament Resources
- Usare `getFormSchema()`, MAI `form()`
- NON definire `table()` nelle Resource
- NON usare `->label()` (gestito da LangServiceProvider)
- `getHeaderActions()` DEVE restituire array con chiavi stringa

### Traduzioni
- Pattern a 5 livelli: `namespace::context.collection.element.type`
- MAI hardcodare stringhe nell'UI

### Migrazioni
- Forward-only: MAI `drop`, `dropColumn`, `rollback`
- Usare `XotBaseMigration`

### DRY Principle
- Metodi dei trait implementati UNA SOLA VOLTA nel trait
- Cross-reference nei docs, MAI duplicare contenuti

## Configurazione Tema

```php
// laravel/config/local/fixcity/xra.php
'pub_theme' => 'Sixteen'
```

**Algoritmo di rilevamento tema:**
1. Legge `APP_URL` da `.env` → `http://fixcity.local`
2. Estrae dominio → `fixcity.local`
3. Explode e reverse → `["local", "fixcity"]`
4. Build config path → `config/local/fixcity/xra.php`
5. Legge `pub_theme` → `Sixteen`

## Quality Gates

- PHPStan Level 10 su ogni modulo
- Laravel Pint prima di ogni commit
- Pest tests per ogni feature
- Documentazione aggiornata per ogni modifica

## Convenzioni Naming

- **Moduli:** PascalCase (`Xot`, `Cms`, `Predict`)
- **Workspace files:** `_<snake_case>.code-workspace`
- **Traduzioni:** `namespace::context.collection.element.type`
- **Actions:** `App\Modules\{Module}\Actions\{Name}Action`

## IDE & Strumenti AI

| Tool | Scopo |
|------|-------|
| **Windsurf** | IDE principale con skills BMAD |
| **BMAD Method v6.2.2** | Agile AI-Driven Development |
| **OpenViking** | Contesto persistente cross-sessione |
| **GSD** | Phase execution tracking |

---

*Generato: 2026-04-07*  
*Versione BMAD: 6.2.2*  
*Moduli BMAD: core, bmm, cis, gds, tea, wds*
