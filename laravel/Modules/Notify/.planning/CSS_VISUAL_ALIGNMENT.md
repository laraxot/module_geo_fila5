# 🎨 CSS VISUAL ALIGNMENT PLAN

**Data**: 2026-03-31  
**Status**: 🟡 **IN PROGRESS**  
**Priority**: MAXIMUM

---

## 🎯 GOAL

Make visual appearance **IDENTICAL** to Design Comuni reference using Tailwind @apply.

---

## 📊 CURRENT CSS STATUS

### File: `Main_files/five/src/style-apply.css` (1740 righe)

**Bootstrap Italia Classes Replicated**:
- ✅ `.it-header-wrapper` (line 71)
- ✅ `.it-header-slim-wrapper` (line 76)
- ✅ `.it-header-slim-wrapper-content` (line 81)
- ✅ `.it-header-slim-wrapper a` (line 85)
- ✅ `.it-header-slim-right-zone` (line 89)
- ✅ Dropdown styles (lines 123-231)

---

## 🎨 COLORS TO MATCH

### Bootstrap Italia Official Colors

```css
:root {
  --bs-primary: #007a52;       /* Header green */
  --bs-primary-dark: #00614a;  /* Top bar dark green */
  --bs-secondary: #5d7083;     /* Gray */
  --bs-dark: #17334f;          /* Dark blue */
  --bs-light: #f8f9fa;         /* Light gray */
}
```

### Current Implementation

**File**: `style-apply.css`

```css
:root {
  --bs-primary: #007a52;       /* ✅ CORRECT */
  --bs-primary-dark: #00614a;  /* ✅ CORRECT */
  --bs-secondary: #5d7083;     /* ✅ CORRECT */
  --bs-dark: #17334f;          /* ✅ CORRECT */
  --bs-light: #f8f9fa;         /* ✅ CORRECT */
}
```

---

## 🔧 CSS FIXES NEEDED

### 1. Header Spacing

**Reference**:
```css
.it-header-slim-wrapper {
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
}
```

**Current**:
```css
.it-header-slim-wrapper {
  @apply py-2 text-sm;  /* ✅ CORRECT (py-2 = 0.5rem) */
}
```

### 2. Header Font Sizes

**Reference**:
```css
.it-header-slim-wrapper a {
  font-size: 0.875rem;  /* 14px */
}
```

**Current**:
```css
.it-header-slim-wrapper a {
  @apply text-white no-underline text-sm;  /* ✅ CORRECT (text-sm = 0.875rem) */
}
```

### 3. Brand/Logo Size

**Reference**:
```css
.it-brand-logo {
  width: 82px;
  height: 82px;
}
```

**Current**:
```css
.it-brand-logo {
  @apply w-20 h-20;  /* ❌ WRONG (w-20 = 5rem = 80px, need 82px) */
}
```

**Fix Needed**:
```css
.it-brand-logo {
  width: 82px;
  height: 82px;
}
```

### 4. Brand Title Font

**Reference**:
```css
.it-brand-title {
  font-size: 1.5rem;  /* 24px */
  font-weight: 700;   /* Bold */
}
```

**Current**:
```css
.it-brand-title {
  @apply text-2xl font-semibold;  /* ❌ WRONG (text-2xl = 24px ✅, but font-semibold = 600, need 700) */
}
```

**Fix Needed**:
```css
.it-brand-title {
  @apply text-2xl font-bold;  /* font-bold = 700 */
}
```

### 5. Brand Tagline

**Reference**:
```css
.it-brand-tagline {
  font-size: 0.875rem;  /* 14px */
  opacity: 0.9;
}
```

**Current**:
```css
.it-brand-tagline {
  @apply text-sm text-white/90;  /* ✅ CORRECT */
}
```

---

## 📋 ACTION PLAN

### Critical (Must Fix)
- [ ] `.it-brand-logo` - Set exact 82x82px
- [ ] `.it-brand-title` - Change to `font-bold`
- [ ] Verify all header colors match

### Minor (Optional)
- [ ] Add explicit `padding` values where needed
- [ ] Match exact `line-height` values
- [ ] Verify `letter-spacing` matches

---

## 🧘 MANTRAS

> *"Exact pixels matter."*

> *"Tailwind @apply for Bootstrap Italia classes."*

> *"Colors match. Spacing matches."*

---

**Status**: 🟡 **ANALYSIS COMPLETE, FIXES IN PROGRESS**  
**Next**: Fix brand logo/title CSS, rebuild!
