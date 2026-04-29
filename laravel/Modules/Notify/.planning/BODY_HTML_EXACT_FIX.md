# 🚨 BODY HTML - EXACT MATCH REQUIRED

**Data**: 2026-03-31  
**Status**: 🟡 CRITICAL FIX IN PROGRESS  
**Priority**: MAXIMUM

---

## ❌ PROBLEM

Our `<body>` HTML is **DIFFERENT** from reference!

### Reference (Design Comuni)
```html
<body>
    <div class="skiplink">
        <a class="visually-hidden-focusable" href="#main-container">Vai ai contenuti</a>
        <a class="visually-hidden-focusable" href="#footer">Vai al
            footer</a>
    </div><!-- /skiplink -->
    <header class="it-header-wrapper" data-bs-target="#header-nav-wrapper" style="">
        <div class="it-header-slim-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="it-header-slim-wrapper-content">
```

### Our Version (BEFORE - WRONG)
```html
<body class="min-h-screen antialiased bg-white...">
    <header class="it-header-wrapper">
```

**Missing**:
- ❌ `<div class="skiplink">`
- ❌ Skip links to `#main-container` and `#footer`
- ❌ Exact structure match

---

## ✅ CRITICAL FIX APPLIED

### File: `layouts/app.blade.php`

**NOW**:
```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/Sixteen')
</head>
<body>
    {{-- Skip Links - EXACT Bootstrap Italia Structure --}}
    <div class="skiplink">
        <a class="visually-hidden-focusable" href="#main-container">Vai ai contenuti</a>
        <a class="visually-hidden-focusable" href="#footer">Vai al
            footer</a>
    </div><!-- /skiplink -->

    {{-- Header - Bootstrap Italia EXACT Structure --}}
    <x-section slug="header" />

    {{-- Main Content --}}
    <main id="main-container">
        @yield('content')
        <x-page side="content" :slug="$slug ?? ''" :data="$data ?? []" />
    </main>

    {{-- Footer - Bootstrap Italia EXACT Structure --}}
    <x-section slug="footer" />

    {{-- Scripts --}}
    @stack('scripts')
</body>
</html>
```

---

## 📋 VERIFICATION CHECKLIST

### Body Start
- [ ] `<body>` tag (no classes)
- [ ] `<div class="skiplink">`
- [ ] Link to `#main-container`
- [ ] Link to `#footer`
- [ ] `<!-- /skiplink -->` comment

### Header Start
- [ ] `<header class="it-header-wrapper">`
- [ ] `data-bs-target="#header-nav-wrapper"`
- [ ] `<div class="it-header-slim-wrapper">`
- [ ] `<div class="container">`
- [ ] `<div class="row">`
- [ ] `<div class="col-12">`
- [ ] `<div class="it-header-slim-wrapper-content">`

---

## 🧘 MANTRAS

> *"HTML IDENTICAL. Inside <body>. EXACT."*

> *"Skiplinks FIRST. Then header."*

> *"NO Tailwind classes on <body>."*

---

**Status**: 🟡 CRITICAL FIX APPLIED  
**Next**: Test, verify HTML identical!
