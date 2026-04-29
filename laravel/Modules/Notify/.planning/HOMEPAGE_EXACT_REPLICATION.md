# 🏠 HOMEPAGE - EXACT HTML REPLICATION PLAN

**Data**: 2026-03-31  
**Status**: 🟡 IN PROGRESS  
**Priority**: CRITICAL

---

## 🎯 GOAL

Replicate EXACT HTML from Design Comuni homepage.

**Reference**: 1346 righe di HTML Bootstrap Italia

---

## 📊 GAP ANALYSIS

### Current Status

| Section | Our Classes | Design Comuni | Match |
|---------|-------------|---------------|-------|
| Header | ❌ Custom | `.it-header-wrapper` | ❌ |
| Hero | ❌ Custom | `.cmp-hero` | ❌ |
| Cards | ⚠️ Partial | `.card.card-bg` | ⚠️ |
| Events | ❌ Custom | `.it-calendar-wrapper` | ❌ |
| Topics | ❌ Custom | `.topic-list-wrapper` | ❌ |
| Footer | ⚠️ Partial | `.it-footer` | ⚠️ |

**Overall**: 0% exact match

---

## 🔧 REQUIRED CHANGES

### 1. Header Component

**Must use**:
```html
<div class="it-header-wrapper" data-bs-target="#header-nav-wrapper">
  <div class="it-header-slim-wrapper">
  <div class="it-header-center-wrapper">
  <div class="it-header-navbar-wrapper">
```

### 2. Hero Component

**Must use**:
```html
<section class="hero-section">
  <div class="container">
    <div class="cmp-hero">
```

### 3. Governance Cards

**Must use**:
```html
<section class="card-wrapper">
  <div class="container">
    <div class="row g-4">
      <div class="col-12 col-md-4">
        <div class="card card-bg shadow-sm">
```

### 4. Events Calendar

**Must use**:
```html
<section class="it-calendar-wrapper">
  <div class="it-calendar">
```

### 5. Topics Grid

**Must use**:
```html
<section class="topic-list-wrapper">
  <div class="topic-card">
```

### 6. Footer

**Must use**:
```html
<footer class="it-footer" role="contentinfo">
  <div class="it-footer-main">
  <div class="it-footer-bottom">
```

---

## 📋 ACTION PLAN

### Phase 1: Header (CRITICAL)
- [ ] Update `bootstrap-italia.header` component
- [ ] Use EXACT Bootstrap Italia classes
- [ ] Add all data/ARIA attributes

### Phase 2: Main Content
- [ ] Update `hero.homepage`
- [ ] Update `governance.cards`
- [ ] Update `events.calendar`
- [ ] Update `topics.highlight`
- [ ] Update `thematic.sites`

### Phase 3: Footer
- [ ] Update `footer-comune`
- [ ] Use EXACT classes

### Phase 4: Validation
- [ ] Compare HTML source
- [ ] Validate with W3C
- [ ] Test accessibility

---

## 🧘 DEVELOPER MANTRAS

> *"EXACT HTML. Non simile. IDENTICO."*

> *"Bootstrap Italia classes. Sempre."*

> *"Data attributes. ARIA attributes. Tutti."*

---

**Status**: 🟡 ANALYSIS COMPLETE  
**Next**: Update ALL components with exact classes!
