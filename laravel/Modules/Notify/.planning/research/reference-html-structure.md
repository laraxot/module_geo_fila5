# Reference HTML Structure — Design Comuni Segnalazione Pages

**Source:** https://italia.github.io/design-comuni-pagine-statiche/sito/
**Researched:** 2026-04-07
**Pages Analyzed:** 8 (7 unique — page 1 "segnalazione-disservizio.html" does not exist; its content is covered by page 8 "segnalazione-dettaglio.html")

---

## Page Inventory

| # | Requested URL | Actual Page | Status |
|---|--------------|-------------|--------|
| 1 | `segnalazione-disservizio.html` | Does not exist (404) | ✗ Merged into #8 |
| 2 | `segnalazione-01-privacy.html` | Step 1: Privacy consent | ✓ |
| 3 | `segnalazione-02-dati.html` | Step 2: Report data entry | ✓ |
| 4 | `segnalazione-03-riepilogo.html` | Step 3: Summary review | ✓ |
| 5 | `segnalazione-04-conferma.html` | Step 4: Confirmation | ✓ |
| 6 | `segnalazione-area-personale.html` | Personal dashboard | ✓ |
| 7 | `segnalazioni-elenco.html` | Report listing/map | ✓ |
| 8 | `segnalazione-dettaglio.html` | Service detail page | ✓ |

---

## Global Components (Shared Across ALL Pages)

### 1. Skip Links (Every Page)
```html
<a class="visually-hidden-focusable" href="#main-content">Vai ai contenuti</a>
<a class="visually-hidden-focusable" href="#footer">Vai al footer</a>
```

### 2. Header Structure (Every Page)
```
header.it-header-wrapper
├── .it-header-slim-wrapper (top bar)
│   └── .container > .row > .col-12
│       ├── .it-region-name → <span>"Nome della Regione"</span>
│       ├── .it-header-language-wrapper
│       │   └── .dropdown (ITA/ENG switcher)
│       │       ├── .dropdown-toggle
│       │       └── .dropdown-menu > .dropdown-item
│       └── .it-header-user-wrapper (logged-in) OR .btn (not logged-in)
│           └── .dropdown (user menu: servizi, pratiche, notifiche, impostazioni, esci)
│
├── .it-header-center-wrapper (brand bar)
│   └── .container > .row > .col-12
│       ├── .it-header-brand-wrapper
│       │   └── .it-header-title-wrapper
│       │       ├── .it-header-title → "Nome del Comune"
│       │       └── .it-header-subtitle → "Un comune da vivere"
│       ├── .it-header-socials-wrapper (Twitter, Facebook, YouTube, Telegram, WhatsApp, RSS)
│       ├── .it-header-search-wrapper
│       │   ├── <button> "Cerca" (data-bs-toggle="collapse")
│       │   └── .it-searchbar-wrapper.collapse#search-collapse
│       └── .custom-navbar-toggler (mobile nav toggle)
│
└── .it-nav-wrapper (main navigation)
    └── nav.navbar.navbar-expand-lg.has-megamenu
        ├── .navbar-nav > .it-megamenu (Amministrazione, Novità, Servizi, Vivere il Comune)
        └── .it-megamenu-panel (topic links: Iscrizioni, Estate in città, Polizia locale, Tutti gli argomenti)
```

### 3. Breadcrumb (Every Page)
```html
<nav class="breadcrumb-container" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item"><a href="/servizi">Servizi</a></li>
    <li class="breadcrumb-item active" aria-current="page">[Page Title]</li>
  </ol>
</nav>
```

### 4. Footer Structure (Every Page)
```
footer.it-footer-wrapper#footer
├── .container > .row
│   ├── .col-lg-3 (NOME DEL COMUNE + address)
│   ├── .col-lg-3 (AMMINISTRAZIONE → link-list-wrapper)
│   ├── .col-lg-3 (CATEGORIE DI SERVIZIO → link-list-wrapper)
│   └── .col-lg-3 (NOVITÀ + VIVERE IL COMUNE + CONTATTI)
│
├── .it-footer-bottom-wrapper.py-3
│   ├── .it-footer-socials-list (Twitter, Facebook, YouTube, Telegram, WhatsApp, RSS)
│   ├── .it-footer-legal-wrapper (Amministrazione trasparente, Informativa privacy, Note legali, Dichiarazione di accessibilità)
│   └── .it-footer-copy (Media policy, Mappa del sito)
│
└── .back-to-top button
```

### 5. Sidebar Widgets (Pages 2-5, 7-8)
```
aside (right column, col-lg-4 or similar)
├── Contact Widget
│   └── <h3>"CONTATTA IL COMUNE"</h3>
│       └── <ul> (FAQ, Assistenza, Phone, Prenota appuntamento)
├── Search Widget
│   └── <form role="search">
│       └── <input type="search"> + <button>"Cerca"</button>
└── Suggested Links
    └── <h3>"FORSE STAVI CERCANDO"</h3>
        └── <ul> (CIE, Residenza, Tributi, Appuntamenti, Tessera elettorale, Voucher)
```

---

## Page 1: Segnalazione Dettaglio (Service Detail)

**URL:** `segnalazione-dettaglio.html`
**Purpose:** Service presentation card — the entry point for the segnalazione flow

