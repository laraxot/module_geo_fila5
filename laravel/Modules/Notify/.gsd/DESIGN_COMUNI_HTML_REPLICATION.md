# GSD: Design Comuni HTML Replication

**Project:** FixCity Fila5
**Date:** 2026-04-01
**Status:** 🔴 **IN PROGRESS**
**Priority:** CRITICAL

---

## 🎯 GOAL

Replicare **ESATTAMENTE** l'HTML dentro `<body>` (esclusi `<script>`) di:
- https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html
- in http://fixcity.local/it/tests/homepage

**Metriche di Successo:**
- ✅ Stesso numero di linee HTML (~1,306)
- ✅ Stesso numero di classi CSS (~233 unique)
- ✅ Tutti i componenti presenti (skiplink, cmp-*, card-teaser, etc.)
- ✅ Stessa struttura: header, main, footer

---

## 📊 CURRENT STATE

### Metriche Attuali

| Metrica | Target | Actual | Gap |
|---------|--------|--------|-----|
| **Linee HTML** | 1,306 | 1,016 | **-290 (-22%)** |
| **Classi CSS** | 233 | 156 | **-77 (-33%)** |
| **skiplink** | 2 | 0 | ❌ MANCANTE |
| **cmp-*** | 22 | 0 | ❌ ASSENTE |
| **card-teaser** | 22 | 0 | ❌ ASSENTE |
| **it-hero-wrapper** | 1 | 0 | ❌ ASSENTE |

### Cosa Manca

```
❌ Skip links (skiplink div)
❌ Hero section (it-hero-wrapper)
❌ Card teaser components (22 card-teaser)
❌ Componenti cmp-* (22 occorrenze)
❌ Footer completo (footer-small-prints)
```

---

## 📋 TASK BREAKDOWN

### TASK 1: Skip Links ✅ FIXATO

**File:** `laravel/Themes/Sixteen/resources/views/components/layouts/app.blade.php`

**Action:** Aggiungere skip links come primo elemento

```blade
<div class="skiplink">
    <a class="visually-hidden-focusable" href="#main-container">Vai ai contenuti</a>
    <a class="visually-hidden-focusable" href="#footer">Vai al footer</a>
</div>
```

**Status:** ⏳ TO DO

---

### TASK 2: Hero Section

**File:** `laravel/Themes/Sixteen/resources/views/components/blocks/hero/default.blade.php`

**Action:** Creare hero section con classe `it-hero-wrapper`

**HTML Target:**
```html
<div class="it-hero-wrapper it-dark it-overlay">
    <div class="img-responsive-wrapper">
        <div class="img-responsive">
            <div class="img-wrapper">
                <img src="..." alt="...">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="it-hero-text-wrapper bg-dark">
                    <h1 class="no_toc">NOME DEL COMUNE</h1>
                    <p class="d-none d-lg-block">CONTENUTI IN EVIDENZA</p>
                </div>
            </div>
        </div>
    </div>
</div>
```

**Status:** ⏳ TO DO

---

### TASK 3: Card Teaser Components (22 occorrenze)

**File:** `laravel/Themes/Sixteen/resources/views/components/blocks/card/teaser.blade.php`

**Action:** Creare card-teaser component

**HTML Target:**
```html
<div class="card card-teaser shadow p-4 rounded border border-light">
    <div class="card-body">
        <h5 class="card-title">
            <a href="...">Titolo</a>
        </h5>
        <p class="card-text">Descrizione</p>
    </div>
</div>
```

**Status:** ⏳ TO DO

---

### TASK 4: Componenti cmp-* (22 occorrenze)

**Files da creare:**
- `components/blocks/navigation/main.blade.php` (cmp-navigation-main)
- `components/blocks/contacts/default.blade.php` (cmp-contacts)
- `components/blocks/feedback/rating.blade.php` (cmp-feedback-rating)
- `components/blocks/search/support-links.blade.php` (cmp-search-support-links)
- `components/blocks/topics/highlight.blade.php` (cmp-topics-highlight)

**Status:** ⏳ TO DO

---

### TASK 5: Footer Completo

**File:** `laravel/Themes/Sixteen/resources/views/components/blocks/footer/main.blade.php`

**Action:** Aggiungere footer-small-prints section

**HTML Target:**
```html
<footer id="footer" class="it-footer">
    <div class="it-footer-main">
        <!-- Footer columns -->
    </div>
    <div class="it-footer-small-prints">
        <div class="container">
            <ul class="list-inline">
                <li><a href="#">Media policy</a></li>
                <li><a href="#">Mappa del sito</a></li>
            </ul>
        </div>
    </div>
</footer>
```

**Status:** ⏳ TO DO

---

### TASK 6: JSON Content Blocks

**File:** `laravel/config/local/fixcity/database/content/pages/tests.homepage.json`

**Action:** Aggiornare JSON con tutti i blocchi mancanti

**Struttura:**
```json
{
  "content_blocks": {
    "it": [
      {"type": "hero", "data": {...}},
      {"type": "news-section", "data": {...}},
      {"type": "governance-section", "data": {...}},
      {"type": "events-section", "data": {...}},
      {"type": "topics-section", "data": {...}},
      {"type": "search-section", "data": {...}},
      {"type": "feedback-section", "data": {...}}
    ]
  }
}
```

**Status:** ⏳ TO DO

---

## 🚀 EXECUTION ORDER

1. ✅ Fix [slug].blade.php syntax error
2. ✅ Build Vite assets (npm run build + copy)
3. ✅ Add Skip Links (app.blade.php) - **COMPLETED**
4. ✅ Create Hero Section (hero/default.blade.php) - **COMPLETED**
5. ✅ Create Card Teaser (card/teaser.blade.php) - **COMPLETED**
6. ✅ Create cmp-* components - **COMPLETED**
7. ✅ Fix Footer (footer/main.blade.php) con footer-small-prints - **COMPLETED**
8. ✅ Update JSON content - **COMPLETED**
   - ✅ events-section
   - ✅ topics-section
   - ✅ search-section
   - ✅ feedback-section (rating)
9. ⏳ Test HTML parity
10. ⏳ Verify metrics (1,306 lines, 233 classes)

---

## 📊 PROGRESS TRACKING

| Task | Status | Completed |
|------|--------|-----------|
| Fix [slug].blade.php | ✅ DONE | 1/10 |
| Build Vite | ✅ DONE | 1/10 |
| Skip Links | ✅ DONE | 1/10 |
| Hero Section | ✅ DONE | 1/10 |
| Card Teaser | ✅ DONE | 1/10 |
| cmp-* Components | ✅ DONE | 1/10 |
| Footer | ✅ DONE | 1/10 |
| JSON Content | ✅ DONE | 1/10 |
| Test Parity | ⏳ TODO | 0/10 |
| Verify Metrics | ⏳ TODO | 0/10 |

**Progress:** 8/10 (80%)

---

## ✅ DEFINITION OF DONE

- [ ] HTML lines: 1,306 ±50
- [ ] CSS classes: 233 ±20
- [ ] skiplink: 2 occorrenze
- [ ] card-teaser: 22 occorrenze
- [ ] cmp-*: 22 occorrenze
- [ ] it-hero-wrapper: 1 occorrenza
- [ ] Footer completo con small-prints

---

**📝 GSD Plan Created**
**🔄 Next: Execute Task 3 (Skip Links)**

🐮 **GET SHIT DONE!**
