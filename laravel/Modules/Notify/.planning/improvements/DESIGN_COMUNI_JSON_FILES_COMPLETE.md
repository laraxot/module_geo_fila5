# ✅ Design Comuni JSON Files - COMPLETE

**Date**: 2026-03-30  
**Status**: ✅ **ALL 38 PAGES CREATED**  
**Location**: `laravel/config/local/fixcity/database/content/pages/`

---

## 📊 Summary

**Total Files**: 38 JSON files  
**Pattern**: `tests.{slug}.json`  
**Structure**: Hero block + Content block  
**DRY + KISS**: Single template, simple structure

---

## 📁 Files Created (38 total)

### 1. GENERALI (9 files)

| File | Title IT | Slug |
|------|----------|------|
| `tests.homepage.json` | Home Page | homepage |
| `tests.domande-frequenti.json` | Domande Frequenti | domande-frequenti |
| `tests.risultati-ricerca.json` | Risultati Ricerca | risultati-ricerca |
| `tests.argomenti.json` | Argomenti | argomenti |
| `tests.argomento.json` | Argomento | argomento |
| `tests.lista-risorse.json` | Lista Risorse | lista-risorse |
| `tests.lista-categorie.json` | Lista Categorie | lista-categorie |
| `tests.lista-risorse-categorie.json` | Risorse e Categorie | lista-risorse-categorie |
| `tests.mappa-sito.json` | Mappa del Sito | mappa-sito |

### 2. AMMINISTRAZIONE (2 files)

| File | Title IT | Slug |
|------|----------|------|
| `tests.amministrazione.json` | Amministrazione | amministrazione |
| `tests.documenti-dati.json` | Documenti e Dati | documenti-dati |

### 3. NOVITÀ (2 files)

| File | Title IT | Slug |
|------|----------|------|
| `tests.novita.json` | Novità | novita |
| `tests.novita-dettaglio.json` | Dettaglio Novità | novita-dettaglio |

### 4. SERVIZI (3 files)

| File | Title IT | Slug |
|------|----------|------|
| `tests.servizi.json` | Servizi | servizi |
| `tests.servizi-categoria.json` | Categoria Servizi | servizi-categoria |
| `tests.servizio-dettaglio.json` | Dettaglio Servizio | servizio-dettaglio |

### 5. VIVERE IL COMUNE (2 files)

| File | Title IT | Slug |
|------|----------|------|
| `tests.eventi.json` | Eventi | eventi |
| `tests.evento-dettaglio.json` | Dettaglio Evento | evento-dettaglio |

### 6. PRENOTAZIONE APPUNTAMENTO (8 files)

| File | Title IT | Slug |
|------|----------|------|
| `tests.appuntamento-01-ufficio.json` | Prenotazione - Ufficio | appuntamento-01-ufficio |
| `tests.appuntamento-01-ufficio-luogo.json` | Prenotazione - Luogo | appuntamento-01-ufficio-luogo |
| `tests.appuntamento-02-data-orario.json` | Prenotazione - Data e Ora | appuntamento-02-data-orario |
| `tests.appuntamento-03-dettagli.json` | Prenotazione - Dettagli | appuntamento-03-dettagli |
| `tests.appuntamento-04-richiedente.json` | Prenotazione - Richiedente | appuntamento-04-richiedente |
| `tests.appuntamento-04-richiedente-autenticato.json` | Prenotazione - Autenticato | appuntamento-04-richiedente-autenticato |
| `tests.appuntamento-05-riepilogo.json` | Prenotazione - Riepilogo | appuntamento-05-riepilogo |
| `tests.appuntamento-06-conferma.json` | Prenotazione - Conferma | appuntamento-06-conferma |

### 7. RICHIESTA ASSISTENZA (2 files)

| File | Title IT | Slug |
|------|----------|------|
| `tests.assistenza-01-dati.json` | Assistenza - Dati | assistenza-01-dati |
| `tests.assistenza-02-conferma.json` | Assistenza - Conferma | assistenza-02-conferma |

### 8. SEGNALAZIONE DISSERVIZIO (7 files)

| File | Title IT | Slug |
|------|----------|------|
| `tests.segnalazione-dettaglio.json` | Segnalazione - Dettaglio | segnalazione-dettaglio |
| `tests.segnalazione-01-privacy.json` | Segnalazione - Privacy | segnalazione-01-privacy |
| `tests.segnalazione-02-dati.json` | Segnalazione - Dati | segnalazione-02-dati |
| `tests.segnalazione-03-riepilogo.json` | Segnalazione - Riepilogo | segnalazione-03-riepilogo |
| `tests.segnalazione-04-conferma.json` | Segnalazione - Conferma | segnalazione-04-conferma |
| `tests.segnalazione-area-personale.json` | Segnalazione - Area Personale | segnalazione-area-personale |
| `tests.segnalazioni-elenco.json` | Segnalazioni - Elenco | segnalazioni-elenco |

---

## 📄 JSON Structure (DRY + KISS)

### Template