### Body Structure
```html
<body>
  <!-- Skip Links -->
  <!-- Header (Global) -->

  <main id="main-content" class="it-main-wrapper">
    <div class="container">

      <!-- Breadcrumb (Global) -->

      <!-- Page Header -->
      <div class="it-page-header">
        <h1 class="title">SEGNALAZIONE DISSERVIZIO</h1>
        <span class="badge bg-success">Servizio attivo</span>
        <p class="lead">Un servizio aperto a tutti i cittadini per segnalare disservizi...</p>
        <div class="it-actions">
          <a class="btn btn-primary" href="/it/tests/segnalazione-01-privacy">Segnala disservizio</a>
          <a class="btn btn-outline-primary" href="/it/tests/segnalazioni-elenco">Tutte le segnalazioni</a>
        </div>
        <div class="it-share">
          <!-- Dropdown: Condividi con Facebook, Twitter, Linkedin, Whatsapp -->
        </div>
        <div class="it-utility-actions">
          <!-- Dropdown: Vedi azioni — Stampa, Ascolta, Invia -->
        </div>
      </div>

      <!-- Content Grid (2-column) -->
      <div class="row">
        <!-- Main Column (col-lg-8) -->
        <div class="col-lg-8 it-page-column">
          <section id="a-chi-e-rivolto" class="it-page-section">
            <h2>A CHI È RIVOLTO</h2><p>...</p>
          </section>
          <section id="descrizione" class="it-page-section">
            <h2>DESCRIZIONE</h2><p>...</p>
          </section>
          <section id="come-fare" class="it-page-section">
            <h2>COME FARE</h2><p>...</p>
          </section>
          <section id="cosa-serve" class="it-page-section">
            <h2>COSA SERVE</h2>
            <div class="mb-30 has-bg-grey p-3">
              <ul class="list-wrapper link-list lora"><li class="list-item">...</li></ul>
            </div>
          </section>
          <section id="cosa-si-ottiene" class="it-page-section">
            <h2>COSA SI OTTIENE</h2><p>...</p>
          </section>
          <section id="costi" class="it-page-section">
            <h2>COSTI</h2><p>Il servizio è gratuito.</p>
            <div class="it-attachments"><a href="#"><span class="it-clip"></span>Allegato se necessario</a></div>
          </section>

          <!-- CTA Callout -->
          <section class="it-callout callout-highlight">
            <h3>FAI UNA SEGNALAZIONE</h3>
            <p>Invia una segnalazione online dal tuo smartphone o computer.</p>
            <a class="btn btn-primary" href="#">Segnala disservizio</a>
            <p class="text-paragraph mt-4 lora">Oppure, prenota un appuntamento all'URP.</p>
            <a class="btn btn-outline-primary t-primary bg-white" href="#">Prenota appuntamento</a>
          </section>

          <section id="condizioni" class="it-page-section">
            <h2>CONDIZIONI DI SERVIZIO</h2>
            <a href="#"><span class="it-clip"></span>Termini e condizioni di servizio (PDF 1MB)</a>
          </section>
          <section id="contatti" class="it-page-section">
            <h2>CONTATTI</h2>
            <address>Ufficio Servizio pubblico<br>Via Dei Transiti 21, 50302<br>05 0505<br>ufficioserviziopubblico@email.it</address>
          </section>

          <!-- Topics/Tags -->
          <div class="it-tags">
            <h4>Argomenti:</h4>
            <ul>
              <li><a href="#">Gestione rifiuti</a></li>
              <li><a href="#">Igiene pubblica</a></li>
              <li><a href="#">Spazi verdi</a></li>
              <li><a href="#">Inquinamento</a></li>
            </ul>
          </div>
          <p class="text-muted small">Pagina aggiornata il 14/04/2022</p>
        </div>

        <!-- Sidebar Column (col-lg-4) -->
        <div class="col-lg-4 it-page-column it-sticky">
          <nav class="it-page-index" aria-label="INDICE DELLA PAGINA">
            <h3>INDICE DELLA PAGINA</h3>
            <ul class="link-list-wrapper">
              <li><a href="#a-chi-e-rivolto">A chi è rivolto</a></li>
              <li><a href="#descrizione">Descrizione</a></li>
              <li><a href="#come-fare">Come fare</a></li>
              <li><a href="#cosa-serve">Cosa serve</a></li>
              <li><a href="#cosa-si-ottiene">Cosa si ottiene</a></li>
              <li><a href="#costi">Costi</a></li>
              <li><a href="#condizioni">Condizioni di servizio</a></li>
              <li><a href="#contatti">Contatti</a></li>
            </ul>
          </nav>
        </div>
      </div>

      <!-- Feedback/Rating Module -->
      <section class="it-rating-container mt-5" id="servizio-feedback">
        <h3>QUANTO È STATO FACILE USARE QUESTO SERVIZIO?</h3>
        <div class="star-rating">[1-5 Stars]</div>
        <div class="feedback-success">GRAZIE, IL TUO PARERE CI AIUTERÀ A MIGLIORARE IL SERVIZIO!</div>

        <!-- Multi-step survey (shown after rating) -->
        <div class="it-progress-tracker" data-step="1/2">
          <fieldset>
            <legend>QUALI SONO STATI GLI ASPETTI CHE HAI PREFERITO?</legend>
            <!-- Checkboxes + "Altro" text input -->
          </fieldset>
        </div>
        <div class="it-progress-tracker" data-step="2/2">
          <fieldset>
            <legend>DOVE HAI INCONTRATO LE MAGGIORI DIFFICOLTÀ?</legend>
            <!-- Checkboxes + "Altro" text input -->
          </fieldset>
        </div>
        <div class="it-progress-tracker" data-step="2/2">
          <label>VUOI AGGIUNGERE ALTRI DETTAGLI?</label>
          <textarea maxlength="200" placeholder="Inserire massimo 200 caratteri"></textarea>
          <button class="btn btn-secondary">Indietro</button>
          <button class="btn btn-primary">Avanti / Invia</button>
        </div>
      </section>

      <!-- Related Content -->
      <section class="it-related-content mt-5">
        <h2>CONTENUTI CORRELATI</h2>
        <div class="row">
          <!-- 4-column grid of related links -->
        </div>
      </section>
    </div>
  </main>

  <!-- Footer (Global) -->
</body>
```

### Key CSS Classes
| Area | Classes |
|------|---------|
| Page Header | `it-page-header`, `title`, `lead`, `badge bg-success`, `it-actions`, `it-share`, `it-utility-actions` |
| Sections | `it-page-section`, `it-page-column`, `it-sticky` |
| Content | `it-callout`, `callout-highlight`, `has-bg-grey`, `p-3`, `mb-30`, `mb-5`, `mt-4`, `mt-5`, `text-muted`, `small` |
| Lists | `list-wrapper`, `link-list`, `lora`, `list-item`, `link-list-wrapper` |
| Attachments | `it-attachments`, `it-clip` |
| Tags | `it-tags` |
| Index Nav | `it-page-index`, `it-sticky` |
| Rating | `it-rating-container`, `star-rating`, `feedback-success`, `it-progress-tracker` |
| Related | `it-related-content` |

---

## Page 2: Step 1 — Privacy Consent

**URL:** `segnalazione-01-privacy.html`
**Purpose:** GDPR privacy notice and consent gate before form entry

