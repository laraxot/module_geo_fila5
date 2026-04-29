# 🎯 DESIGN COMUNI REPLICATION STRATEGY

**Data**: 2026-03-31  
**Status**: ✅ **STRATEGY DEFINED**  
**Priority**: MAXIMUM

---

## 🎯 GOAL

Replicate Design Comuni template using **Tailwind CSS @apply**, **NOT Bootstrap Italia CSS**.

---

## ✅ CORRECT APPROACH

### What We Do ✅

1. **Use Tailwind CSS 4.x** as the only CSS framework
2. **Replicate Bootstrap Italia classes** via Tailwind @apply
3. **Use exact HTML structure** from Design Comuni
4. **Apply styles** via Tailwind @apply in CSS files

### What We DON'T Do ❌

1. ❌ Import Bootstrap Italia CSS
2. ❌ Use Bootstrap Italia CDN
3. ❌ Mix Bootstrap + Tailwind
4. ❌ Use Tailwind utility classes in HTML (use Bootstrap Italia class names)

---

## 📋 ARCHITECTURE

### HTML Structure (Bootstrap Italia Classes)

```html
<body>
  <div class="skiplink">
    <a href="#main-container">Vai ai contenuti</a>
  </div>

  <header class="it-header-wrapper">
    <div class="it-header-slim-wrapper">
    <div class="it-header-center-wrapper">
    <div class="it-header-navbar-wrapper">
  </header>

  <main id="main-container">
    <section class="hero-section">
    <section class="card-wrapper">
  </main>

  <footer class="it-footer">
    <div class="it-footer-main">
    <div class="it-footer-bottom">
  </footer>
</body>
```

**Note**: HTML uses **Bootstrap Italia class names** (`.it-header-wrapper`, `.hero-section`, etc.)

### CSS Styling (Tailwind @apply)

**File**: `Themes/Sixteen/Main_files/five/src/style-apply.css`

```css
/* Bootstrap Italia classes replicated with Tailwind @apply */

.it-header-wrapper {
  background-color: var(--bs-primary);
  @apply text-white relative;
}

.it-header-slim-wrapper {
  background-color: var(--bs-primary-dark);
  @apply py-2 text-sm;
}

.hero-section {
  @apply py-8;
}

.card-wrapper {
  @apply py-8;
}

.it-footer {
  @apply text-white;
}

.it-footer-main {
  @apply py-12;
}
```

**Note**: CSS uses **Tailwind @apply** to style Bootstrap Italia class names

---

## 🔧 HOW IT WORKS

### Flow

```
1. HTML: <header class="it-header-wrapper">
              ↓
2. CSS: .it-header-wrapper {
          @apply text-white relative;
          background-color: var(--bs-primary);
        }
              ↓
3. Tailwind: Compiles @apply to actual CSS
              ↓
4. Output: .it-header-wrapper {
             color: white;
             position: relative;
             background-color: #007a52;
           }
```

### Key Files

| File | Purpose |
|------|---------|
| `layouts/app.blade.php` | HTML structure with Bootstrap Italia classes |
| `components/sections/header/v1.blade.php` | Header HTML structure |
| `components/sections/footer/v1.blade.php` | Footer HTML structure |
| `Main_files/five/src/style-apply.css` | 1740 righe di Tailwind @apply |
| `resources/css/app.css` | Main CSS file (imports @apply files) |

---

## 📊 COMPARISON

### Wrong Approach ❌

```html
<!-- DON'T use Tailwind utility classes in HTML -->
<header class="bg-green-700 text-white relative">
  <div class="py-2 text-sm">
```

```css
/* DON'T import Bootstrap Italia CSS */
@import "bootstrap-italia.min.css";
```

### Correct Approach ✅

```html
<!-- USE Bootstrap Italia class names in HTML -->
<header class="it-header-wrapper">
  <div class="it-header-slim-wrapper">
```

```css
/* USE Tailwind @apply to style classes */
.it-header-wrapper {
  background-color: var(--bs-primary);
  @apply text-white relative;
}

.it-header-slim-wrapper {
  background-color: var(--bs-primary-dark);
  @apply py-2 text-sm;
}
```

---

## 🧘 MANTRAS

> *"Bootstrap Italia class names in HTML."*

> *"Tailwind @apply in CSS."*

> *"NO Bootstrap Italia CSS imports."*

> *"NO Tailwind utility classes in HTML."*

---

## 📖 REFERENCES

### Internal
- `.planning/TAILWIND_APPLY_ARCHITECTURE.md` - Architecture docs
- `.planning/CSS_ARCHITECTURE_VERIFIED.md` - Verified approach
- `Main_files/five/src/style-apply.css` - 1740 righe di @apply

### External
- [Tailwind CSS @apply](https://tailwindcss.com/docs/reusing-styles#extracting-classes-with-apply)
- [Design Comuni](https://italia.github.io/design-comuni-pagine-statiche/)

---

**Status**: ✅ **STRATEGY DEFINED**  
**Next**: Continue replicating Design Comuni with Tailwind @apply!
