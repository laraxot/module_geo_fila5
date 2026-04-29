# Technical Context

**Date**: 2026-04-09  
**Stack**: Laravel 12 + PHP 8.3 + Filament 3 + Livewire 3 + TailwindCSS 4

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 12.24.0
- **PHP**: 8.3.20
- **Database**: SQLite (development)
- **Modules**: Nwidart + Laraxot (22 moduli attivi)
- **Quality**: PHPStan Level 10, Pint, Pest

### Frontend
- **Routing**: Laravel Folio (file-based)
- **Components**: Livewire Volt (class-based)
- **CSS**: TailwindCSS v4 + @apply
- **JS**: Alpine.js
- **Theme**: Sixteen (Bootstrap Italia replica)
- **Fonts**: Titillium Web (Google Fonts)

### AI/Agent Tools
- **MCP Servers**: 9 configurati
- **Memory**: Knowledge Graph + Memory Bank
- **Context**: Context7 per code docs
- **Workflow**: BMAD + GSD + Ralph Loop
- **Execution discipline**: docs-first, DRY/KISS, parallel-agent-safe updates

## 📁 Directory Structure

```
base_fixcity_fila5/
├── laravel/
│   ├── Modules/          → Nwidart modules (22 attivi)
│   ├── Themes/Sixteen/   → Active theme
│   ├── .mcp.json         → MCP servers config
│   └── database/database.sqlite
├── .memory-bank/         → Persistent project memory
├── bashscripts/          → Utility scripts
├── docs/                 → Project documentation
└── .planning/            → GSD planning artifacts
```

## 🔧 Build Commands

### Theme Assets
```bash
cd laravel/Themes/Sixteen
npm run build    # Compila Tailwind + Vite
npm run copy     # Copia a public_html/themes/Sixteen/
```

### Quality Gates
```bash
vendor/bin/pint --dirty           # Code formatting
php artisan test --filter=...     # Pest tests
phpstan analyse Modules/*/app     # Static analysis
```

## 📊 Performance Metrics

- **HTML Parity**: 99-100% su 7 pagine Design Comuni
- **Font Match**: 0-1/30 combinations (DA MIGLIORARE)
- **Docs**: 7,300+ files
- **Tests**: Pest PHP (coverage target 100%)

## 🚨 Constraints

1. **NO Bootstrap CSS/JS**: Solo TailwindCSS + Alpine.js
2. **Mantieni classi Bootstrap**: Per HTML parity nel markup
3. **Font esatti**: Titillium Web senza fallback nel computed style
4. **Forward-only Git**: NEVER reset/revert, always improve
5. **DRY + KISS**: NO duplicati docs, link cross-reference