### Body Structure
```html
<body>
  <!-- Skip Links -->
  <!-- Header (Global) -->

  <main id="main-content" class="it-main-wrapper">
    <div class="container">

      <!-- Breadcrumb (Global) -->

      <h1 class="h2">SEGNALAZIONE DISSERVIZIO</h1>

      <!-- Stepper -->
      <div class="stepper" aria-label="Progress">
        <ol>
          <li class="active">Autorizzazioni e condizioni <span class="badge badge-success">Attivo</span></li>
          <li>Dati di segnalazione</li>
          <li>Riepilogo</li>
        </ol>
        <span class="step-counter">1/3</span>
      </div>

      <!-- Privacy Text -->
      <section class="privacy-text">
        <p>Il Comune di Firenze gestisce i dati personali forniti... articolo 13 del Regolamento (UE) 2016/679... d.lgs 267/2000.</p>
        <p>Per i dettagli sul trattamento dei dati personali consulta l'<a href="#">informativa sulla privacy</a>.</p>
      </section>

      <!-- Consent Form -->
      <form class="step-form" action="#" method="POST">
        <div class="form-check">
          <input type="checkbox" id="privacy-consent" name="privacy" required>
          <label for="privacy-consent">Ho letto e compreso l'informativa sulla privacy</label>
        </div>
        <button type="submit" class="btn btn-primary">Avanti</button>
      </form>
    </div>
  </main>

  <!-- Sidebar (Global pattern) -->
  <!-- Footer (Global) -->
</body>
```

### Key CSS Classes
| Area | Classes |
|------|---------|
| Stepper | `stepper`, `steppers`, `steppers-item`, `steppers-item.completed`, `steppers-item.active`, `steppers-progress`, `step-counter`, `badge badge-success`, `badge badge-info` |
| Privacy | `privacy-text`, `form-note` |
| Form | `step-form`, `form-check`, `form-check-input`, `form-check-label` |

### Interactive Pattern
- **Gated Progression:** "Avanti" button is disabled until checkbox is checked (client-side validation)
- **Linear Flow:** Step 1/3 → cannot go back (no "Indietro" button on this step)

---

## Page 3: Step 2 — Data Entry Form

**URL:** `segnalazione-02-dati.html`
**Purpose:** Multi-section form for report details (location, issue type, description, attachments, author data)

### Body Structure
```html
<body>
  <!-- Skip Links -->
  <!-- Header (Global) -->

  <main id="main-content" class="it-main-wrapper">
    <div class="container">

      <!-- Breadcrumb (Global) -->

      <h1 class="h2">SEGNALAZIONE DISSERVIZIO</h1>

      <!-- Stepper (Step 2/3) -->
      <div class="steppers" aria-label="Form progress">
        <div class="steppers-item completed">Informativa sulla privacy</div>
        <div class="steppers-item active">Dati di segnalazione</div>
        <div class="steppers-item">Riepilogo</div>
        <span class="steppers-progress">2/3</span>
      </div>

      <form id="segnalazione-form" method="POST">
        <p class="form-note">I campi contraddistinti dal simbolo asterisco sono obbligatori</p>

        <!-- LUOGO Fieldset -->
        <fieldset id="luogo">
          <legend>LUOGO</legend>
          <div class="form-group">
            <label for="luogo_input">Indica il luogo del disservizio</label>
            <input type="text" id="luogo_input" required placeholder="Cerca un luogo" class="form-control">
            <button type="button" class="btn btn-outline-primary">Usa la tua posizione</button>
          </div>
        </fieldset>

        <!-- DISSERVIZIO Fieldset -->
        <fieldset id="disservizio">
          <legend>DISSERVIZIO</legend>
          <div class="form-group">
            <label for="tipo_disservizio">Tipo di disservizio</label>
            <select id="tipo_disservizio" required class="form-select">
              <option>Danneggiamento proprietà pubblica</option>
              <!-- More options -->
            </select>
          </div>
          <div class="form-group">
            <label for="titolo">Titolo</label>
            <input type="text" id="titolo" required class="form-control">
          </div>
          <div class="form-group">
            <label for="dettagli">Dettagli</label>
            <textarea id="dettagli" maxlength="200" required class="form-control"></textarea>
          </div>
          <div class="fileupload">
            <label>Immagini</label>
            <div class="fileupload-filename">6yhakandsahm413d8.jpg</div>
            <button type="button" class="btn btn-primary">Carica file</button>
          </div>
        </fieldset>

        <!-- AUTORE Fieldset -->
        <fieldset id="autore">
          <legend>AUTORE DELLA SEGNALAZIONE</legend>
          <div class="card user-card">
            <div class="card-body">
              <h5>GIULIA BIANCHI</h5>
              <p><strong>Codice Fiscale:</strong> GLABNC72H25H501Y</p>
              <button type="button" class="btn btn-link">Mostra tutto</button>
              <div class="contacts">
                <div>
                  <strong>Telefono:</strong> +39 331 1234567
                  <button type="button" class="btn btn-link">Modifica</button>
                </div>
                <div>
                  <strong>Email:</strong> giulia.bianchi@gmail.com
                </div>
              </div>
            </div>
          </div>
        </fieldset>

        <!-- Form Actions -->
        <div class="form-actions">
          <button type="button" class="btn btn-outline-primary">Indietro</button>
          <button type="submit" name="action" value="save_draft" class="btn btn-outline-secondary">Salva Richiesta</button>
          <button type="submit" name="action" value="save_next" class="btn btn-primary">Salva Avanti</button>
        </div>
      </form>

      <!-- Toast Notification -->
      <div class="toast show" role="alert" aria-live="assertive">
        <div class="toast-body">Richiesta salvata con successo</div>
      </div>
    </div>
  </main>

  <!-- Sidebar (Global pattern) -->
  <!-- Footer (Global) -->
</body>
```

### Key CSS Classes
| Area | Classes |
|------|---------|
| Forms | `form-group`, `form-control`, `form-select`, `form-note`, `form-actions` |
| Fieldsets | `fieldset`, `legend` |
| File Upload | `fileupload`, `fileupload-filename` |
| Cards | `card`, `card-body`, `user-card`, `contacts` |
| Toast | `toast`, `toast.show`, `toast-body`, `toast-container` |
| Buttons | `btn`, `btn-primary`, `btn-outline-primary`, `btn-outline-secondary`, `btn-link` |

