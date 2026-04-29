# 🚨 HEADER CRITICAL FIX - LOGO, NAME, SLOGAN MISSING

**Data**: 2026-03-31  
**Status**: 🟡 CRITICAL FIX IN PROGRESS  
**Priority**: MAXIMUM

---

## 🎯 PROBLEMS FOUND

### Header Structure Comparison

| Element | Reference | Our Version | Status |
|---------|-----------|-------------|--------|
| **Top Bar** | `.it-header-slim-wrapper` | ✅ Present | ✅ OK |
| **Main Header** | `.it-header-center-wrapper` | ❌ MISSING | ❌ CRITICAL |
| **Brand/Logo** | `.it-brand-wrapper` | ❌ MISSING | ❌ CRITICAL |
| **Logo SVG** | `<svg width="82" height="82">` | ❌ MISSING | ❌ CRITICAL |
| **Municipality Name** | `.it-brand-title` | ❌ MISSING | ❌ CRITICAL |
| **Slogan** | `.it-brand-tagline` | ❌ MISSING | ❌ CRITICAL |
| **Navigation** | `.it-header-navbar-wrapper` | ❌ MISSING | ❌ CRITICAL |

---

## 🔧 CRITICAL FIXES REQUIRED

### 1. Add Missing Header Sections

**File**: `components/sections/header/v1.blade.php`

**Must add**:
```html
<!-- Level 2: Main Header with Logo -->
<div class="it-header-center-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="it-header-center-content-wrapper">
          <!-- Brand/Logo -->
          <div class="it-brand-wrapper">
            <a href="/" aria-label="Nome del Comune - Vai alla homepage">
              <svg width="82" height="82" class="icon" aria-hidden="true">
                <use href="/bootstrap-italia/dist/svg/sprites.svg#it-pa"></use>
              </svg>
              <div class="it-brand-text">
                <div class="it-brand-title">Il mio Comune</div>
                <div class="it-brand-tagline d-none d-md-block">Un comune da vivere</div>
              </div>
            </a>
          </div>
          
          <!-- Right Zone: Social + Search -->
          <div class="it-right-zone">
            <!-- Social Media -->
            <div class="it-socials d-none d-lg-flex">
              <!-- ... -->
            </div>
            
            <!-- Search Toggle -->
            <div class="it-search-wrapper">
              <!-- ... -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Level 3: Navigation Bar -->
<div class="it-header-navbar-wrapper">
  <!-- ... -->
</div>
```

### 2. CSS Colors

**File**: `Main_files/five/src/style-apply.css`

**Already correct**:
```css
.it-header-wrapper {
  background-color: var(--bs-primary); /* #007a52 */
  @apply text-white relative;
}

.it-header-slim-wrapper {
  background-color: var(--bs-primary-dark); /* #00614a */
  @apply py-2 text-sm;
}

.it-header-center-wrapper {
  background-color: var(--bs-primary);
  @apply py-4 text-white;
}

.it-brand-title {
  @apply text-2xl font-semibold text-white mb-0;
}

.it-brand-tagline {
  @apply text-sm text-white/90 mb-0;
}
```

---

## 📋 ACTION PLAN

### Phase 1: Fix Header Component ⚪
- [ ] Add `.it-header-center-wrapper`
- [ ] Add `.it-brand-wrapper` with logo
- [ ] Add `.it-brand-title` (Municipality name)
- [ ] Add `.it-brand-tagline` (Slogan)
- [ ] Add `.it-header-navbar-wrapper` (Navigation)

### Phase 2: Verify Colors ⚪
- [ ] Header: GREEN #007a52
- [ ] Top Bar: DARK GREEN #00614a
- [ ] Text: WHITE #FFFFFF

### Phase 3: Test ⚪
- [ ] Logo visible
- [ ] Name readable
- [ ] Slogan readable
- [ ] Colors match
- [ ] Spacing correct

---

## 🧘 MANTRAS

> *"Logo visible. Name readable. Slogan clear."*

> *"Bootstrap Italia structure. EXACT."*

> *"Colors: #007a52 (green), NOT #0066CC (blue)."*

---

**Status**: 🟡 CRITICAL FIX IN PROGRESS  
**Next**: Add missing header sections with logo, name, slogan!
