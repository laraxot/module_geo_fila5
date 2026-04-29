# ✅ TAILWIND @apply ARCHITECTURE - CORRECT

**Data**: 2026-03-31  
**Status**: ✅ VERIFIED CORRECT  
**Priority**: CONFIRMED

---

## 🎯 ARCHITECTURE VERIFIED

### CSS Architecture (CORRECT)

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

### NO Bootstrap Italia Import ✅

**CORRECT**:
- ❌ NO `@import "bootstrap-italia.min.css"`
- ❌ NO `@import "https://cdn.jsdelivr.net/npm/bootstrap-italia..."`
- ✅ ALL classes replicated via Tailwind @apply

---

## 📋 FILE STRUCTURE

### Source Files

```
Themes/Sixteen/resources/css/
├── app.css                          # Main file
├── agid-colors.css                  # AGID color variables
├── agid-override.css                # AGID overrides
├── components/
│   ├── bootstrap-italia-classes.css # Bootstrap Italia → Tailwind
│   └── design-comuni.css            # Design Comuni components
└── Main_files/five/src/
    └── style-apply.css              # 1740 righe di @apply
```

### Compiled Files

```
public_html/themes/Sixteen/
├── assets/
│   └── app-*.css                    # Compiled CSS
└── manifest.json                    # Vite manifest
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
- `Themes/Sixteen/Main_files/five/src/style-apply.css` - Bootstrap Italia → Tailwind

### External
- [Tailwind CSS 4.x](https://tailwindcss.com/docs)
- [Bootstrap Italia](https://italia.github.io/bootstrap-italia/)

---

**Status**: ✅ **ARCHITECTURE CORRECT**  
**Next**: Verify colors (#007a52), rebuild assets!