### Interactive Patterns
- **Geolocation:** "Usa la tua posizione" → `navigator.geolocation` API
- **Character Counter:** Textarea enforces `maxlength="200"` with live counter
- **Progressive Disclosure:** "Mostra tutto" expands hidden contact fields; "Modifica" toggles inline edit
- **Draft Persistence:** Dual submit — `save_draft` (persist) vs `save_next` (persist + advance)
- **Toast Notification:** Non-blocking, auto-dismissing success message

---

## Page 4: Step 3 — Summary Review

**URL:** `segnalazione-03-riepilogo.html`
**Purpose:** Review all entered data before final submission, with inline edit capability

### Body Structure
```html
<body>
  <!-- Skip Links -->
  <!-- Header (Global) -->

  <main id="main-content" class="it-main-wrapper">
    <div class="container">

      <!-- Breadcrumb (Global) -->

      <div class="it-header">
        <h1>SEGNALAZIONE DISSERVIZIO</h1>
      </div>

      <!-- Stepper (Step 3/3) -->
      <section class="it-stepper">
        <ol class="stepper-content">
          <li class="stepper-title">Autorizzazioni e condizioni <span class="badge badge-success">Confermato</span></li>
          <li class="stepper-title">Dati di segnalazione <span class="badge badge-success">Confermato</span></li>
          <li class="stepper-title active">Riepilogo <span class="badge badge-info">Attivo</span></li>
        </ol>
        <span class="stepper-counter">3/3</span>
      </section>

      <!-- Warning Alert -->
      <div class="it-alert alert-warning" role="alert">
        <h2 class="no_toc">Attenzione</h2>
        <p>Le informazioni che hai fornito hanno valore di dichiarazione. Verifica che siano corrette.</p>
      </div>

      <!-- Summary Card: Report Details -->
      <div class="card-wrapper">
        <div class="card">
          <div class="card-header">
            SEGNALAZIONE DISSERVIZIO
            <button class="btn btn-link float-end">Modifica</button>
          </div>
          <div class="card-body">
            <dl class="it-list-wrapper">
              <dt>Indirizzo</dt><dd>Via Solferino - 50100 Firenze (FI)</dd>
              <dt>Tipo di disservizio</dt><dd>Danneggiamento proprietà pubblica</dd>
              <dt>Titolo</dt><dd>Panchina danneggiata</dd>
              <dt>Dettagli</dt><dd>La seduta della panchina risulta inutilizzabile...</dd>
              <dt>Immagini</dt><dd><a href="#">6yhakandsahm413d8da.jpg</a></dd>
            </dl>
          </div>
        </div>
      </div>

      <!-- Summary Card: User Data -->
      <div class="card-wrapper">
        <div class="card">
          <div class="card-header">DATI GENERALI</div>
          <div class="card-body">
            <h3>AUTORE DELLA SEGNALAZIONE</h3>
            <p class="card-text">GIULIA BIANCHI</p>
            <dl class="it-list-wrapper">
              <dt>Codice Fiscale</dt><dd>GLABNC72H25H501Y</dd>
            </dl>
            <h3>CONTATTI</h3>
            <dl class="it-list-wrapper">
              <dt>Telefono</dt><dd>+39 331 1234567</dd>
              <dt>Email</dt><dd>giulia.bianchi@gmail.com</dd>
            </dl>
          </div>
        </div>
      </div>

      <!-- Actions Bar -->
      <div class="actions-wrapper">
        <button class="btn btn-outline-primary">Indietro</button>
        <button class="btn btn-primary">Salva Richiesta</button>
        <button class="btn btn-primary">Salva Invia</button>
        <div class="toast-container">
          <div class="toast show">Richiesta salvata con successo</div>
        </div>
      </div>

      <!-- Terms & Final Submission -->
      <section class="terms-section mt-5">
        <h2>CONTATTA IL COMUNE</h2>
        <ul class="list-unstyled">
          <li><a href="#">Leggi le domande frequenti</a></li>
          <li><a href="#">Richiedi assistenza</a></li>
          <li><a href="tel:050505">Chiama il numero verde 05 0505</a></li>
          <li><a href="#">Prenota appuntamento</a></li>
        </ul>

        <h2 class="mt-4">TERMINI E CONDIZIONI</h2>
        <p>Cliccando su Conferma e invia confermi di aver preso visione dei termini e delle condizioni di servizio.</p>
        <a href="#" class="read-terms">Leggi termini e condizioni</a>

        <div class="form-check mt-3">
          <input type="checkbox" class="form-check-input" id="terms-accept" required>
          <label class="form-check-label" for="terms-accept">Conferma e invia</label>
        </div>
        <button class="btn btn-primary mt-3">Conferma e invia</button>
        <button class="btn btn-outline-danger mt-3">Annulla</button>
      </section>
    </div>
  </main>

  <!-- Footer (Global) -->
</body>
```

### Key CSS Classes
| Area | Classes |
|------|---------|
| Stepper | `it-stepper`, `stepper-content`, `stepper-title`, `stepper-title.active`, `stepper-counter` |
| Alert | `it-alert`, `alert-warning`, `role="alert"`, `no_toc` |
| Cards | `card-wrapper`, `card`, `card-header`, `card-body`, `card-text`, `float-end` |
| Definition Lists | `it-list-wrapper`, `dt`, `dd` |
| Actions | `actions-wrapper`, `terms-section`, `read-terms` |
| Badges | `badge badge-success`, `badge badge-info` |

### Interactive Patterns
- **Inline Edit:** "Modifica" button in card-header returns to Step 2
- **Dual Submission:** "Salva Richiesta" (draft) vs "Salva Invia" (advance)
- **Consent Gate:** Final checkbox required before "Conferma e invia"
- **Cancellation:** "Annulla" button (btn-outline-danger) for complete flow exit

---

## Page 5: Step 4 — Confirmation

**URL:** `segnalazione-04-conferma.html`
**Purpose:** Post-submission confirmation with receipt download and feedback survey

