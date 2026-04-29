# 🎨 BOOTSTRAP ITALIA COLORS - CORRECTION PLAN

**Data**: 2026-03-31  
**Status**: 🟡 IN PROGRESS  
**Priority**: CRITICAL

---

## 🎯 PROBLEM

Our theme uses WRONG colors:
- `--agid-primary: #0066CC` (Blue) ❌
- `--agid-primary-dark: #003d7a` (Dark Blue) ❌

Bootstrap Italia uses CORRECT colors:
- `--bs-primary: #007a52` (Green) ✅
- `--bs-primary-dark: #00614a` (Dark Green) ✅

---

## 📊 COLOR COMPARISON

### Header Colors

| Element | Reference (Bootstrap Italia) | Our Theme | Gap |
|---------|----------------------------|-----------|-----|
| Header Wrapper | `#007a52` (Green) | `#0066CC` (Blue) | ❌ |
| Top Bar | `#00614a` (Dark Green) | `#003d7a` (Dark Blue) | ❌ |
| Text Color | `#FFFFFF` (White) | `#FFFFFF` (White) | ✅ |

### Footer Colors

| Element | Reference | Our Theme | Gap |
|---------|-----------|-----------|-----|
| Footer Main | `#17334f` (Dark Blue) | Custom | ⚠️ |
| Footer Bottom | `#0f2338` (Darker) | Custom | ⚠️ |

---

## 🔧 REQUIRED FIXES

### 1. Update CSS Variables

**File**: `Themes/Sixteen/resources/css/app.css`

**Change**:
```css
/* BEFORE (WRONG) */
--agid-primary: #0066CC;
--agid-primary-light: #4da6ff;
--agid-primary-dark: #003d7a;

/* AFTER (CORRECT - Bootstrap Italia) */
--agid-primary: #007a52;
--agid-primary-light: #00a86b;
--agid-primary-dark: #00614a;
```

### 2. Update style-apply.css

**File**: `Themes/Sixteen/Main_files/five/src/style-apply.css`

Already correct with Bootstrap Italia colors:
```css
:root {
  --bs-primary: #007a52;
  --bs-primary-dark: #00614a;
  --bs-secondary: #5d7083;
  --bs-dark: #17334f;
}
```

### 3. Rebuild Assets

```bash
cd laravel/Themes/Sixteen
npm run build
npm run copy
```

---

## 📋 ACTION PLAN

### Phase 1: Fix Colors ⚪
- [ ] Update app.css variables
- [ ] Verify style-apply.css
- [ ] Rebuild assets

### Phase 2: Verify Header ⚪
- [ ] Check header background color
- [ ] Check top bar color
- [ ] Verify text contrast

### Phase 3: Verify Footer ⚪
- [ ] Check footer main color
- [ ] Check footer bottom color
- [ ] Verify links color

---

## 🧘 MANTRAS

> *"Bootstrap Italia colors. EXACT match."*

> *"#007a52 for primary. NOT #0066CC."*

---

**Status**: 🟡 ANALYSIS COMPLETE  
**Next**: Fix CSS variables, rebuild assets!
