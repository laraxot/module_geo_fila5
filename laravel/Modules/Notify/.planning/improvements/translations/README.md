# Translation Extraction Output

**Directory:** `.planning/improvements/translations/`  
**Generated:** 2026-03-30  
**Script:** `bashscripts/translations/extract-english-strings.sh`

---

## Purpose

This directory contains automated analysis of Italian translations across all FixCity modules.

## Files Generated

For each of the 18 modules, the script creates 5 files:

### 1. `${module}-blade-strings.txt`
Hardcoded strings found in Blade templates.

**Example:**
```txt
# Hardcoded Strings in Blade Templates - Fixcity
/resources/views/index.blade.php:4:<h1>Hello World</h1>
/resources/views/pages/prova.blade.php:60:<x-ui.button>Sign in</x-ui.button>
```

### 2. `${module}-translation-calls.txt`
Existing `__()` and `@lang()` function calls.

**Example:**
```txt
# Translation Function Calls - Fixcity
/resources/views/tickets/show.blade.php:110:@lang('global.submit')
```

### 3. `${module}-missing-keys.txt`
Translation keys used in code but missing from files.

**Example:**
```txt
# Missing Translation Keys - Fixcity
MISSING FILE: navigation.php (used in: navigation.label)
MISSING KEY: tickets.create.submit
```

### 4. `${module}-placeholders.txt`
Placeholder strings that need real Italian translations.

**Example:**
```txt
# Placeholder Strings - User
/lang/it/login.php:15:'label' => 'Missing Label'
```

### 5. `${module}-translation-todo.md`
Actionable TODO checklist for the module.

**Example:**
```markdown
# Translation TODO - Fixcity Module

## Tasks
- [ ] Migrate `lang/it/` → `resources/lang/it/`
- [ ] Review extracted Blade strings
- [ ] Add translation keys for hardcoded strings
```

---

## Summary Report

**File:** `EXTRACTION-SUMMARY.md`

Contains:
- Overview of all modules
- Priority order for fixes
- Links to related documents
- Next steps

---

## How to Use

### Step 1: Run Extraction
```bash
bash bashscripts/translations/extract-english-strings.sh ALL
```

### Step 2: Review Summary
```bash
cat .planning/improvements/translations/EXTRACTION-SUMMARY.md
```

### Step 3: Pick a Module
Start with critical priority:
1. Fixcity
2. User
3. Seo

### Step 4: Follow TODO
```bash
cat .planning/improvements/translations/Fixcity-translation-todo.md
```

### Step 5: Fix Issues
1. Review blade-strings.txt
2. Create translation keys
3. Update Blade templates
4. Test in browser

### Step 6: Re-run Script
Verify fixes:
```bash
bash bashscripts/translations/extract-english-strings.sh Fixcity
```

---

## File Lifecycle

1. **Generated:** By extraction script
2. **Used:** By translation team for fixes
3. **Archived:** After all TODOs complete
4. **Regenerated:** When new strings added

---

## Related Documents

- [Translation Audit Report](../P0.3-translation-audit.md) - Complete analysis
- [Extraction Script Docs](../../bashscripts/docs/translations/extract-english-strings.md) - How to use
- [OpenViking Summary](../TRANSLATION-AUDIT-OPENVIKING.md) - Quick reference

---

## Module List

| Module | Files Generated | Priority |
|--------|----------------|----------|
| AI | 5 | High |
| Activity | 5 | Medium |
| Blog | 5 | Medium |
| Cms | 5 | High |
| Comment | 5 | High |
| Fixcity | 5 | **Critical** |
| Gdpr | 5 | Medium |
| Geo | 5 | High |
| Job | 5 | Medium |
| Lang | 5 | Low |
| Media | 5 | High |
| Notify | 5 | Medium |
| Rating | 5 | Medium |
| Seo | 5 | **Critical** |
| Tenant | 5 | Medium |
| UI | 5 | High |
| User | 5 | **Critical** |
| Xot | 5 | High |

**Total:** 90 files (18 modules × 5 files each) + 1 summary = **91 files**

---

*Directory created: 2026-03-30*  
*Maintained by: Translation Team*