### Body Structure
```html
<body>
  <!-- Skip Links -->
  <!-- Header (Global) -->

  <main id="main-content" class="it-main-wrapper">
    <div class="container">

      <!-- Breadcrumb (Global) -->

      <!-- Confirmation Block -->
      <section class="confirmation-section">
        <div class="alert alert-success" role="alert">
          <h2 class="no_toc">SEGNALAZIONE INVIATA</h2>
        </div>
        <p>Reference: AN4059281</p>
        <p>Email: giulia.bianchi@gmail.com</p>
        <a href="#" class="btn btn-outline-primary">
          <span class="it-clip"></span> Scarica la ricevuta (PDF 100KB)
        </a>
        <a href="#" class="reserved-link">Consulta la richiesta nella tua area riservata</a>
      </section>

      <!-- Related Services -->
      <section class="related-services">
        <h2>SERVIZI CORRELATI</h2>
        <ul class="it-list">
          <li><a href="#">Richiesta appuntamento</a></li>
        </ul>
      </section>

      <!-- Multi-step Feedback Survey -->
      <section class="feedback-survey">
        <form>
          <fieldset>
            <legend>QUANTO È STATO FACILE USARE QUESTO SERVIZIO?</legend>
            <div class="rating-list">
              <!-- 5-star interactive rating -->
            </div>
          </fieldset>

          <fieldset>
            <legend>QUALI SONO STATI GLI ASPETTI CHE HAI PREFERITO? 1/2</legend>
            <!-- Checkbox group: chiarezza, completezza, monitoraggio, assenza problemi, altro -->
          </fieldset>

          <fieldset>
            <legend>DOVE HAI INCONTRATO LE MAGGIORI DIFFICOLTÀ? 1/2</legend>
            <!-- Checkbox group: poco chiaro, incompleto, incerto, problemi tecnici, altro -->
          </fieldset>

          <fieldset>
            <legend>VUOI AGGIUNGERE ALTRI DETTAGLI? 2/2</legend>
            <textarea maxlength="200" class="form-control" placeholder="Inserire massimo 200 caratteri"></textarea>
            <div class="btn-group">
              <button type="button" class="btn btn-secondary">Indietro</button>
              <button type="submit" class="btn btn-primary">Avanti</button>
            </div>
          </fieldset>
        </form>
        <p class="feedback-confirmation">GRAZIE, IL TUO PARERE CI AIUTERÀ A MIGLIORARE IL SERVIZIO!</p>
      </section>
    </div>
  </main>

  <!-- Footer (Global) -->
</body>
```

### Key CSS Classes
| Area | Classes |
|------|---------|
| Confirmation | `confirmation-section`, `alert alert-success`, `no_toc` |
| Download | `btn btn-outline-primary`, `it-clip` |
| Related | `related-services`, `it-list` |
| Survey | `feedback-survey`, `rating-list`, `feedback-confirmation` |
| Stepper Labels | `1/2`, `2/2` step indicators in legend text |

### Interactive Patterns
- **Receipt Download:** PDF generation/link triggered by download button
- **Area Personale Link:** Deep link to user's dashboard with specific report
- **Star Rating:** Hover/click star selection → immediate visual feedback → reveals survey steps
- **Multi-step Survey:** Sequential progression with back/next navigation

---

## Page 6: Personal Dashboard

**URL:** `segnalazione-area-personale.html`
**Purpose:** Logged-in user dashboard with tabs for messages, activities, reports, and payments

### Body Structure
```html
<body>
  <!-- Skip Links -->
  <!-- Header (Global — with user dropdown showing logged-in state) -->

  <main id="main-content" class="it-main-wrapper">
    <div class="container">

      <!-- Breadcrumb (Global) -->
      <!-- Breadcrumb: Home → Area personale -->

      <!-- User Profile Section -->
      <section class="it-user-profile-section pt-4">
        <div class="profile-header d-flex align-items-center gap-3">
          <div class="avatar">
            <img src="..." alt="GIULIA ROSSI">
          </div>
          <div>
            <h1 class="mb-0">GIULIA ROSSI</h1>
            <p class="text-muted mb-0">CF: GLARSS72H25H501Y</p>
          </div>
        </div>

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs it-tab-list" role="tablist">
          <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#scrivania">Scrivania</button>
          </li>
          <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#messaggi">Messaggi</button>
          </li>
          <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#attivita">Attività</button>
          </li>
          <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#servizi">Servizi</button>
          </li>
        </ul>
      </section>

      <!-- Tab Content -->
      <div class="tab-content it-tab-content pt-4">

        <!-- Tab: Scrivania (default active) -->
        <div class="tab-pane fade show active" id="scrivania" role="tabpanel">
          <aside class="it-page-index mb-4">
            <h2 class="visually-hidden">Indice della pagina</h2>
            <ul class="link-list-wrapper">
              <li><a href="#ultimi-messaggi">Ultimi messaggi</a></li>
              <li><a href="#ultime-attivita">Ultime attività</a></li>
            </ul>
          </aside>

          <section id="ultimi-messaggi" class="it-list-wrapper mb-5">
            <h2>ULTIMI MESSAGGI</h2>
            <ul class="it-list">
              <li>
                <a href="#">
                  <div class="it-right-zone">
                    <span class="data">05/04/2022</span>
                    <span class="badge bg-success">Categoria:</span>
                  </div>
                  <span class="text">RICHIESTA SERVIZIO MENSA SCOLASTICA...</span>
                </a>
              </li>
            </ul>
            <a class="btn btn-link" href="#">Vedi altri messaggi</a>
          </section>

          <section id="ultime-attivita" class="it-list-wrapper mb-5">
            <h2>ULTIME ATTIVITÀ</h2>
            <ul class="it-list">
              <li>
                <a href="#">
                  <span class="text">SEGNALAZIONE DISSERVIZIO</span>
                  <span class="data">15/04/2022</span>
                </a>
              </li>
            </ul>
            <a class="btn btn-link" href="#">Vedi altre attività</a>
          </section>
        </div>

        <!-- Tab: Pratiche -->
        <div class="tab-pane fade" id="pratiche" role="tabpanel">
          <aside class="it-page-index mb-4">
            <ul class="link-list-wrapper">
              <li><a href="#lista-pratiche">Pratiche</a></li>
              <li><a href="#lista-pagamenti">Pagamenti</a></li>
            </ul>
          </aside>

          <section id="lista-pratiche">
            <!-- Sort/Filter Controls -->
            <div class="it-sort-wrapper d-flex gap-3 mb-3">
              <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal">Filtra</button>
              <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle">Ordina</button>
              </div>
            </div>

            <!-- Report Cards -->
            <ul class="it-list">
              <li class="it-card">
                <div class="card-wrapper">
                  <a href="#">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Segnalazione disservizio</h5>
                        <span class="badge bg-warning">In attesa</span>
                        <p class="card-text">20/03/2022 | Pratica: AN4059281</p>
                        <ul class="it-link-list">
                          <li><a href="#">Scheda servizio Servizio non digitale</a></li>
                          <li><a href="#">Ricevuta pagamento (PDF 80KB)</a></li>
                        </ul>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="d-flex gap-2 mt-2">
                  <button class="btn btn-sm btn-primary">Perfeziona la richiesta</button>
                </div>
                <!-- Action Dropdown per card -->
                <div class="dropdown">
                  <button class="btn btn-sm btn-outline-secondary dropdown-toggle">Azione</button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Azione 1</a></li>
                    <li><a class="dropdown-item" href="#">Azione 2</a></li>
                    <li><a class="dropdown-item" href="#">Azione 3</a></li>
                  </ul>
                </div>
              </li>
            </ul>
            <a class="btn btn-link" href="#">Vedi altre pratiche</a>
          </section>
        </div>

        <!-- Tab: Pagamenti (similar to Pratiche, with "Pagato" badge) -->
        <div class="tab-pane fade" id="pagamenti" role="tabpanel">...</div>
      </div>

      <!-- Contact Section -->
      <section class="it-contact-section mt-5 p-4 bg-light">
        <h3>CONTATTA IL COMUNE</h3>
        <ul class="it-list">
          <li><a href="#">Leggi le domande frequenti</a></li>
          <li><a href="#">Richiedi assistenza</a></li>
          <li><a href="tel:050505">Chiama il numero verde 05 0505</a></li>
          <li><a href="#">Prenota appuntamento</a></li>
        </ul>
      </section>

      <!-- Alert Banner -->
      <section class="it-alert-section mt-4">
        <div class="alert alert-info" role="alert">
          <h4 class="alert-heading">15/03/2022 - ISCRIZIONE ALLA SCUOLA DELL'INFANZIA</h4>
          <p>GRADUATORIA 2022/23...</p>
          <a href="#" class="btn btn-link">Graduatoria Scuola dell'infanzia...</a>
        </div>
      </section>

      <!-- Search Bar -->
      <section class="it-searchbar-wrapper my-5">
        <form role="search" class="form-group">
          <label for="search-input">Cerca nel sito</label>
          <div class="input-group">
            <input type="search" id="search-input" class="form-control" placeholder="Cerca">
            <button type="submit" class="btn btn-primary">Cerca</button>
          </div>
        </form>
        <div class="suggested-links mt-3">
          <h5>FORSE STAVI CERCANDO</h5>
          <ul class="list-inline">
            <li class="list-inline-item">
              <a href="#" class="badge bg-secondary">Rilascio Carta Identità Elettronica (CIE)</a>
            </li>
            <!-- More suggestions -->
          </ul>
        </div>
      </section>
    </div>
  </main>

  <!-- Footer (Global) -->
</body>
```

