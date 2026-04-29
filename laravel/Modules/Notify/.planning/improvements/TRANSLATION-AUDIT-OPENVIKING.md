# Translation Audit Summary - FixCity Platform

**Date:** 2026-03-30  
**Priority:** P0.3 (High)  
**Status:** Audit Complete, Migration Pending

---

## Quick Reference

**Platform:** FixCity Urban Issue Management  
**Base URL:** http://fixcity.local/it  
**Total Modules:** 18  
**Translation Files:** 612 (497 legacy + 115 standard)

---

## Critical Findings

### 1. Structure Inconsistency
- ✅ 9 modules use standard `resources/lang/it/`
- ❌ 17 modules use legacy `lang/it/`
- ❌ 9 modules missing `resources/lang/it/` entirely
- ⚠️ Multiple modules have BOTH structures (duplication risk)

### 2. Priority Modules

**Critical (P0):**
- **Fixcity** - Core application, 21 files in legacy `lang/it/`
- **User** - Authentication, 98 files legacy + 16 standard (inconsistent)

**High (P1):**
- **Seo** - NO TRANSLATIONS FOUND (create from scratch)
- **AI, Comment, Geo, Media, Rating, Tenant, UI** - Legacy only

**Medium (P2):**
- **Activity, Blog, Cms, Gdpr, Job, Lang, Notify, Xot** - Dual structure

### 3. Quality Issues

**Placeholder Strings Found:**
```
User/lang/it/login.php:
- 'label' => 'Missing Navigation Label'
- 'group' => 'Missing Group'
- 'plural_label' => 'Missing Plural label'
```

**Hardcoded English in Blade:**
```
Fixcity/resources/views/index.blade.php:4: <h1>Hello World</h1>
Fixcity/resources/views/pages/prova.blade.php:60: <x-ui.button>Sign in</x-ui.button>
```

---

## Migration Plan

### Phase 1: Standardization (Week 1)
1. Migrate Fixcity: `lang/it/` → `resources/lang/it/`
2. Migrate User: `lang/it/` → `resources/lang/it/`
3. Create Seo translations from scratch
4. Remove legacy directories after migration

### Phase 2: Quality Improvement (Week 2)
1. Extract hardcoded strings from Blade
2. Replace with translation keys
3. Fix placeholder strings
4. Review translation quality

### Phase 3: Automation (Week 3)
1. Run extraction script: `bash bashscripts/translations/extract-english-strings.sh ALL`
2. Set up missing key detection
3. Add translation validation tests

---

## Key Documents

| Document | Location | Purpose |
|----------|----------|---------|
| **Audit Report** | `.planning/improvements/P0.3-translation-audit.md` | Complete analysis |
| **Extraction Script** | `bashscripts/translations/extract-english-strings.sh` | Find hardcoded strings |
| **Script Docs** | `bashscripts/docs/translations/extract-english-strings.md` | How to use script |
| **Module TODOs** | `.planning/improvements/translations/*-translation-todo.md` | Per-module action items |

---

## Commands

```bash
# Run full extraction
bash bashscripts/translations/extract-english-strings.sh ALL

# Run single module
bash bashscripts/translations/extract-english-strings.sh Fixcity

# View results
cat .planning/improvements/translations/EXTRACTION-SUMMARY.md
cat .planning/improvements/translations/Fixcity-translation-todo.md
```

---

## Success Metrics

- [ ] All modules use `resources/lang/it/` structure
- [ ] Zero placeholder strings ("Missing", "TODO", "FIXME")
- [ ] Zero hardcoded English in Blade templates
- [ ] 100% translation key coverage
- [ ] All tests pass with Italian locale

---

## Related Context

- **Laraxot Standard:** `Modules/*/resources/lang/it/`
- **Legacy Pattern:** `Modules/*/lang/it/` (to be removed)
- **Total Files:** 612 translation files across 18 modules
- **Estimated Effort:** 2-3 weeks for full migration

---

## Next Actions

1. ✅ Audit complete
2. ⏳ Run extraction script
3. ⏳ Review hardcoded strings
4. ⏳ Create migration plan for Fixcity module
5. ⏳ Update OpenViking with progress

---

*Last updated: 2026-03-30*  
*Owner: Translation Team*  
*Priority: P0.3*
