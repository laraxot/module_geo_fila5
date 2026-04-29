# 🎨 CSS ARCHITECTURE - TAILWIND @apply VERIFIED

**Data**: 2026-03-31  
**Status**: ✅ **ARCHITECTURE CORRECT**  
**Priority**: CONFIRMED

---

## ✅ VERIFIED: NO BOOTSTRAP ITALIA IMPORT

### Architecture (CORRECT)

**File**: `Themes/Sixteen/resources/css/app.css`

```css
/**
 * NO Bootstrap Italia imports - ALL via Tailwind @apply
 */

/* Fonts */
@import url('https://fonts.googleapis.com/css2?family=Titillium+Web...');

/* AGID Colors */
@import "./agid-colors.css";
@import "./agid-override.css";

/* Bootstrap Italia Classes (Tailwind @apply) */
@import "./components/bootstrap-italia-classes.css";

/* Design Comuni Components */
@import "./components/design-comuni.css";

/* Tailwind CSS 4.x */
@import "tailwindcss";
```

### CORRECT Architecture ✅

- ❌ NO `@import "bootstrap-italia.min.css"`
- ❌ NO `@import "https://cdn.jsdelivr.net/npm/bootstrap-italia..."`
- ✅ ALL classes replicated via Tailwind @apply
- ✅ 1740 righe in `style-apply.css`

---

## 📋 CSS FILES STRUCTURE

### Source Files

```
Themes/Sixteen/resources/css/
├── app.css                          # Main file
├── agid-colors.css                  # AGID color variables
├── agid-override.css                # AGID overrides
├── components/
│   ├── bootstrap-italia-classes.css # Bootstrap Italia → Tailwind @apply
│   └── design-comuni.css            # Design Comuni components
└── Main_files/five/src/
    └── style-apply.css              # 1740 righe di @apply
```

### Bootstrap Italia Classes File

**File**: `components/bootstrap-italia-classes.css`

```css
/**
 * Bootstrap Italia Classes - Replicated with Tailwind CSS
 * NO external imports - ALL via Tailwind @apply
 */

:root {
  --bs-italia: #0066B3;
  --bs-italia-dark: #003366;
  /* ... */
}

/* Header Classes */
.it-header-wrapper {
  @apply text-white relative;
  background-color: var(--bs-italia);
}

.it-header-slim-wrapper {
  @apply py-2 text-sm;
  background-color: var(--bs-italia-dark);
}

/* ... ALL classes via @apply */
```

---

## 🧘 MANTRAS

> *"Tailwind @apply. NO Bootstrap Italia imports."*

> *"ALL classes replicated. EXACT match."*

> *"style-apply.css: 1740 righe di @apply."*

---

## 📖 REFERENCES

### Internal
- `Themes/Sixteen/resources/css/app.css` - Main CSS file
- `Themes/Sixteen/Main_files/five/src/style-apply.css` - 1740 righe @apply
- `.planning/TAILWIND_APPLY_ARCHITECTURE.md` - Architecture docs

### External
- [Tailwind CSS 4.x](https://tailwindcss.com/docs)
- [Bootstrap Italia](https://italia.github.io/bootstrap-italia/)

---

**Status**: ✅ **ARCHITECTURE CORRECT**  
**Next**: Verify colors (#007a52), rebuild assets!
