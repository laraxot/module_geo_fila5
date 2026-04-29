# 🎨 BOOTSTRAP ITALIA + TAILWIND @apply - ARCHITETTURA CORRETTA

**Data**: 2026-03-31  
**Status**: ✅ **CORRETTA**  
**Priority**: CRITICAL

---

## 🎯 ARCHITETTURA

### Come Funziona

```
HTML: <div class="it-header-wrapper">
            ↓
CSS:  .it-header-wrapper {
        @apply text-white relative;
        background-color: var(--bs-primary);
      }
            ↓
Output: Tailwind compila le classi
```

### File Chiave

**Location**: `Themes/Sixteen/Main_files/five/src/style-apply.css`

**Contenuto**: 1740 righe di classi Bootstrap Italia convertite a Tailwind @apply

---

## 📋 CLASSI BOOTSTRAP ITALIA (Già definite)

### Header (Già in style-apply.css)

```css
/* Line 71 */
.it-header-wrapper {
  background-color: var(--bs-primary);
  @apply text-white relative;
}

/* Line 75 */
.it-header-slim-wrapper {
  background-color: var(--bs-primary-dark);
  @apply py-2 text-sm;
}

/* Line 79 */
.it-header-slim-wrapper-content {
  @apply flex justify-between items-center;
}
```

### Grid System (Già definito)

```css
/* Line 33 */
.row {
  @apply flex flex-wrap;
}

/* Line 37 */
.d-flex {
  @apply flex;
}
```

### Container (Già definito)

```css
/* Line 370 */
.container {
  @apply w-full px-3 mx-auto;
  max-width: 1200px;
}
```

### Columns (Già definite)

```css
/* Line 382 */
.col-12 {
  @apply flex-none w-full max-w-full px-3;
}

/* Line 422 */
@media (min-width: 992px) {
  .col-lg-3 {
    @apply flex-none w-1/4;
    max-width: 25%;
  }
}
```

---

## 🔧 COSA FARE

### 1. Usare Classi Bootstrap Italia nel HTML

**NEI COMPONENTI BLADE**:

```blade
{{-- CORRETTO: Usa classi Bootstrap Italia --}}
<div class="it-header-wrapper">
  <div class="it-header-slim-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-12">
```

**NON usare classi Tailwind dirette**:
```blade
{{-- SBAGLIATO --}}
<div class="bg-green-700 text-white">
  <div class="py-2 text-sm">
```

### 2. Lo Styling è Gestito da style-apply.css

Le classi Bootstrap Italia sono GIA' definite con @apply in `style-apply.css`.

**NON ridefinire**:
```blade
{{-- SBAGLIATO: Ridefinire classi --}}
<style>
.it-header-wrapper {
  background-color: #007a52;
}
</style>
```

---

## 📋 COMPONENTI DA AGGIORNARE

### Header Component

**File**: `components/sections/header/v1.blade.php`

**Deve usare**:
```blade
<div class="it-header-wrapper" data-bs-target="#header-nav-wrapper">
  <div class="it-header-slim-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="it-header-slim-wrapper-content">
```

### Hero Component

**File**: `components/blocks/hero/homepage.blade.php`

**Deve usare**:
```blade
<section class="hero-section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="cmp-hero">
```

### Cards Component

**File**: `components/blocks/governance/cards.blade.php`

**Deve usare**:
```blade
<section class="card-wrapper">
  <div class="container">
    <div class="row g-4">
      <div class="col-12 col-md-4">
        <div class="card card-bg shadow-sm">
          <div class="card-body">
```

---

## 🧘 DEVELOPER MANTRAS

> *"Classi Bootstrap Italia nel HTML."*

> *"Tailwind @apply nel CSS."*

> *"style-apply.css gestisce TUTTO."*

> *"NON ridefinire. NON usare Tailwind diretto."*

---

## 📖 REFERENCES

### Internal
- `Themes/Sixteen/Main_files/five/src/style-apply.css` - 1740 righe di classi
- `.planning/BOOTSTRAP_ITALIA_CLASSES.md` - Classi documentate

### External
- [Design Comuni](https://italia.github.io/design-comuni-pagine-statiche/)
- [Bootstrap Italia](https://italia.github.io/bootstrap-italia/)

---

**Status**: ✅ **ARCHITETTURA CHIARA**  
**Next**: Aggiornare componenti con classi Bootstrap Italia!
