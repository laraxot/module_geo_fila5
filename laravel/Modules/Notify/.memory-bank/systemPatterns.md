# System Patterns

**Date**: 2026-04-09  
**Architecture**: Modular Monolith + Theme System

## 🏗️ Architectural Patterns

### 1. Modular Monolith (Nwidart + Laraxot)
```
Modules/
├── module.json           → Module definition
├── app/
│   ├── Models/          → Extend XotBaseModel
│   ├── Actions/         → Business logic (NO Services)
│   ├── Providers/       → Extend XotBaseServiceProvider
│   └── Filament/        → Admin panel resources
├── resources/
│   └── views/pages/     → Folio pages (se necessario)
└── routes/              → EMPTY (Filio routing)
```

**Regole**:
- ✅ Estendere SEMPRE classi XotBase*
- ✅ Usare Actions (spatie/laravel-queueable-action)
- ❌ MAI creare Services
- ❌ MAI modificare routes/ (vuoti di proposito)

### 2. Theme System
```
Themes/Sixteen/
├── resources/
│   ├── css/app.css      → Tailwind entry point
│   ├── views/pages/     → Folio pages
│   └── dist/            → Compiled assets
├── tailwind.config.js
└── vite.config.js
```

**Build Process**:
1. Modifica CSS/JS in `Themes/Sixteen/resources/`
2. `npm run build` → Compila in `resources/dist/`
3. `npm run copy` → Copia a `public_html/themes/Sixteen/`

### 3. Routing Pattern (NO traditional routes)
- **Frontoffice**: Folio file-based routing
- **Backoffice**: Filament admin panels
- **routes/web.php**: EMPTY (di proposito)
- **routes/api.php**: EMPTY o NON esiste

### 4. Multilingual Runtime Pattern
- User-facing copy belongs in `Modules/<Module>/lang/<locale>/...`
- PHP runtime must not hardcode natural-language UI strings
- Route names stay stable and English-neutral; content slugs belong in CMS/config, not in widget/controller literals
- For localized redirects prefer route names plus localization helpers over manual string concatenation
- Translation keys follow `namespace::context.collection.element.type`
- The final segment must stay atomic (`label`, `description`, `text`, `title`, `body`), never merged forms like `empty_message`

### 5. Filament Create Wizard Pattern
- Simple create wizards should use field names aligned with the Eloquent model
- UX-only fields should be `dehydrated(false)` instead of being pruned in submit handlers
- Relationship-backed uploads should be persisted with Filament relationship saving after `create($data)`
- Submit handlers should stay short and avoid ad hoc payload layers when no real domain transformation is needed

### 6. Async Interaction Feedback Pattern
- Any user-triggered browser async action must acknowledge the click immediately
- Busy feedback belongs in the component that owns the async behavior
- Busy state must cover the full chain, not just the first async hop
- Disable duplicate activation while work is in progress
- Runtime status copy must use translations, not hardcoded natural language

### 7. Wizard Review Semantics Pattern
- Wizard data-entry steps use form fields
- Wizard final review steps should prefer Infolist entries for structured read-only data
- `Placeholder` is acceptable for accessory copy, not as the primary carrier of review data
- If review data comes from unsaved wizard state, use entry `state()`/`Get` rather than fake form fields

### 8. Frontoffice Wizard Runtime Safety Pattern
- A create wizard frontoffice must keep a minimal render path: short mount, short init, no unnecessary pre-submit model binding
- Semantic improvements are subordinate to runtime stability
- Components used in a pre-submit summary must be safe on unsaved state
- `php -l` is not a sufficient gate; require a real HTTP smoke check on the page after widget changes
- When a widget mixes Forms, Schemas, and Infolists, component namespaces must stay explicit and unambiguous

### 9. Placeholder Migration Pattern
- `Filament\Forms\Components\Placeholder` should not be the default choice in Filament 5 work
- Structured read-only data should migrate to `Infolists`
- Static/editorial/legal notice content should migrate to `Schemas` prime components such as `Text`
- Choose by semantic role, not by blanket replacement

