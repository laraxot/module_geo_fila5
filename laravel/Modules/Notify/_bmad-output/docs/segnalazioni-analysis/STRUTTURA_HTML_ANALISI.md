# Analisi Strutturale: Segnalazioni Pages

## Panoramica

Questo documento confronta la struttura HTML delle pagine di segnalazione tra:
- **Reference**: `https://italia.github.io/design-comuni-pagine-statiche/sito/<pagina>.html`
- **Locale**: `http://127.0.0.1:8000/it/tests/<pagina>`

## Pagine Analizzate

1. `segnalazione-dettaglio` - Scheda servizio segnalazione
2. `segnalazione-01-privacy` - Step 1 privacy
3. `segnalazione-02-dati` - Step 2 inserimento dati
4. `segnalazione-03-riepilogo` - Step 3 riepilogo
5. `segnalazione-04-conferma` - Step 4 conferma
6. `segnalazione-area-personale` - Area personale segnalazioni
7. `segnalazioni-elenco` - Elenco segnalazioni

## Differenze Strutturali Identificate

### 1. Layout Header
| Elemento | Reference | Locale |
|---------|-----------|--------|
| Header wrapper | `it-header-wrapper` | `<x-layouts.app>` + `<x-header>` |
| Header slim | `it-header-slim-wrapper` | Custom component |
| Navbar | `navbar navbar-expand-lg has-megamenu` | Custom component |

### 2. Stepper/Progress
| Elemento | Reference | Locale |
|---------|-----------|--------|
| Stepper container | `.steppers` | `flow-stepper` block |
| Steps list | `<ul>` con `<li class="active">` | JSON config in content blocks |
| Step indicator | `.steppers-index` | `flow-stepper` component |

### 3. Form Elements
| Elemento | Reference | Locale |
|---------|-----------|--------|
| Checkbox | `.form-check` + `<input type="checkbox">` | Custom `flow-segnalazione-privacy` |
| Select dropdown | `.select-wrapper` | Custom component |
| Autocomplete | `.cmp-input-autocomplete` | Custom component |
| Textarea | `.cmp-text-area` | Custom component |
| File upload | `.upload-wrapper` | Custom component |

### 4. Contatti Section
| Elemento | Reference | Locale |
|---------|-----------|--------|
| Wrapper | `.bg-grey-card.shadow-contacts` | `contacts` sidebar block |
| Card | `.card` | Custom component |
| Contact list | `.contact-list` | Custom component |

### 5. Footer
| Elemento | Reference | Locale |
|---------|-----------|--------|
| Footer wrapper | `.it-footer` | Custom component |
| Logo | `.it-brand-wrapper` | Custom component |
| Links | `.footer-list` | Custom component |

## Elementi HTML Chiave da Replicare

### Stepper Section (Reference)
```html
<div class="steppers">
  <div class="steppers-header">
    <ul>
      <li class="active">Autorizzazioni e condizioni</li>
      <li class="">Dati di segnalazione</li>
      <li class="">Riepilogo</li>
    </ul>
    <span class="steppers-index">1/3</span>
  </div>
</div>
```

### Privacy Form (Reference)
```html
<div class="form-check mt-4 mb-3">
  <div class="checkbox-body d-flex align-items-center">
    <input type="checkbox" id="privacy">
    <label for="privacy">Ho letto e compreso l'informativa</label>
  </div>
</div>
<button type="button" class="btn btn-primary mobile-full">Avanti</button>
```

### Contact Card (Reference)
```html
<div class="bg-grey-card shadow-contacts">
  <div class="cmp-contacts">
    <div class="card">
      <div class="card-body">
        <h2>Contatta il comune</h2>
        <ul class="contact-list">
          <li><a class="list-item">FAQ</a></li>
          <li><a class="list-item">Assistenza</a></li>
          <li><a class="list-item">Telefono</a></li>
          <li><a class="list-item">Prenotazione</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
```

## CSS/Tailwind Necessario

### Classi da ricreare in Tailwind
1. `.steppers` - Step progress indicator
2. `.steppers-header` - Header del stepper
3. `.steppers-index` - Indicatore numerico
4. `.form-check` - Form checkbox wrapper
5. `.checkbox-body` - Checkbox styling
6. `.bg-grey-card` - Background card
7. `.shadow-contacts` - Contact shadow
8. `.contact-list` - Contact list styling
9. `.chip` - Tag/Chip styling
10. `.btn-dropdown` - Dropdown button

## Azioni Richieste

### Fase 1: Analisi Visiva
- [ ]Screenshot di ogni pagina reference
- [ ]Screenshot di ogni pagina locale
- [ ]Comparazione side-by-side

### Fase 2: CSS/Tailwind
- [ ]Creare classi Tailwind mancanti
- [ ]Testare responsive design
- [ ]Verificare mobile/tablet

### Fase 3: JavaScript
- [ ]Implementare stepper navigation
- [ ]Implementare form validation
- [ ]Implementare autocomplete

### Fase 4: Build & Verify
- [ ]Eseguire `npm run build`
- [ ]Eseguire `npm run copy`
- [ ]Verificare con browser

## Data Files
- Reference: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-*.html`
- Locale JSON: `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-*.json`
- Blade: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`