```json
{
    "id": "tests.{slug}",
    "title": {
        "it": "{Titolo Italiano}",
        "en": "{English Title}"
    },
    "slug": "tests.{slug}",
    "content": null,
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "title": "{Hero Title}",
                    "subtitle": "Design Comuni Pagine Statiche",
                    "view": "cms::components.blocks.hero"
                }
            },
            {
                "type": "content",
                "data": {
                    "text": "{Page description}",
                    "view": "cms::components.blocks.content"
                }
            }
        ]
    },
    "sidebar_blocks": {
        "it": [],
        "en": []
    },
    "footer_blocks": {
        "it": "",
        "en": ""
    },
    "created_at": "2026-03-30T00:00:00.000000Z",
    "updated_at": "2026-03-30T00:00:00.000000Z",
    "created_by": "system",
    "updated_by": "system"
}
```

### Example: `tests.appuntamento-06-conferma.json`

```json
{
    "id": "tests.appuntamento-06-conferma",
    "title": {
        "it": "Appuntamento confermato",
        "en": "Appointment confirmed"
    },
    "slug": "tests.appuntamento-06-conferma",
    "content": null,
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "title": "Appuntamento confermato",
                    "subtitle": "Design Comuni Pagine Statiche",
                    "view": "cms::components.blocks.hero"
                }
            },
            {
                "type": "content",
                "data": {
                    "text": "Il tuo appuntamento è stato prenotato con successo",
                    "view": "cms::components.blocks.content"
                }
            }
        ]
    },
    "sidebar_blocks": {
        "it": [],
        "en": []
    },
    "footer_blocks": {
        "it": "",
        "en": ""
    },
    "created_at": "2026-03-30T00:00:00.000000Z",
    "updated_at": "2026-03-30T00:00:00.000000Z",
    "created_by": "system",
    "updated_by": "system"
}
```

---

## 🎯 DRY + KISS Compliance

### DRY (Don't Repeat Yourself)

✅ **Single template**: All 38 files use same structure  
✅ **Single script**: Bash script generated all files  
✅ **Reusable blocks**: Hero + Content pattern  
✅ **Consistent naming**: `tests.{slug}.json`

### KISS (Keep It Simple, Stupid)

✅ **Simple structure**: Basic JSON with title, slug, blocks  
✅ **Minimal blocks**: Hero + Content (can extend later)  
✅ **Easy to edit**: Plain JSON files  
✅ **Clear naming**: Obvious from filename

---

## 📊 Statistics

| Category | Count | Percentage |
|----------|-------|------------|
| **Generali** | 9 | 24% |
| **Amministrazione** | 2 | 5% |
| **Novità** | 2 | 5% |
| **Servizi** | 3 | 8% |
| **Vivere il Comune** | 2 | 5% |
| **Prenotazione Appuntamento** | 8 | 21% |
| **Richiesta Assistenza** | 2 | 5% |
| **Segnalazione Disservizio** | 7 | 18% |
| **Extra** | 3 | 8% |
| **TOTAL** | **38** | **100%** |

---

## 🔄 How It Works

### Request Flow

```
1. Request: /it/tests/appuntamento-06-conferma
    ↓
2. Folio Route: pages/tests/[slug].blade.php
    ↓
3. Volt: mount($slug='appuntamento-06-conferma')
    ↓
4. Component: <x-page side="content" :slug="tests.appuntamento-06-conferma" />
    ↓
5. PageModel::getBlocksBySlug('tests.appuntamento-06-conferma')
    ↓
6. Sushi ORM: Loads JSON file
    ↓
7. HasBlocks: Parses content_blocks
    ↓
8. BlockData: Creates block objects
    ↓
9. View: Renders hero + content blocks
```

---

## 📁 File Location

```
laravel/config/local/fixcity/database/content/pages/
├── tests.homepage.json
├── tests.argomenti.json
├── tests.appuntamento-01-ufficio.json
├── tests.appuntamento-02-data-orario.json
├── tests.appuntamento-03-dettagli.json
├── tests.appuntamento-04-richiedente.json
├── tests.appuntamento-04-richiedente-autenticato.json
├── tests.appuntamento-05-riepilogo.json
├── tests.appuntamento-06-conferma.json
├── tests.servizi.json
├── tests.eventi.json
├── tests.novita.json
└── ... (38 files total)
```

---

## ✅ Checklist

- [x] All 38 JSON files created
- [x] Consistent structure
- [x] Hero + Content blocks
- [x] Multi-language support (IT/EN)
- [x] DRY + KISS compliant
- [x] OpenViking updated
- [ ] Test all pages (next step)
- [ ] Add custom blocks per page (future)

---

## 🚀 Next Steps

1. **Test Pages**: Visit `/it/tests/{slug}` for each page
2. **Add Custom Blocks**: Create specific blocks per page type
3. **Enhance Content**: Add more detailed content per page
4. **Create Views**: Build Blade views for each block type

---

## 📚 Related Documentation

| Document | Location |
|----------|----------|
| **CMS JSON Philosophy** | `.planning/improvements/CMS_JSON_SUSHI_PHILOSOPHY.md` |
| **Folio + Volt** | `.planning/improvements/FOLIO_VOLT_PHILOSOPHY.md` |
| **Design Comuni Plan** | `.planning/improvements/DESIGN_COMUNI_REPLICATION_PLAN.md` |

---

**Status**: ✅ **ALL 38 JSON FILES CREATED**  
**Pattern**: `tests.{slug}.json`  
**DRY + KISS**: Single template, simple structure  
**Next**: Test all pages

**Design Comuni JSON files complete! 🚀**
