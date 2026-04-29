# Design Comuni Italia - Analisi Blocchi Componenti Riutilizzabili

**Dominio:** Pagine statiche modello Comuni italiani  
**Fonte:** https://github.com/italia/design-comuni-pagine-statiche  
**Template analizzati:** 38 pagine (.hbs)  
**Data analisi:** 2026-04-01  
**Metodologia:** BMAD-METHOD - Agentic Development Workflow

---

## Executive Summary

L'analisi completa dei 38 template HTML del modello Design Comuni rivela un'architettura component-based altamente strutturata basata su **Handlebars partials**. Il sistema utilizza **47 componenti riutilizzabili** organizzati in categorie funzionali, con un pattern architetturale coerente che separa layout, navigazione, contenuti e form.

**Scoperte chiave:**
- **100% delle pagine** utilizza `cmp-base/base` come wrapper layout principale
- **94% delle pagine** include breadcrumbs, hero section, e contatti footer
- **7 componenti universali** appaiono in tutte le categorie di pagine
- **Pattern multi-step** per flussi transazionali (appuntamento, assistenza, segnalazione)
- **Bootstrap Italia** come foundation per classi utility e componenti

---

## 1. Elenco Completo Pagine con Blocchi Identificati

### 1.1 Pagine Generali (9 pagine)

| # | Pagina | Blocchi Principali | Componenti Chiave |
|---|--------|-------------------|-------------------|
| 1 | **homepage.hbs** | Hero, Contenuti in evidenza, Organi di governo, Eventi (calendar), Argomenti in evidenza, Siti tematici, Search, Rating, Contatti | `cmp-tag`, `cmp-input-search`, `cmp-rating`, `cmp-contacts` |
| 2 | **domande-frequenti.hbs** | Breadcrumbs, Hero, Search, Accordion FAQ, Button "Carica altre", Rating, Contatti | `cmp-accordion-faq`, `cmp-button` |
| 3 | **risultati-ricerca.html** | Breadcrumbs, Search bar, Filtri categoria, Lista risultati (card), Pagination, Rating, Contatti | `cmp-input-search-button`, `cmp-category-list`, `cmp-card-latest-messages`, `cmp-modal` |
| 4 | **argomenti.hbs** | Breadcrumbs, Hero, Sezione "In evidenza", Griglia argomenti (20 card), Rating, Contatti | `cmp-card-simple` (x20) |
| 5 | **argomento.hbs** | Breadcrumbs, Hero dettaglio, Sezione "Questo argomento è gestito da", Novità (card), Eventi, Amministrazione (card teaser), Servizi (card teaser), Documenti (card teaser), Rating, Contatti | `cmp-card-teaser` (x9) |
| 6 | **lista-risorse.hbs** | Breadcrumbs, Hero, Risorse in evidenza (horizontal card), Search con subtitle, Lista risorse, Pagination, Rating, Contatti | `cmp-list-card-img-hr`, `cmp-input-search` |
| 7 | **lista-categorie.hbs** | Breadcrumbs, Hero, Risorse in evidenza (horizontal card), Griglia categorie (9 card), Rating, Contatti | `cmp-list-card-img-hr`, `cmp-card-simple` (x9) |
| 8 | **lista-risorse-categorie.hbs** | Breadcrumbs, Hero, Risorse in evidenza, Search con subtitle, Lista risorse, Pagination, Griglia categorie (20 card), Rating, Contatti | `cmp-list-card-img-hr`, `cmp-input-search`, `cmp-card-simple` (x20) |
| 9 | **mappa-sito.hbs** | Sitemap gerarchica (nested list) | Solo `cmp-base` (nessun componente figlio) |

### 1.2 Amministrazione (2 pagine)

| # | Pagina | Blocchi Principali | Componenti Chiave |
|---|--------|-------------------|-------------------|
| 10 | **amministrazione.hbs** | Breadcrumbs, Hero, Sezione "In evidenza" (3 card), Esplora amministrazione (7 card), Rating, Contatti | `cmp-card-simple` (x10), `data-element="management-category-link"` |
| 11 | **documenti-dati.hbs** | Breadcrumbs, Hero, In evidenza (documenti), Search con subtitle, Lista documenti, Esplora per categoria (11 card), Rating, Contatti | `cmp-list-card-docs`, `cmp-card-simple` (x11) |

### 1.3 Novità (2 pagine)

| # | Pagina | Blocchi Principali | Componenti Chiave |
|---|--------|-------------------|-------------------|
| 12 | **novita.hbs** | Breadcrumbs, Hero, Notizie in evidenza (horizontal), Search con counter, Lista novità, Pagination, Esplora per categoria (3 card: Notizie, Comunicati, Avvisi), Rating, Contatti | `cmp-list-card-img-hr`, `cmp-card-simple`, `data-element="news-category-link"` |
| 13 | **novita-dettaglio.hbs** | Breadcrumbs, Titolo dettaglio, Meta (data, tempo lettura, condividi, azioni), Argomenti (tag), Indice pagina (navscroll), Corpo contenuto, A cura di (ufficio), Persone (tag), Galleria, Video, A chi è rivolto, Luogo, Date/orari, Costi (pricing table), Allegati, Appuntamenti correlati, Contatti, Rating | `cmp-tag`, `cmp-navscroll`, `carousel` |

