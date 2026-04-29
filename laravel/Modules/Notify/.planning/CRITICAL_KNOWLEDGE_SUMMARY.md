# 🧠 CRITICAL KNOWLEDGE UPDATE - SUMMARY

**Data**: 2026-03-30  
**Status**: ✅ COMPLETE  
**Priority**: MAXIMUM

---

## 🎯 KEY LEARNINGS

### 1. Theme Detection Algorithm

```
APP_URL (http://fixcity.local)
  ↓ Remove protocol, www
fixcity.local
  ↓ Reverse explode by "."
['local', 'fixcity']
  ↓ Build config path
config/local/fixcity/xra.php
  ↓ Read pub_theme
'Sixteen'
  ↓ Theme folder
laravel/Themes/Sixteen/
```

**Documentation**: `.planning/PROJECT_KNOWLEDGE_BASE.md`

---

### 2. Composer Architecture

**CRITICAL**: Themes NOT in merge-plugin

```json
{
    "merge-plugin": {
        "include": [
            "Modules/*/composer.json"  // ✅ ONLY modules
        ]
    }
}
```

**Why**:
- Themes are **isolated**
- Themes have **own build process**
- Themes use **Vite independently**
- Modules **share** dependencies

**Documentation**: `.planning/PROJECT_KNOWLEDGE_BASE.md`

---

### 3. Block Naming Convention

**Pattern**: `pub_theme::components.blocks.<TYPE>.<VIEW>`

**Examples**:
```blade
✅ pub_theme::components.blocks.hero.homepage
✅ pub_theme::components.blocks.topics.grid

❌ pub_theme::components.blocks.tests.argomenti  <!-- WRONG! tests.argomenti is NOT a type -->
```

**Universal Types**: `hero`, `card`, `topics`, `features`, `cta`, `content`, `gallery`, `form`, `testimonial`, `pricing`, `faq`, `team`, `contact`, `footer`, `header`, `nav`

**Documentation**: `.planning/PROJECT_KNOWLEDGE_BASE.md`

---

### 4. Section System

```blade
{{-- Header --}}
<x-section slug="header" />

{{-- Footer --}}
<x-section slug="footer" />
<x-section slug="footer" tpl="slim" />
```

**NOT** direct component calls!

---

### 5. CMS-Driven Pages

**JSON Path**: `config/local/fixcity/database/content/pages/tests.argomenti.json`

**Structure**:
```json
{
    "slug": "tests.argomenti",
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {"view": "pub_theme::components.blocks.hero.argomenti"}
            },
            {
                "type": "topics",
                "data": {"view": "pub_theme::components.blocks.topics.grid"}
            }
        ]
    }
}
```

**NOT** `@includeIf('pub_theme::design-comuni.pages.'.$slug)`!

---

### 6. Folio + Volt Pattern

**[slug].blade.php**:
```php
name('tests.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public function mount(string $slug): void {
        $this->slug = $slug;
        $this->pageSlug = 'tests.'.$slug;
    }
};
```

**index.blade.php**:
```php
name('tests.index');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public function mount(): void {
        $this->pageSlug = 'tests.index';
    }
};
```

---

### 7. Icon System

```blade
{{-- Filament 5 way --}}
<x-filament::icon icon="heroicon-o-check-circle" class="w-5 h-5" />

{{-- NOT deprecated --}}
<x-icon name="check" />  <!-- ❌ WRONG -->
```

**Documentation**: `.openviking/filament-icon-convention.md`

---

### 8. Vite Build System

**Error**: `Vite manifest not found`

**Solution**:
```bash
cd laravel/Themes/<theme>
composer update -W
npm install
npm run build
npm run copy
```

**Files**:
- `Main_files/five/src/style-apply.css` - Bootstrap → Tailwind
- `Main_files/five/src/app1.js` - Alpine.js interactions

---

### 9. Documentation Rules

**Agnostic**:
```markdown
✅ Use `[PROJECT_NAME]`
❌ Use `FixCity`
```

**File Naming**:
```markdown
✅ `pages-content-blocks.md`
❌ `fixcity-pages-content-blocks.md`
```

---

### 10. Design Comuni Strategy

**DO**:
- ✅ Study HTML structure
- ✅ Replicate with Tailwind @apply
- ✅ Create reusable blocks
- ✅ Use CMS JSON
- ✅ Use `<x-section>`
- ✅ Use `<x-filament::icon>`
- ✅ Document (agnostic)

**DON'T**:
- ❌ Save raw HTML
- ❌ Use Bootstrap JS
- ❌ Create page-specific components
- ❌ Hardcode pages

---

## 📚 DOCUMENTATION CREATED

### 1. Project Knowledge
- `.planning/PROJECT_KNOWLEDGE_BASE.md` - Complete knowledge base
- `.openviking/critical-knowledge.md` - Critical knowledge summary

### 2. Work Plan
- `.planning/DESIGN_COMUNI_REPLICATION_PLAN.md` - Complete work plan
- GitHub Issues template created

### 3. Updated
- `.openviking/filament-icon-convention.md` - Icon convention (Filament 5)
- `.openviking/pages-structure-audit.md` - Pages audit
- `.openviking/blocks-structure-convention.md` - Blocks convention

---

## 🎯 NEXT ACTIONS

### Immediate (Today)
1. ✅ Review all documentation
2. ✅ Understand theme detection
3. ✅ Understand block convention
4. ✅ Understand CMS JSON system

### Short-term (This Week)
1. Create GitHub Issues for Design Comuni pages
2. Create GitHub Discussions for architecture
3. Start Phase 1 (Homepage, Argomenti, Appuntamento)
4. Create block catalog

### Long-term (This Month)
1. Complete all Phase 1 pages
2. Document all block types
3. Create screenshot comparison system
4. Achieve >95% visual match

---

## 🧘 DEVELOPER MANTRAS

> *"La vista segue il tipo, come l'ombra segue la forma."*

> *"Root composer.json minimale. Temi isolati. Moduli condivisi."*

> *"Blocchi universali, riutilizzabili, non specifici per pagina."*

> *"CMS-driven JSON, non hardcoded HTML."*

> *"Tailwind @apply, non Bootstrap."*

> *"Documentazione agnostica, no project-specific names."*

> *"Sempre Filament 5. Sempre <x-filament::icon>."*

> *"Git forward-only. Studiare il passato, migliorare il futuro."*

---

## 📖 REFERENCES

### Internal Documentation
- `.planning/PROJECT_KNOWLEDGE_BASE.md` - Complete knowledge
- `.planning/DESIGN_COMUNI_REPLICATION_PLAN.md` - Work plan
- `.openviking/critical-knowledge.md` - Critical summary

### External Resources
- [Design Comuni](https://italia.github.io/design-comuni-pagine-statiche/)
- [Filament 5](https://filamentphp.com/docs/5.x)
- [Flowbite Blocks](https://flowbite.com/blocks/)
- [Tailwind Plus UI](https://tailwindcss.com/plus/ui-blocks)

---

**Status**: ✅ KNOWLEDGE COMPLETE  
**Next**: Execute work plan, create GitHub issues
