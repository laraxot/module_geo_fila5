# Homepage Visual Parity - Piano di Lavoro

**Data**: 2026-04-02  
**Status**: 🔄 IN PROGRESS

---

## Obiettivo

Rendere visivamente identiche le due homepage:
- **Reference**: `https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html`
- **Locale**: `http://127.0.0.1:8000/it/tests/homepage`

---

## Analisi Completata

### ✅ Struttura HTML: IDENTICA al 99%

| Elemento | Reference | Locale | Stato |
|----------|-----------|--------|-------|
| IDs totali | 35 | 32 | ✅ 32 matching |
| data-element | 35 | 35 | ✅ 100% matching |
| Sezioni | Tutte presenti | Tutte presenti | ✅ |

### ❌ Problemi Rilevati

1. **search-modal mancante** - Il modal HTML è commentato nel blade `v1.blade.php`
2. **autocomplete-two mancante** - ID per input search non presente
3. **Stili CSS** - Potrebbero differire visivamente

---

## Piano di Lavoro

### Fase 1: Search Modal (IN CORSO)

- [x] Individuare search-modal commentato in `v1.blade.php`
- [ ] Decommentare il search-modal HTML
- [ ] Aggiungere stili CSS mancanti se necessario

### Fase 2: Verifica Build

- [ ] npm run build
- [ ] npm run copy
- [ ] Verifica HTML locale

### Fase 3: Analisi CSS Visiva

- [ ] Confrontare stili principali (colori, font, spacing)
- [ ] Correggere eventuali mismatch

---

## File Chiave

| File | Azione |
|------|--------|
| `laravel/Themes/Sixteen/resources/views/components/sections/header/v1.blade.php` | Decommentare search-modal |
| `laravel/Themes/Sixteen/resources/css/style-apply.css` | Verificare stili modal |
| `laravel/Themes/Sixteen/resources/js/app.js` | Verificare funzionalità Alpine |

---

## Comandi Build

```bash
cd /var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen
npm run build
npm run copy
```

---

## Responsabile

Agent AI corrente - Procedura in corso