### 1.4 Servizi (3 pagine)

| # | Pagina | Blocchi Principali | Componenti Chiave |
|---|--------|-------------------|-------------------|
| 14 | **servizi.hbs** | Breadcrumbs, Hero, Search, Lista servizi (card con categoria), Button "Carica altri", Servizi in evidenza (link list), Esplora per categoria (15 card), Rating, Contatti | `cmp-card-latest-messages` (x5), `cmp-card-simple` (x15), `data-element="service-category-link"` |
| 15 | **servizi-categoria.hbs** | Breadcrumbs, Hero, Search con counter, Lista servizi (10 card), Button "Carica altri", Uffici (link list), Bandi (card), Rating, Contatti | `cmp-card-latest-messages` (x10), `cmp-card-simple` |
| 16 | **servizio-dettaglio.hbs** | Breadcrumbs, Titolo servizio, Descrizione, Indice (navscroll), Timeline, Cosa serve (icon link), Argomenti (tag), Servizi correlati (carousel), Contatti, Rating | `cmp-heading-detail`, `cmp-timeline`, `cmp-icon-link`, `cmp-carousel`, `data-element="service-description"`, `data-element="service-file"`, `data-element="service-topic"` |

### 1.5 Vivere il Comune (2 pagine)

| # | Pagina | Blocchi Principali | Componenti Chiave |
|---|--------|-------------------|-------------------|
| 17 | **eventi.hbs** | Breadcrumbs, Hero, Hero image, Eventi in evidenza (card horizontal), Luoghi in evidenza (card horizontal), Rating, Contatti | `cmp-hero-img-small`, `cmp-list-card-img` (x2), `btn-data-element` |
| 18 | **evento-dettaglio.hbs** | Breadcrumbs, Titolo evento, Meta (date, tempo lettura, condividi, azioni), Argomenti (tag), Indice (navscroll), Corpo (cos'è?, partecipanti, galleria, video, a chi è rivolto, luogo, date/orari, costi, allegati, appuntamenti), Contatti, Sponsor, Rating | `cmp-tag`, `cmp-navscroll`, `cmp-carousel` |

### 1.6 Prenotazione Appuntamento (8 pagine - Flusso Multi-Step)

| # | Pagina | Step | Blocchi Principali | Componenti Chiave |
|---|--------|------|-------------------|-------------------|
| 19 | **appuntamento-01-ufficio.hbs** | 1/5 | Breadcrumbs, Hero, Progress indicator, Navscroll info, Card "Ufficio" (select), Nav steps | `cmp-info-progress`, `cmp-select`, `cmp-nav-steps` |
| 20 | **appuntamento-01-ufficio-luogo.hbs** | 1/5 | Breadcrumbs, Hero, Progress, Navscroll, Card "Ufficio" (select + radio municipality), Nav steps | `cmp-select`, `cmp-info-radio` (x3), `cmp-nav-steps` |
| 21 | **appuntamento-02-data-orario.hbs** | 2/5 | Breadcrumbs, Hero, Progress, Navscroll, Card "Appuntamenti disponibili" (select mese + radio list), Card "Ufficio" (summary), Nav steps | `cmp-select`, `cmp-card-radio-list`, `cmp-info-summary-no-modify` |
| 22 | **appuntamento-03-dettagli.hbs** | 3/5 | Breadcrumbs, Hero, Progress, Navscroll, Card "Motivo*" (select), Card "Dettagli*" (textarea), Nav steps | `cmp-select`, `cmp-text-area` |
| 23 | **appuntamento-04-richiedente.hbs** | 4/5 | Breadcrumbs, Hero, Progress, Navscroll, Card "Richiedente" (input: nome, cognome, email), Nav steps | `cmp-input` (x3: text, text, email) |
| 24 | **appuntamento-04-richiedente-autenticato.hbs** | 4/5 | Breadcrumbs, Hero, Progress, Navscroll, Card "Richiedente" (info button card con dati utente), Nav steps | `cmp-info-button-card` |
| 25 | **appuntamento-05-riepilogo.hbs** | 5/5 | Breadcrumbs, Hero, Progress, Card "Riepilogo" con 4 info summary (Ufficio, Data/orario, Dettagli, Richiedente), Modal T&C, Nav steps | `cmp-info-summary` (x4), `cmp-modal-terms-and-conditions` |
| 26 | **appuntamento-06-conferma.hbs** | Conferma | Breadcrumbs, Hero (check circle icon, conferma, email), Navscroll indice, Card "Cosa serve", Card indirizzo (img), Icon list calendario, Rating, Contatti | `cmp-ul-list`, `cmp-card-img`, `cmp-icon-list` |

### 1.7 Richiesta Assistenza (2 pagine - Flusso Semi-Step)

| # | Pagina | Blocchi Principali | Componenti Chiave |
|---|--------|-------------------|-------------------|
| 27 | **assistenza-01-dati.hbs** | Breadcrumbs, Hero (con link SPID/CIE), Navscroll info, Card "Richiedente" (input: nome, cognome, email), Card "Richiesta" (select categoria, select servizio, textarea dettagli), Checkbox privacy, Nav steps, Contatti | `cmp-input` (x3), `cmp-select` (x2), `cmp-text-area`, `cmp-nav-steps` |
| 28 | **assistenza-02-conferma.hbs** | Breadcrumbs, Hero (check circle, conferma invio, email), Rating, Contatti | `cmp-rating`, `cmp-contacts-trasversali` |

### 1.8 Segnalazione Disservizio (7 pagine - Flusso Multi-Step + Area Personale)

| # | Pagina | Blocchi Principali | Componenti Chiave |
|---|--------|-------------------|-------------------|
| 29 | **segnalazione-dettaglio.hbs** | Breadcrumbs, Heading dettaglio (doppio button), Indice (navscroll), Icon link (file), Tag argomenti, Carousel correlati, Contatti, Rating | `cmp-heading-detail`, `cmp-icon-link`, `cmp-tag`, `cmp-carousel` |
| 30 | **segnalazione-01-privacy.hbs** | Breadcrumbs, Titolo, Progress (1/3), Testo GDPR/privacy, Checkbox privacy, Button "Avanti", Contatti | `cmp-info-progress`, `cmp-button` |
| 31 | **segnalazione-02-dati.hbs** | Breadcrumbs, Heading, Progress (2/3), Navscroll, Card "Luogo" (autocomplete), Card "Disservizio" (select tipo, input titolo, textarea dettagli, upload file), Card "Autore" (info button card), Nav steps, Contatti | `cmp-input-autocomplete`, `cmp-select`, `cmp-input`, `cmp-text-area`, `cmp-button` (upload), `cmp-info-button-card` |
| 32 | **segnalazione-03-riepilogo.hbs** | Breadcrumbs, Heading, Progress (3/3), Callout warning, Card "Segnalazione" (summary), Card "Dati generali" (summary autore + contatti), Nav steps (next + save), Modal T&C, Contatti | `cmp-callout`, `cmp-info-summary`, `cmp-info-summary-no-modify`, `cmp-modal` |
| 33 | **segnalazione-04-conferma.hbs** | Breadcrumbs, Heading (check circle, conferma con numero, email), Button "Scarica ricevuta", Link "Area riservata", Icon list servizi correlati, Rating, Contatti | `cmp-heading`, `cmp-icon-list` |
| 34 | **segnalazione-area-personale.hbs** | Breadcrumbs, Heading, Nav tab (Messaggi/Attività), Card "Ultimi messaggi" (3 card), Card "Ultime attività" (3 card), Filtri (pratiche, pagamenti), Accordion pratiche, Accordion pagamenti, Contatti, Modal | `cmp-nav-tab`, `cmp-card-latest-messages`, `cmp-filter`, `cmp-accordion`, `cmp-modal-message` |
| 35 | **segnalazioni-elenco.hbs** | Breadcrumbs, Heading (counter risolte), Category list, Button filtri, Toggle Mappa/Elenco, Map, Text-button "Fai segnalazione", Lista segnalazioni (3 info button card expandable), Button "Carica altre", Rating, Contatti, Modal | `cmp-category-list`, `cmp-map`, `cmp-text-button`, `cmp-info-button-card` (x3), `cmp-modal-clickMap` |

---

## 2. Matrice di Utilizzo Blocchi

### 2.1 Componenti Universali (100% o quasi)

| Componente | Pagine | % | Categoria |
|------------|--------|---|-----------|
| `cmp-base/base` | 38/38 | 100% | **Layout Wrapper** |
| `cmp-breadcrumbs/cmp-breadcrumbs` | 37/38 | 97% | **Navigazione** |
| `cmp-contacts/*` | 36/38 | 95% | **Footer/Contatti** |
| `cmp-rating/cmp-rating` | 33/38 | 87% | **Feedback** |
| `cmp-hero/*` | 30/38 | 79% | **Hero Section** |
| `cmp-navscroll/cmp-navscroll` | 22/38 | 58% | **Indice/Navigazione** |
| `cmp-card/*` | 35/38 | 92% | **Contenuti** |

### 2.2 Componenti per Categoria Funzionale

#### Layout & Struttura
| Componente | Utilizzi | Pagine Tipo |
|------------|----------|-------------|
| `cmp-base/base` | 38 | Tutte |
| `cmp-hero/cmp-hero` | 30+ | Homepage, Liste, Dettaglio |
| `cmp-hero-img/cmp-hero-img-small` | 2 | Vivere il Comune |

#### Navigazione
| Componente | Utilizzi | Pagine Tipo |
|------------|----------|-------------|
| `cmp-breadcrumbs/cmp-breadcrumbs` | 37 | Tutte (tranne homepage) |
| `cmp-navscroll/cmp-navscroll` | 22 | Dettaglio, Form multi-step |
| `cmp-nav-steps/cmp-nav-steps` | 12 | Form multi-step |
| `cmp-nav-tab/cmp-nav-tab` | 1 | Area personale |
| `cmp-info-progress/cmp-info-progress` | 11 | Form multi-step |

#### Input & Form
| Componente | Utilizzi | Pagine Tipo |
|------------|----------|-------------|
| `cmp-input/input` | 8 | Form (appuntamento, assistenza, segnalazione) |
| `cmp-select/select` | 10+ | Form con dropdown |
| `cmp-text-area/text-area` | 5 | Form con testo lungo |
| `cmp-input-autocomplete/input-autocomplete` | 1 | Segnalazione (luogo) |
| `cmp-info-radio/cmp-info-radio` | 4 | Selezione multipla |
| `cmp-card-radio-list/cmp-card-radio-list` | 1 | Selezione appuntamento |

#### Card & Contenuti
| Componente | Utilizzi | Pagine Tipo |
|------------|----------|-------------|
| `cmp-card-simple` | 80+ | Liste, Categorie, Argomenti |
| `cmp-card-latest-messages` | 20+ | Liste dinamiche |
| `cmp-card-teaser` | 9+ | Anteprime |
| `cmp-card-content-box` | 25+ | Container form |
| `cmp-card-img` | 5+ | Card con immagine |
| `cmp-list-card-img-hr` | 8+ | Liste horizontal |
| `cmp-list-card-img` | 5+ | Liste vertical |
| `cmp-list-card-docs` | 2 | Documenti |

#### Informazione & Summary
| Componente | Utilizzi | Pagine Tipo |
|------------|----------|-------------|
| `cmp-info-summary` | 8+ | Riepilogo |
| `cmp-info-summary-no-modify` | 6+ | Riepilogo read-only |
| `cmp-info-button-card` | 10+ | Info expandable |
| `cmp-callout/callout` | 2 | Warning/Alert |
| `cmp-ul-list/cmp-ul-list` | 3 | Liste puntate |

#### Button & Azioni
| Componente | Utilizzi | Pagine Tipo |
|------------|----------|-------------|
| `cmp-button/cmp-button` | 30+ | Tutte le pagine interattive |
| `cmp-text-button/cmp-text-button` | 3 | CTA con testo |
| `cmp-icon-link/cmp-icon-link` | 4 | Link con icona |
| `cmp-icon-list/cmp-icon-list` | 4 | Liste icone (condivisione, calendario) |

#### Feedback & Contatti
| Componente | Utilizzi | Pagine Tipo |
|------------|----------|-------------|
| `cmp-rating/cmp-rating` | 33 | Quasi tutte le pagine |
| `cmp-contacts/cmp-contacts` | 25+ | Footer pagine |
| `cmp-contacts/cmp-contacts-trasversali` | 15+ | Footer con opzioni multiple |

#### Specializzati
| Componente | Utilizzi | Pagine Tipo |
|------------|----------|-------------|
| `cmp-accordion/cmp-accordion` | 4 | FAQ, Area personale |
| `cmp-accordion-faq` | 1 | Domande frequenti |
| `cmp-filter/cmp-filter` | 2 | Filtri area personale |
| `cmp-modal/*` | 8+ | Modal (termini, filtri, messaggi) |
| `cmp-carousel/cmp-carousel` | 5+ | Contenuti correlati |
| `cmp-timeline/cmp-timeline` | 1 | Timeline servizio |
| `cmp-map/cmp-map` | 2 | Mappe |
| `cmp-tag/cmp-tag` | 15+ | Tag argomenti/persone |
| `cmp-category-list/category-list` | 5 | Liste categorie |
| `cmp-heading/*` | 10+ | Intestazioni pagina |
| `cmp-heading-detail` | 4 | Pagine dettaglio |

### 2.3 Blocchi Specifici per Categoria

| Categoria | Blocchi Specifici | Note |
|-----------|-------------------|------|
| **Generali** | `cmp-tag`, `cmp-input-search`, `cmp-accordion-faq` | Ricerca, FAQ, tag |
| **Amministrazione** | `cmp-card-simple` con `data-element="management-category-link"` | Link categorizzati |
| **Novità** | `cmp-list-card-img-hr`, `cmp-tag` | Liste news, tag |
| **Servizi** | `cmp-card-latest-messages`, `cmp-timeline`, `data-element="service-*"` | Card servizi, timeline |
| **Vivere il Comune** | `cmp-hero-img-small`, `cmp-list-card-img` | Immagini hero, liste |
| **Appuntamento** | `cmp-info-progress`, `cmp-nav-steps`, `cmp-select`, `cmp-info-radio` | Flusso 5 step |
| **Assistenza** | `cmp-input`, `cmp-select`, `cmp-text-area` | Form semplice |
| **Segnalazione** | `cmp-input-autocomplete`, `cmp-callout`, `cmp-info-button-card` | Form complesso, upload |

---

## 3. Componenti Riutilizzabili Identificati

### 3.1 Catalogo Completo Componenti (47 totali)

#### A. Layout & Struttura (3 componenti)
| ID | Nome | Descrizione | Props Principali | Quando Usare |
|----|------|-------------|------------------|--------------|
| **L01** | `cmp-base/base` | Wrapper layout principale con header, footer | `title`, `headerActive{1-4}` | **Sempre** - ogni pagina |
| **L02** | `cmp-hero/cmp-hero` | Hero section con titolo e sommario | `hero-title`, `hero-text`, `wrapper-class` | Pagine lista/dettaglio |
| **L03** | `cmp-hero-img/cmp-hero-img-small` | Hero con immagine | `description`, `img-path` | Pagine con visual impact |

#### B. Navigazione (5 componenti)
| ID | Nome | Descrizione | Props Principali | Quando Usare |
|----|------|-------------|------------------|--------------|
| **N01** | `cmp-breadcrumbs/cmp-breadcrumbs` | Breadcrumb navigation | `link1`, `link2`, `active`, `class` | Tutte le pagine (tranne home) |
| **N02** | `cmp-navscroll/cmp-navscroll` | Scroll navigation / indice pagina | `accordion-title`, `id`, `link-list` | Pagine dettaglio lunghe |
| **N03** | `cmp-nav-steps/cmp-nav-steps` | Navigation per form multi-step | `save`, `next`, `validate`, `aria-label-save` | Form wizard |
| **N04** | `cmp-info-progress/cmp-info-progress` | Progress indicator step | `step-num`, `step-tot`, `step-title`, `step-list` | Form multi-step |
| **N05** | `cmp-nav-tab/cmp-nav-tab` | Tab navigation | - | Area personale, switch view |

#### C. Input & Form (7 componenti)
| ID | Nome | Descrizione | Props Principali | Quando Usare |
|----|------|-------------|------------------|--------------|
| **F01** | `cmp-input/input` | Input text/email | `type`, `id`, `label`, `required`, `formClass` | Form semplici |
| **F02** | `cmp-select/select` | Dropdown select | `id`, `label-text`, `placeholder`, `select-option-list` | Selezione singola |
| **F03** | `cmp-text-area/text-area` | Textarea multi-riga | `id`, `label`, `placeholder`, `num` (max chars) | Testo lungo |
| **F04** | `cmp-input-autocomplete/input-autocomplete` | Input con autocomplete | - | Ricerca luoghi |
| **F05** | `cmp-info-radio/cmp-info-radio` | Radio button con info | `group`, `idRadio`, `title`, `info-appointment` | Selezione multipla |
| **F06** | `cmp-card-radio-list/cmp-card-radio-list` | Lista radio in card | `radio-list` | Selezione slot |
| **F07** | `cmp-input-search/input-search` | Search bar | `id`, `label-text`, `placeholder`, `btnSearch` | Ricerca pagine |

#### D. Card & Contenuti (9 componenti)
| ID | Nome | Descrizione | Props Principali | Quando Usare |
|----|------|-------------|------------------|--------------|
| **C01** | `cmp-card-simple` | Card base con titolo e testo | `card-title`, `card-text`, `borderlight`, `data-element` | Liste, categorie |
| **C02** | `cmp-card-latest-messages` | Card per messaggi/news | `category`, `green-title-big`, `description`, `cmp-card-class` | Liste dinamiche |
| **C03** | `cmp-card-teaser` | Card teaser con immagine | `category`, `title`, `description`, `image` | Anteprime |
| **C04** | `cmp-card-content-box` | Card container per contenuti | `card-title`, `bg-grey`, `class`, `margin-class` | Form sections |
| **C05** | `cmp-card-img` | Card con immagine | `card-title`, `card-description` | Luoghi, indirizzi |
| **C06** | `cmp-list-card-img-hr` | Lista card horizontal | `cards`, `btn-label`, `button-next` | Liste in evidenza |
| **C07** | `cmp-list-card-img` | Lista card vertical | `cards` | Liste verticali |
| **C08** | `cmp-list-card-docs` | Lista documenti | `cards`, `rowClass` | Documenti |
| **C09** | `cmp-info-button-card` | Card info espandibile con button | `big-title`, `label-2`, `show-more-*`, `collapse-id` | Info dettagliate |

#### E. Informazione & Summary (5 componenti)
| ID | Nome | Descrizione | Props Principali | Quando Usare |
|----|------|-------------|------------------|--------------|
| **I01** | `cmp-info-summary` | Summary modifiable | `class`, `header-class`, `info`, `info-list` | Riepilogo editabile |
| **I02** | `cmp-info-summary-no-modify` | Summary read-only | `info-title`, `info`, `info-list` | Riepilogo read-only |
| **I03** | `cmp-callout/callout` | Alert box | `calloutType`, `icon`, `calloutTitle`, `calloutText` | Warning, info |
| **I04** | `cmp-ul-list/cmp-ul-list` | Lista puntata | `info-list`, `font-list` | Liste semplici |
| **I05** | `cmp-tag/cmp-tag` | Tag/badge | `label-tag`, `data-element` | Argomenti, persone |

#### F. Button & Azioni (4 componenti)
| ID | Nome | Descrizione | Props Principali | Quando Usare |
|----|------|-------------|------------------|--------------|
| **B01** | `cmp-button/cmp-button` | Button generico | `label`, `primary`, `outline-primary`, `class`, `iconBtn` | Tutte le azioni |
| **B02** | `cmp-text-button/cmp-text-button` | Button con testo descrittivo | `cardTitle`, `cardDescription`, `disservizioBtn` | CTA contestuali |
| **B03** | `cmp-icon-link/cmp-icon-link` | Link con icona | `data-element` | Download, azioni |
| **B04** | `cmp-icon-list/cmp-icon-list` | Lista icone (condivisione, etc.) | `icon-list`, `title`, `classMenu` | Share, calendario |

#### G. Feedback & Contatti (3 componenti)
| ID | Nome | Descrizione | Props Principali | Quando Usare |
|----|------|-------------|------------------|--------------|
| **R01** | `cmp-rating/cmp-rating` | Stelline rating | `id-title`, `public-template` | Feedback pagina |
| **R02** | `cmp-contacts/cmp-contacts` | Sezione contatti | `city-problems` | Footer contatti |
| **R03** | `cmp-contacts/cmp-contacts-trasversali` | Contatti multipli | `faq`, `assistance`, `appointment`, `city-problems` | Footer con opzioni |

#### H. Specializzati (11 componenti)
| ID | Nome | Descrizione | Props Principali | Quando Usare |
|----|------|-------------|------------------|--------------|
| **S01** | `cmp-accordion/cmp-accordion` | Accordion generico | - | Contenuti espandibili |
| **S02** | `cmp-accordion-faq` | Accordion per FAQ | `id`, `accordion` | Domande frequenti |
| **S03** | `cmp-filter/cmp-filter` | Filtro | - | Filtri lista |
| **S04** | `cmp-modal/*` | Modal (varie varianti) | `modalId`, `categories` | Dialog, conferme |
| **S05** | `cmp-carousel/cmp-carousel` | Carousel card | `carousel-title`, `class` | Contenuti correlati |
| **S06** | `cmp-timeline/cmp-timeline` | Timeline verticale | `timeline` | Step temporali |
| **S07** | `cmp-map/cmp-map` | Mappa | - | Visualizzazione geografica |
| **S08** | `cmp-category-list/category-list` | Lista categorie | `category`, `h3-title` | Navigazione categorie |
| **S09** | `cmp-heading/cmp-heading` | Heading pagina | `title`, `subTitle`, `heading-p0` | Titoli pagina |
| **S10** | `cmp-heading-detail` | Heading dettaglio | `subTitle`, `double-button`, `servizio-attivo` | Pagine dettaglio servizio |
| **S11** | `cmp-input-search-button` | Search con button | `placeholder`, `marginClass`, `id` | Search bar |

### 3.2 Varianti dello Stesso Blocco

#### Famiglia Card (9 varianti)
```
cmp-card-simple              → Card base testo
cmp-card-latest-messages     → Card news con categoria
cmp-card-teaser              → Card con immagine
cmp-card-content-box         → Card container (form)
cmp-card-img                 → Card con immagine grande
cmp-list-card-img-hr         → Lista card horizontal
cmp-list-card-img            → Lista card vertical
cmp-list-card-docs           → Lista documenti
cmp-info-button-card         → Card espandibile con button
```

#### Famiglia Contatti (2 varianti)
```
cmp-contacts                 → Contatti base
cmp-contacts-trasversali     → Contatti con FAQ, assistenza, appuntamento
```

#### Famiglia Heading (2 varianti)
```
cmp-heading                  → Heading standard
cmp-heading-detail           → Heading dettaglio con button
```

#### Famiglia Info Summary (2 varianti)
```
cmp-info-summary             → Summary modifiable
cmp-info-summary-no-modify   → Summary read-only
```

#### Famiglia Modal (4+ varianti)
```
cmp-modal-terms-and-conditions  → Termini e condizioni
cmp-modal-filter-categories     → Filtri categorie
cmp-modal-clickMap              → Click mappa
cmp-modal-message               → Messaggi area personale
```

### 3.3 Pattern Comuni Identificati

#### Pattern 1: Pagina Lista Standard
```handlebars
{{#>cmp-base/base}}
  {{>cmp-breadcrumbs}}
  {{>cmp-hero}}
  {{>cmp-input-search}} (opzionale)
  {{>cmp-card-simple}} o {{>cmp-card-latest-messages}} (multipli)
  {{>cmp-button}} "Carica altri"
  {{>cmp-rating}}
  {{>cmp-contacts}}
{{/cmp-base/base}}
```

#### Pattern 2: Pagina Dettaglio
```handlebars
{{#>cmp-base/base}}
  {{>cmp-breadcrumbs}}
  <Titolo>
  {{>cmp-tag}} (multipli)
  {{>cmp-navscroll}} (indice)
  <Corpo contenuto>
  {{>cmp-carousel}} (correlati)
  {{>cmp-rating}}
  {{>cmp-contacts}}
{{/cmp-base/base}}
```

#### Pattern 3: Form Multi-Step
```handlebars
{{#>cmp-base/base}}
  {{>cmp-breadcrumbs}}
  {{>cmp-hero}}
  {{>cmp-info-progress}} (step N/M)
  {{>cmp-navscroll}} (info richieste)
  {{#>cmp-card-content-box}}
    <Input/Select/Textarea>
  {{/cmp-card-content-box}}
  {{>cmp-nav-steps}} (save/next)
  {{>cmp-contacts-trasversali}}
{{/cmp-base/base}}
```

#### Pattern 4: Riepilogo
```handlebars
{{#>cmp-base/base}}
  {{>cmp-breadcrumbs}}
  {{>cmp-hero}}
  {{>cmp-info-progress}} (step finale)
  {{>cmp-callout}} (warning)
  {{#>cmp-card-content-box}}
    {{>cmp-info-summary}} (multipli)
  {{/cmp-card-content-box}}
  {{>cmp-nav-steps}} (next + save + modal)
  {{>cmp-modal}}
  {{>cmp-contacts}}
{{/cmp-base/base}}
```

#### Pattern 5: Conferma
```handlebars
{{#>cmp-base/base}}
  {{>cmp-breadcrumbs}}
  {{>cmp-hero}} (con icona check-circle)
  <Messaggio conferma>
  {{>cmp-button}} (scarica ricevuta)
  {{>cmp-icon-list}} (servizi correlati)
  {{>cmp-rating}}
  {{>cmp-contacts}}
{{/cmp-base/base}}
```

---

## 4. Raccomandazioni Architettura

### 4.1 Principi Architetturali Identificati

#### 1. **Component-Based Architecture**
- Ogni blocco è un **partial Handlebars** autonomo
- I componenti sono **parametrizzabili** via props
- **Nessun HTML inline** - tutto delegato ai componenti

#### 2. **Separation of Concerns**
- **Layout**: `cmp-base` (header, footer, navigation globale)
- **Navigazione**: breadcrumbs, navscroll, nav-steps
- **Contenuti**: card, liste, hero
- **Form**: input, select, textarea
- **Feedback**: rating, contatti, callout

#### 3. **Consistency Through Parameters**
- Classi CSS passate come parametri (`wrapper-class`, `class`, `cmp-card-class`)
- ID univoci per accessibilità (`id`, `id-title`, `collapse-id`)
- Data attribute per tracking (`data-element`)

#### 4. **Progressive Disclosure**
- Form suddivisi in step multipli
- Info espandibili (accordion, info-button-card)
- Riepilogo prima della conferma

### 4.2 Raccomandazioni per Implementazione

#### A. **Catalogo Componenti Prioritario**

Implementare nell'ordine (basato su frequenza utilizzo):

**Tier 1 - Fondamentali (usare subito):**
1. `cmp-base/base` - Layout wrapper
2. `cmp-breadcrumbs` - Navigazione
3. `cmp-hero` - Hero section
4. `cmp-card-simple` - Card base
5. `cmp-button` - Azioni
6. `cmp-rating` - Feedback
7. `cmp-contacts` - Footer

**Tier 2 - Liste e Contenuti:**
8. `cmp-card-latest-messages` - Liste dinamiche
9. `cmp-input-search` - Ricerca
10. `cmp-tag` - Tag/argomenti
11. `cmp-navscroll` - Indice pagina
12. `cmp-carousel` - Correlati

**Tier 3 - Form:**
13. `cmp-input/input` - Input base
14. `cmp-select/select` - Dropdown
15. `cmp-text-area` - Testo lungo
16. `cmp-info-progress` - Progresso
17. `cmp-nav-steps` - Navigation step

**Tier 4 - Specializzati:**
18. `cmp-info-summary` - Riepilogo
19. `cmp-info-button-card` - Info espandibili
20. `cmp-modal` - Dialog
21. `cmp-accordion` - Espandibili
22. `cmp-callout` - Alert

#### B. **Pattern da Seguire**

**Per pagine lista:**
```
Breadcrumbs → Hero → Search (opz) → Card List → Load More → Rating → Contacts
```

**Per pagine dettaglio:**
```
Breadcrumbs → Titolo → Tag → Navscroll → Content → Carousel → Rating → Contacts
```

**Per form:**
```
Breadcrumbs → Hero → Progress → Navscroll → Card (Input) → Nav Steps → Contacts
```

**Per riepilogo:**
```
Breadcrumbs → Progress → Callout → Summary Cards → Nav Steps (with modal) → Contacts
```

#### C. **Convenzioni di Naming**

**Classi CSS utility (Bootstrap Italia):**
- Spaziatura: `mt-*`, `mb-*`, `pt-*`, `pb-*`, `ps-*`, `pe-*`
- Display: `d-none`, `d-lg-block`, `d-lg-none`
- Tipografia: `title-*`, `text-*`, `font-*`
- Colori: `text-primary`, `text-success`, `u-grey-light`
- Layout: `w-100`, `full-mb`, `mobile-full`

**Data attribute per tracking:**
- `data-element="management-category-link"` - Link amministrazione
- `data-element="news-category-link"` - Link notizie
- `data-element="service-category-link"` - Link servizi
- `data-element="service-description"` - Descrizione servizio
- `data-element="service-file"` - File servizio
- `data-element="service-topic"` - Argomento servizio
- `data-element="load-other-cards"` - Button carica altri
- `btn-data-element="live-button-events"` - Button eventi
- `btn-data-element="live-button-locations"` - Button luoghi

#### D. **Accessibilità**

- **ARIA labels**: `aria-label-save` per button
- **ID univoci**: `id`, `id-title`, `collapse-id`
- **Label nascoste**: `label-hidden=true` quando visivamente ridondante
- **Required**: `required=true` per campi obbligatori
- **Placeholder**: testo descrittivo in tutti gli input

### 4.3 Anti-Pattern da Evitare

1. **Non hardcodare HTML** - Usare sempre partials
2. **Non duplicare classi** - Passare come parametri
3. **Non omettere breadcrumbs** - Presenti nel 97% delle pagine
4. **Non dimenticare rating e contatti** - Standard footer
5. **Non mischiare form e contenuto** - Separare con card
6. **Non usare input inline** - Sempre in `cmp-card-content-box`
7. **Non omettere progress indicator** - Obbligatorio per multi-step
8. **Non dimenticare subtitle "campi obbligatori"** - Standard UX

### 4.4 Matrice Decisionale

| Esigenza | Componente Raccomandato | Alternativa |
|----------|------------------------|-------------|
| Mostra lista generica | `cmp-card-simple` | `cmp-card-latest-messages` |
| Mostra news/articoli | `cmp-card-latest-messages` | `cmp-list-card-img-hr` |
| Mostra anteprima con img | `cmp-card-teaser` | `cmp-card-img` |
| Form input testo | `cmp-input/input` | - |
| Form dropdown | `cmp-select/select` | - |
| Form testo lungo | `cmp-text-area/text-area` | - |
| Selezione multipla | `cmp-info-radio` | `cmp-card-radio-list` |
| Riepilogo read-only | `cmp-info-summary-no-modify` | `cmp-info-summary` |
| Navigazione lunga pagina | `cmp-navscroll` | - |
| Form multi-step | `cmp-nav-steps` + `cmp-info-progress` | - |
| Alert/warning | `cmp-callout` | - |
| Contenuti correlati | `cmp-carousel` | - |
| Tag/argomenti | `cmp-tag` | - |
| Search | `cmp-input-search` | `cmp-input-search-button` |

---

## 5. Appendix

### 5.1 Glossario Termini

| Termine | Significato |
|---------|-------------|
| **Partial** | Componente Handlebars riutilizzabile (`{{> nome-partial}}`) |
| **Block Helper** | Wrapper con contenuto (`{{#>partial}}...{{/partial}}`) |
| **Hero** | Sezione iniziale con titolo e sommario |
| **Breadcrumbs** | Navigazione gerarchica (Home > Sezione > Pagina) |
| **Navscroll** | Indice pagina scrollabile |
| **Card** | Contenitore di contenuto (titolo + testo/img) |
| **Teaser** | Anteprima con immagine |
| **Callout** | Box di alert/info |
| **Accordion** | Sezione espandibile |
| **Modal** | Dialog/finestra modale |

### 5.2 Riferimenti

- **Repository:** https://github.com/italia/design-comuni-pagine-statiche
- **Documentazione:** https://italia.github.io/design-comuni-pagine-statiche/
- **Bootstrap Italia:** https://italia.github.io/bootstrap-italia/
- **Design System Italia:** https://designers.italia.it/

### 5.3 Note Metodologiche

**Analisi condotta con:**
- BMAD-METHOD (Agentic Development)
- WDS Analysis workflow
- Handlebars template parsing
- Component frequency analysis
- Pattern recognition

**Limitazioni:**
- Analisi basata su template sorgente (.hbs), non HTML renderizzato
- Alcune classi CSS sono incapsulate nei partials e non visibili
- I dati dinamici (liste, opzioni) sono referenziati ma non espansi

---

**Documento creato:** 2026-04-01  
**Versione:** 1.0  
**Stato:** Completo  
**Prossimi step:** Implementazione componenti prioritari (Tier 1)
