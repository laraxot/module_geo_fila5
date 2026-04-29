# GSD Phase 13: Homepage HTML Parity

**Phase ID**: 13-homepage-html-parity  
**Status**: 🟡 In Progress  
**Created**: 2026-03-30  
**Priority**: 🔴 CRITICAL (P0)  
**Owner**: Multi-Agent Team

---

## 🎯 Goal

Make HTML inside `<body>` **IDENTICAL** to upstream AGID homepage.

**Upstream**: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html  
**FixCity**: http://fixcity.local/it/tests/homepage

**Target**: 95%+ HTML match

---

## 📋 Tasks

### Wave 1: Header (4 tasks)
- [ ] Create header-slim component (region, language, login, social)
- [ ] Create header-main component (brand, search)
- [ ] Create navbar component (menu items)
- [ ] Integrate with [slug].blade.php

### Wave 2: Content Sections (7 tasks)
- [ ] Hero section (title only)
- [ ] Featured news (large card with date, title, excerpt)
- [ ] Governance cards (3 cards: Sindaco, Giunta, Consiglio)
- [ ] Events calendar (AGID format with days)
- [ ] Topics highlight (cards with links)
- [ ] Thematic sites (3 sites with colors)
- [ ] Search + feedback section

### Wave 3: Footer (4 tasks)
- [ ] Footer top (4 columns: Contatta, Problemi, Cerca, Forse stavi cercando)
- [ ] Footer main (6 columns: Amministrazione, Categorie, Novità, Vivere, Contatti)
- [ ] Footer bottom (social icons + legal links)
- [ ] Copyright section

### Wave 4: Verification (3 tasks)
- [ ] HTML diff with upstream
- [ ] CSS classes verification
- [ ] Visual comparison (screenshot)

---

## 🔧 Implementation Pattern

### JSON Structure (tests.homepage.json)

```json
{
  "id": "tests.homepage",
  "slug": "tests.homepage",
  "title": {"it": "Homepage - Nome del Comune"},
  "content_blocks": {
    "it": [
      {
        "type": "header",
        "data": {
          "view": "pub_theme::components.blocks.header.full",
          "region": "Nome della Regione",
          "language": "ITA",
          "login_url": "#",
          "social": ["twitter", "facebook", "youtube", "telegram", "whatsapp", "rss"]
        }
      },
      {
        "type": "hero",
        "data": {
          "view": "pub_theme::components.blocks.hero.simple",
          "title": "NOME DEL COMUNE"
        }
      },
      {
        "type": "featured_news",
        "data": {
          "view": "pub_theme::components.blocks.news.featured",
          "date": "18 mag 2026",
          "category": "Notizie",
          "title": "PARTE L'ESTATE CON OLTRE 300 EVENTI",
          "excerpt": "Inaugurazione lunedì 2 luglio...",
          "tag": "Estate in città"
        }
      },
      {
        "type": "governance_cards",
        "data": {
          "view": "pub_theme::components.blocks.governance.cards",
          "title": "Organi di governo",
          "items": [
            {
              "title": "MARIO ROSSI",
              "subtitle": "Il Sindaco della città",
              "url": "/it/tests/amministrazione"
            },
            {
              "title": "LA GIUNTA COMUNALE",
              "subtitle": "La giunta, nominata dal sindaco...",
              "url": "/it/tests/amministrazione"
            },
            {
              "title": "IL CONSIGLIO COMUNALE",
              "subtitle": "Il Consiglio è un organo collegiale...",
              "url": "/it/tests/amministrazione"
            }
          ]
        }
      },
      {
        "type": "events_calendar",
        "data": {
          "view": "pub_theme::components.blocks.events.calendar",
          "month": "SETTEMBRE",
          "year": "2026",
          "events": [
            {"day": "15", "weekday": "LUN", "items": ["Saldo TASI", "Concerto gratuito"]},
            {"day": "16", "weekday": "MAR", "items": ["Presentazione mostra"]},
            {"day": "17", "weekday": "MER", "items": ["Presentazione piano lavori"]},
            {"day": "18", "weekday": "GIO", "items": ["Evento 'La notte bianca'"]}
          ]
        }
      },
      {
        "type": "topics_highlight",
        "data": {
          "view": "pub_theme::components.blocks.topics.highlight",
          "title": "Argomenti in evidenza",
          "items": [
            {
              "title": "TRASPORTO PUBBLICO",
              "description": "Informazioni sui servizi...",
              "url": "#",
              "external": "MOBILITÀ IN COMUNE",
              "external_url": "#"
            },
            {
              "title": "ANIMALE DOMESTICO",
              "description": "Informazioni sui servizi...",
              "url": "#",
              "links": [
                {"title": "Come adottare un cane", "url": "#"},
                {"title": "Elenco delle aree per cani", "url": "#"}
              ]
            }
          ]
        }
      },
      {
        "type": "thematic_sites",
        "data": {
          "view": "pub_theme::components.blocks.thematic.sites",
          "items": [
            {"title": "MOBILITÀ IN COMUNE", "description": "...", "color": "blue"},
            {"title": "TURISMO", "description": "...", "color": "yellow"},
            {"title": "MUSEI CIVICI", "description": "...", "color": "dark"}
          ]
        }
      },
      {
        "type": "search_feedback",
        "data": {
          "view": "pub_theme::components.blocks.search.feedback",
          "search_placeholder": "Cerca una parola chiave",
          "feedback_question": "QUANTO SONO CHIARE LE INFORMAZIONI SU QUESTA PAGINA?",
          "quick_links": ["CIE", "Cambio di residenza", "Tributi online"]
        }
      },
      {
        "type": "footer",
        "data": {
          "view": "pub_theme::components.blocks.footer.full",
          "municipality": "NOME DEL COMUNE",
          "address": "Via Roma 123 - 00100 Comune",
          "vat": "00123456789",
          "phone": "800 016 123",
          "social": ["twitter", "facebook", "youtube", "telegram", "whatsapp", "rss"]
        }
      }
    ]
  }
}
```