### Key CSS Classes
| Area | Classes |
|------|---------|
| Profile | `it-user-profile-section`, `profile-header`, `avatar`, `d-flex`, `align-items-center`, `gap-3` |
| Tabs | `nav nav-tabs it-tab-list`, `tab-content it-tab-content`, `tab-pane fade show active` |
| Lists | `it-list-wrapper`, `it-list`, `it-card`, `it-right-zone`, `badge bg-success`, `badge bg-warning` |
| Sort/Filter | `it-sort-wrapper`, `d-flex`, `gap-3`, `data-bs-toggle="modal"` |
| Contact | `it-contact-section`, `bg-light`, `p-4`, `mt-5` |
| Alert | `it-alert-section`, `alert alert-info`, `alert-heading` |
| Search | `it-searchbar-wrapper`, `form-group`, `input-group`, `suggested-links`, `list-inline`, `list-inline-item` |

### Interactive Patterns
- **Tabbed Interface:** Bootstrap tabs with `data-bs-toggle="tab"` for Scrivania/Messaggi/Attività/Servizi
- **Filter Modal:** `data-bs-toggle="modal"` opens filter dialog
- **Sort Dropdown:** Dropdown-based sorting options
- **Load More:** "Vedi altri messaggi/pratiche/pagamenti/attività" pagination links
- **Status Badges:** `badge bg-success` (completed), `badge bg-warning` (in attesa), `badge bg-secondary` (other)
- **Action Dropdowns:** Per-card action menus (Azione 1, 2, 3)

---

## Page 7: Report Listing

**URL:** `segnalazioni-elenco.html`
**Purpose:** List and map view of all municipality reports, filterable by type

### Body Structure
```html
<body>
  <!-- Skip Links -->
  <!-- Header (Global) -->

  <main id="main-content" class="it-main-wrapper">
    <div class="container">

      <!-- Breadcrumb (Global) -->
      <!-- Breadcrumb: Home → Elenco segnalazioni -->

      <!-- Page Title -->
      <h1>ELENCO SEGNALAZIONI</h1>

      <!-- Stats Summary -->
      <section class="stats-summary">
        <!-- Count by type/category -->
      </section>

      <!-- Filter Bar -->
      <div class="filter-bar">
        <select class="form-select" aria-label="Filtra per categoria">
          <!-- Category options -->
        </select>
        <div class="view-toggle">
          <button class="btn btn-outline-primary active">Elenco</button>
          <button class="btn btn-outline-primary">Mappa</button>
        </div>
        <span class="result-counter">X segnalazioni trovate</span>
        <button class="btn btn-link">Rimuovi tutti i filtri</button>
      </div>

      <!-- Report List -->
      <ul class="it-list">
        <li class="it-card">
          <div class="card-wrapper">
            <a href="#">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">[Report Title]</h5>
                  <span class="badge bg-info">[Type Tag]</span>
                  <p class="card-text">[Address]</p>
                  <p class="card-text">[Detail text preview]</p>
                  <div class="image-placeholder">[Image]</div>
                </div>
              </div>
            </a>
          </div>
          <div class="it-card-actions">
            <button class="btn btn-link">Mostra tutto</button>
            <button class="btn btn-link">Modifica</button>
          </div>
        </li>
        <!-- More report cards -->
      </ul>

      <!-- Load More -->
      <div class="load-more">
        <button class="btn btn-outline-primary">Carica altre segnalazioni</button>
      </div>

      <!-- Auth CTA (for non-authenticated users) -->
      <section class="auth-cta">
        <p>Per inviare una segnalazione, accedi alla tua area personale.</p>
        <a href="#" class="btn btn-primary">Accedi all'area personale</a>
      </section>
    </div>
  </main>

  <!-- Feedback Survey (same pattern as other pages) -->
  <!-- Footer (Global) -->
</body>
```