### 10. Docs-First + Parallel-Agent Hygiene
- Before editing code, inspect and update the canonical docs/memory/rules that govern that area
- Reuse existing indexes and canonical docs roots before adding new files
- Prefer extending an existing rule/memory file over creating another near-duplicate document
- Assume parallel agents may be touching the same area: keep changes local, explicit, and easy to merge
- When a process rule becomes stable, store it in memory/docs so it survives the session

### 11. PHP 8.1+ Enum Anti-Pattern
- **Never call `->reduce()` on `Enum::cases()`** - it returns a PHP array, not a Laravel Collection
- **Never call `->mapWithKeys()` on `Enum::cases()`** - same array limitation
- **For Filament Select options, use the enum class directly**: `Select::make('field')->options(YourEnum::class)`
- **Only use `collect(YourEnum::cases())`** when you specifically need Collection methods
- **This pattern is enforced** by Filament's `HasOptions` contract when enums implement `HasLabel`

### 11. HTML + Visual Parity Evidence Pattern
- Do not declare high parity from code inspection alone
- Collect at least one local screenshot and one reference screenshot for page-level parity work
- Evaluate parity at whole-page level: header, side columns, content width, spacing rhythm, and call-to-action order
- Wizard parity is not complete if only the inner card matches while surrounding layout remains visibly off

## 🎨 CSS/JS Patterns

### Bootstrap Italia → Tailwind Mapping
```css
/* style-apply.css: Bootstrap classes → Tailwind @apply */
.btn-primary {
  @apply bg-primary-500 text-white px-4 py-2 rounded;
}
```

**Regole**:
1. Mantieni classi Bootstrap nell'HTML (per parity)
2. Stili con Tailwind @apply in CSS
3. Interattività con Alpine.js (NO data-bs-*)

### Font Configuration
```css
/* Google Fonts - MUST be first @import */
@import url('https://fonts.googleapis.com/css2?family=Titillium+Web:...');

/* Computed style target */
font-family: "Titillium Web"; /* NO fallbacks per match esatto */
```

## 🧠 Memory Patterns

### Knowledge Graph Memory
- **Entity**: Concetto con nome unico
- **Observation**: Fatto atomico su entity
- **Relation**: Connessione attiva tra entities

### Memory Bank
- **activeContext.md**: Sessione corrente
- **productContext.md**: Descrizione progetto
- **techContext.md**: Stack tecnico
- **systemPatterns.md**: Pattern architetturali (questo file)
- **progress.md**: Avanzamento e decisioni

## 🔧 Development Workflow

### 1. Feature Development
```
Discuss → Plan → Execute → Verify → Document
```

### 2. CSS/JS Improvements
```
Screenshot → Compare → Modify CSS → Build → Screenshot → Repeat
```

### 3. Documentation Updates
```
Change code → Update module docs → Update theme docs → Update indexes
```

## 🗂️ Documentation Governance Memory

### Canonical documentation path
- Project rules live in `docs/`
- Module rules live in `laravel/Modules/<Module>/docs/`
- Theme rules live in `laravel/Themes/<Theme>/docs/`
- Script docs live in `bashscripts/docs/`

### Retrieval order
1. `AGENTS.md`
2. `docs/README.md`
3. `docs/project/docs-governance.md`
4. `laravel/Modules/docs/README.md` or `laravel/Themes/docs/README.md`
5. target `docs/README.md`
6. topic file

### Anti-noise heuristics
- Prefer one canonical `README.md` per active docs root
- Avoid new `INDEX.md` or `00-INDEX.md` duplicates
- Treat `app/docs`, `resources/views/docs`, and `docs/docs` as anomalies to audit
- Prefer linking to a source of truth over copying explanations

## ⚡ Quality Gates

| Gate | Tool | Target |
|------|------|--------|
| Formatting | Laravel Pint | PSR-12 |
| Static Analysis | PHPStan | Level 10 |
| Tests | Pest PHP | 100% coverage |
| HTML Parity | compare-html.py | >80% |
| Font Match | Computed style | 100% match |