### Block View Example

**File**: `blocks/governance/cards.blade.php`

```blade
@props(['title' => '', 'items' => []])

<section class="governance-section py-8">
    <div class="container">
        <h2 class="title-xxlarge mb-6">{{ $title }}</h2>
        <div class="row g-4">
            @foreach($items as $item)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card-wrapper card-space">
                    <div class="card card-bg">
                        <div class="card-body">
                            @if(isset($item['image']))
                            <img src="{{ $item['image'] }}" alt="" class="card-img-top mb-3">
                            @endif
                            <h3 class="card-title h5">{{ $item['title'] }}</h3>
                            <p class="card-text mt-2">{{ $item['subtitle'] }}</p>
                            <a href="{{ $item['url'] }}" class="read-more text-primary fw-semibold text-decoration-none mt-3 d-inline-flex align-items-center">
                                <span>Vai alla pagina</span>
                                <x-filament::icon icon="heroicon-o-arrow-right" class="icon-sm ms-2" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
```

---

## 📊 Progress Tracking

| Wave | Tasks | Complete | Status |
|------|-------|----------|--------|
| **Wave 1** | Header (4) | 0/4 | ⏳ Pending |
| **Wave 2** | Content (7) | 0/7 | ⏳ Pending |
| **Wave 3** | Footer (4) | 0/4 | ⏳ Pending |
| **Wave 4** | Verification (3) | 0/3 | ⏳ Pending |

**Total**: 0/18 (0%)

---

## 🤖 Agent Assignment

### Wave 1: Header (Amelia)
**Agent**: Amelia (BMAD Dev)  
**ETA**: 2 hours

### Wave 2: Content (Amelia + Ralph)
**Agent**: Amelia + Ralph Loop  
**ETA**: 3 hours

### Wave 3: Footer (Amelia)
**Agent**: Amelia  
**ETA**: 2 hours

### Wave 4: Verification (gsd-verifier)
**Agent**: gsd-verifier  
**ETA**: 30 min

---

## ✅ Quality Gates

### Before Commit
- [ ] HTML structure matches upstream
- [ ] CSS classes exact match
- [ ] ARIA attributes present
- [ ] data-* attributes correct
- [ ] Text content identical (Italian)

### After Commit
- [ ] HTML diff <5%
- [ ] Visual match >95%
- [ ] Accessibility (WCAG 2.1)
- [ ] Responsive (mobile/tablet/desktop)

---

## 🤖 OpenViking Context

```bash
openviking add-memory "GSD Phase 13: Homepage HTML parity. Target 95%+ match with upstream AGID. 4 waves: Header (4), Content (7), Footer (4), Verification (3). Using Superpowers + JSON."
```

---

## 📚 Related Documentation

- [BMAD Thread](../../../_bmad/threads/homepage-html-parity.md)
- [Superpowers Integration](./SUPERPOWERS_INTEGRATION_GUIDE.md)
- [SVG Icon Convention](./SVG_ICON_CONVENTION.md)

---

**Last Updated**: 2026-03-30  
**Next Action**: Execute Wave 1 (Header)  
**Owner**: Multi-Agent Team