### Key CSS Classes
| Area | Classes |
|------|---------|
| Stats | `stats-summary` |
| Filters | `filter-bar`, `form-select`, `view-toggle`, `result-counter` |
| List | `it-list`, `it-card`, `card-wrapper`, `card-body`, `card-title`, `badge bg-info` |
| Actions | `it-card-actions`, `load-more`, `auth-cta` |

### Interactive Patterns
- **Dynamic Filtering:** Select dropdown filters results; count updates in real-time
- **View Toggle:** Switches between `Elenco` (list) and `Mappa` (map) views
- **Clear Filters:** "Rimuovi tutti i filtri" resets state and count
- **Progressive Disclosure:** "Mostra tutto" / "Modifica" expands inline details per card
- **Infinite Load:** "Carica altre segnalazioni" appends cards without page reload
- **Auth Gate:** CTA block for non-authenticated users

---

## Component Hierarchy Summary

```
Design Comuni Page
├── Accessibility Skip Links (visually-hidden-focusable)
├── Global Header
│   ├── Slim Top Bar (region name, language switcher, auth/login, social icons)
│   ├── Center Brand Bar (municipality title/subtitle, search toggle, burger toggle)
│   └── Main Navigation (navbar-expand-lg, megamenu, topic links, social menu)
├── Breadcrumb Navigation (breadcrumb-container > breadcrumb)
├── Main Content
│   ├── Page Header (H1, status badge, lead text, CTAs, share, utility actions)
│   ├── Content Body (page-specific — varies by page type)
│   │   ├── Detail Page: 2-column layout (content + sticky index nav)
│   │   ├── Form Steps: Stepper wizard + fieldset-based forms
│   │   ├── Summary: Card-based review with inline edit
│   │   ├── Confirmation: Alert success + receipt download + feedback survey
│   │   ├── Dashboard: Tabbed interface with lists and cards
│   │   └── Listing: Filter bar + card list + load more
│   └── Feedback Module (star rating + multi-step survey)
├── Sidebar (contact widget, search, suggested links)
└── Global Footer
    ├── Search + "Forse stavi cercando" suggestions
    ├── Multi-column sitemap (5 columns)
    ├── Contact address block
    ├── Quick links (FAQ, appointment, report, assistance)
    ├── Legal links (privacy, accessibility, transparency)
    └── Social bar + back-to-top button
```

---

## Bootstrap Italia CSS Class Reference

### Layout & Grid
| Class | Purpose |
|-------|---------|
| `container` | Main content wrapper |
| `row` | Flexbox row |
| `col-*`, `col-lg-*`, `col-md-*`, `col-auto` | Responsive columns |
| `d-flex`, `align-items-center`, `gap-2`, `gap-3` | Flexbox utilities |

### Header
| Class | Purpose |
|-------|---------|
| `it-header-wrapper` | Header root |
| `it-header-slim-wrapper` | Top bar |
| `it-header-center-wrapper` | Brand bar |
| `it-header-language-wrapper` | Language dropdown container |
| `it-header-user-wrapper` | Logged-in user dropdown |
| `it-header-brand-wrapper` | Municipality brand |
| `it-header-title-wrapper` | Title + subtitle |
| `it-header-socials-wrapper` | Social icons |
| `it-header-search-wrapper` | Search toggle + collapsible |
| `it-nav-wrapper` | Navigation container |
| `navbar-expand-lg`, `has-megamenu` | Responsive nav + mega menu |
| `it-megamenu`, `it-megamenu-panel` | Mega menu structure |
| `custom-navbar-toggler` | Mobile hamburger |

### Navigation
| Class | Purpose |
|-------|---------|
| `breadcrumb-container` | Breadcrumb wrapper |
| `breadcrumb`, `breadcrumb-item`, `active` | Breadcrumb list |
| `it-page-index` | Sticky page index/TOC |
| `link-list-wrapper`, `link-list` | Link lists |
| `nav`, `nav-tabs`, `nav-item`, `nav-link` | Tab navigation |
| `dropdown`, `dropdown-toggle`, `dropdown-menu`, `dropdown-item` | Dropdowns |

### Content Sections
| Class | Purpose |
|-------|---------|
| `it-main-wrapper` | Main content wrapper |
| `it-page-header` | Page title section |
| `it-page-section` | Content section |
| `it-page-column` | Column in content grid |
| `it-sticky` | Sticky sidebar |
| `it-callout`, `callout-highlight` | Highlighted CTA block |
| `it-tags`, `it-tag-list` | Topic tags |
| `it-attachments` | File attachments |
| `it-related-content` | Related content grid |
| `it-list-wrapper`, `it-list` | Content lists |
| `list-unstyled` | Unstyled list |

### Forms
| Class | Purpose |
|-------|---------|
| `form-group` | Form field wrapper |
| `form-control` | Input/textarea/select |
| `form-select` | Select element |
| `form-check`, `form-check-input`, `form-check-label` | Checkbox/radio |
| `form-note` | Form helper text |
| `form-actions` | Button group wrapper |
| `fileupload`, `fileupload-filename` | File upload |
| `step-form` | Step form wrapper |
| `privacy-text` | Privacy notice text |

### Stepper / Wizard
| Class | Purpose |
|-------|---------|
| `stepper`, `steppers` | Stepper container |
| `steppers-item`, `steppers-item.completed`, `steppers-item.active` | Step items |
| `steppers-progress`, `step-counter`, `stepper-counter` | Progress indicator |
| `stepper-content`, `stepper-title` | Step content/title |
| `badge badge-success`, `badge badge-info` | Step status badges |
| `it-stepper` | Semantic stepper wrapper |

### Cards
| Class | Purpose |
|-------|---------|
| `card`, `card-body`, `card-header`, `card-title`, `card-text`, `card-wrapper` | Card components |
| `user-card` | User profile card |
| `it-card` | List card variant |
| `float-end` | Float right (for edit button) |

### Buttons
| Class | Purpose |
|-------|---------|
| `btn`, `btn-primary`, `btn-secondary` | Primary/secondary buttons |
| `btn-outline-primary`, `btn-outline-secondary`, `btn-outline-danger` | Outlined variants |
| `btn-link` | Link-style button |
| `btn-sm` | Small button |
| `btn-action` | Form action button |

### Feedback & Notifications
| Class | Purpose |
|-------|---------|
| `alert`, `alert-success`, `alert-warning`, `alert-info` | Alert banners |
| `alert-heading` | Alert heading |
| `toast`, `toast.show`, `toast-body`, `toast-container` | Toast notifications |
| `feedback-success`, `feedback-confirmation` | Survey feedback messages |
| `role="alert"`, `aria-live="assertive"` | ARIA live regions |

### Tabs
| Class | Purpose |
|-------|---------|
| `tab-content`, `tab-pane`, `fade`, `show`, `active` | Tab panes |
| `it-tab-list`, `it-tab-content` | Tab styling |

### Footer
| Class | Purpose |
|-------|---------|
| `it-footer-wrapper`, `it-footer` | Footer root |
| `it-footer-bottom-wrapper` | Bottom section |
| `it-footer-socials-list` | Social links |
| `it-footer-legal-wrapper` | Legal links |
| `it-footer-copy` | Copyright/meta |
| `back-to-top` | Scroll-to-top button |
| `footer-search`, `footer-cols`, `col` | Footer layout |

### Utility
| Class | Purpose |
|-------|---------|
| `visually-hidden-focusable` | Accessible skip links |
| `sr-only` | Screen reader only (legacy) |
| `text-muted`, `small`, `lead` | Typography |
| `mb-30`, `mb-4`, `mb-5`, `mt-3`, `mt-4`, `mt-5`, `my-5`, `pt-4`, `p-3`, `p-4` | Spacing |
| `has-bg-grey`, `bg-light` | Background colors |
| `no_toc` | Exclude from TOC generation |
| `lora` | Lora font family |
| `t-primary` | Text color primary |
| `bg-white` | White background |

---

## Interactive Pattern Catalog

| Pattern | Trigger | Behavior |
|---------|---------|----------|
| **Skip Navigation** | Focus on skip link | Jumps to `#main-content` or `#footer` |
| **Mega Menu** | Hover/focus on nav item | Expands categorized topic panel |
| **Search Toggle** | Click "Cerca" button | Collapses/expands search input |
| **Mobile Nav** | Click burger icon | Slide-out navigation drawer |
| **Stepper Navigation** | Form submission | Visual progress (1/3, 2/3, 3/3) with completed/active states |
| **Scroll Spy** | Scroll page | Highlights active section in sidebar TOC |
| **Star Rating** | Click star | Immediate visual feedback → reveals survey |
| **Multi-step Survey** | Click "Avanti" / "Indietro" | Shows/hides fieldsets with step counter |
| **Character Counter** | Type in textarea | Live count against `maxlength="200"` |
| **File Upload Preview** | Select file | Shows filename inline |
| **Draft Save** | Click "Salva Richiesta" | Persists form state without advancing |
| **Toast Notification** | Form save action | Non-blocking, auto-dismissing success message |
| **Inline Edit** | Click "Modifica" in summary | Returns to previous step with data preserved |
| **Tab Switching** | Click tab | Bootstrap tab with fade transition |
| **Filter + Sort** | Select/filter | Real-time result count update |
| **View Toggle** | Click Elenco/Mappa | Switches list ↔ map visualization |
| **Load More** | Click "Carica altre" | Appends items without page reload |
| **Progressive Disclosure** | Click "Mostra tutto" | Expands hidden content inline |
| **Dropdown Actions** | Click "Azione" | Per-item action menu |
| **Receipt Download** | Click download link | PDF generation/link |
| **Language Switch** | Click ITA/ENG | Locale toggle |
| **Back to Top** | Click scroll-to-top | Smooth scroll to page top |
| **Geolocation** | Click "Usa la tua posizione" | Browser geolocation API fills location field |
| **Consent Gate** | Unchecked checkbox | Disables "Avanti" / "Conferma e invia" button |

---

## Multi-Step Form Flow Map

```
segnalazione-dettaglio.html (Service Detail)
    │
    └─ [Segnala disservizio] → segnalaazione-01-privacy.html (Step 1/3)
                                    │
                                    └─ [Avanti] → segnalaazione-02-dati.html (Step 2/3)
                                                      │
                                                      ├─ [Indietro] → (back to Step 1)
                                                      │
                                                      └─ [Salva Avanti] → segnalaazione-03-riepilogo.html (Step 3/3)
                                                                              │
                                                                              ├─ [Indietro] → (back to Step 2)
                                                                              ├─ [Modifica] → (back to Step 2)
                                                                              ├─ [Salva Richiesta] → (draft, stay)
                                                                              │
                                                                              └─ [Conferma e invia] → segnalaazione-04-conferma.html
                                                                                                          │
                                                                                                          └─ [Feedback Survey] → (in-page)
```

---

## Notes for Tailwind Migration

1. **No Bootstrap JS dependencies** — replace `data-bs-toggle`, `data-bs-target` with Alpine.js or vanilla JS
2. **Grid system** — Bootstrap's `col-lg-*` maps directly to Tailwind's `lg:col-span-*`
3. **Spacing** — Bootstrap's `mt-5`, `mb-3`, `p-4` have direct Tailwind equivalents
4. **Typography** — `lead`, `text-muted`, `small` → Tailwind's `text-lg`, `text-gray-500`, `text-sm`
5. **Badges** — `badge bg-success` → `inline-block px-2 py-1 text-xs font-semibold text-white bg-green-600 rounded`
6. **Cards** — Bootstrap's card component → Tailwind's `bg-white rounded-lg shadow-md overflow-hidden`
7. **Forms** — `form-control` → `block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500`
8. **Stepper** — Custom implementation needed; no direct Tailwind equivalent
9. **Mega Menu** — Custom implementation; replace Bootstrap's collapse with Alpine.js `x-show`
10. **Toast** — Replace Bootstrap toast with Alpine.js or custom Tailwind component
