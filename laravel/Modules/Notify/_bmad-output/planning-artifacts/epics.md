---
stepsCompleted: ["step-01-validate-prerequisites","step-03-create-stories"]
inputDocuments:
  - "_bmad-output/planning-artifacts/prd.md"
  - "_bmad-output/planning-artifacts/architecture.md"
  - "laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php"
  - "laravel/Themes/Sixteen/resources/css/segnalazione-parity.css"
  - "laravel/Themes/Sixteen/docs/comparisons/screenshots/local/segnalazione-02-dati-mobile.png"
  - "laravel/Themes/Sixteen/docs/comparisons/screenshots/reference/segnalazione-02-dati-mobile.png"
  - "laravel/Themes/Sixteen/docs/screenshots/css-js-phase/segnalazione-02-dati-LOC-FINAL.png"
  - "laravel/Themes/Sixteen/docs/screenshots/css-js-phase/segnalazione-02-dati-REF-FINAL.png"
focus: "segnalazione-02-dati — header responsiveness"
---

# base_fixcity_fila5 - Epic Breakdown
## Focus: Header responsiveness — segnalazione-02-dati

## Contesto

**Pagina:** `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
**Problema:** L'area header (breadcrumb + titolo + steppers) si vede male, soprattutto su mobile/tablet
**Riferimento:** https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html
**Blade:** `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`
**CSS target:** `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` §27

---

## Requirements Inventory

### Functional Requirements

FR1: Il breadcrumb deve essere responsive: testo troncato con ellipsis su mobile, navigabile su tutti i breakpoint
FR2: Il titolo h1 "Segnalazione disservizio" deve scalare: 40px desktop → 28px mobile
FR3: Lo steppers-header su mobile (< 992px) deve mostrare SOLO il passo attivo ("Dati di segnalazione") + contatore "2/3" a destra
FR4: La riga del stepper non deve mai causare scroll orizzontale
FR5: Il titolo del passo attivo nel stepper deve andare a capo (white-space: normal) su schermi stretti senza overflow
FR6: Il blocco header completo (breadcrumb + h1 + steppers) deve essere visivamente identico al reference Design Comuni
FR7: Il sito-header (it-header-center-wrapper + navbar) deve essere responsive e non causare reflow/overlap sul contenuto principale
FR8: Su tablet (768-991px) lo stepper deve mostrare solo il passo attivo + counter
FR9: Il contatore "2/3" (steppers-index) deve essere visibile su mobile e tablet
FR10: Nessun overflow/scroll orizzontale a qualsiasi viewport ≥ 320px

### Non-Functional Requirements

NFR1: Responsive su 320px, 576px, 768px, 992px, 1200px (mobile-first)
NFR2: Nessun !important inutile — usare specificità CSS corretta con body.page-* prefix
NFR3: Contrasto WCAG AA su tutti gli elementi del header (4.5:1 minimo)
NFR4: Focus indicator visibile su breadcrumb links e step buttons
NFR5: Nessuna regressione sulle pagine segnalazione-01-privacy e segnalazione-03-riepilogo
NFR6: CSS bundle < 200KB (nessun CSS ridondante)
NFR7: Compatibilità cross-browser: Chrome, Firefox, Safari, Edge

### Additional Requirements (Architecture/Technical)

- AR1: NON modificare la struttura HTML del Blade (segnalazione-02-dati.blade.php)
- AR2: Tutti i fix CSS in segnalazione-parity.css con prefisso body.page-tests-segnalazione-02-dati
- AR3: Usare Tailwind CSS v4 + CSS custom properties (no Bootstrap Italia)
- AR4: Vite build pipeline: npm run build → npm run copy dopo ogni modifica
- AR5: Nessun JS necessario — solo CSS per i fix dell'header
- AR6: I selettori devono matchare esattamente le classi del Blade esistente
- AR7: Il CSS esistente in sezione §27 NON va eliminato — solo esteso/corretto

### UX Design Requirements

Non è presente un documento UX Design separato. I requisiti visivi sono derivati dal confronto diretto con il reference Design Comuni.

---

### FR Coverage Map

{{requirements_coverage_map}}

## Epic List

## Epic List

### Epic 7‑2: Mappa di selezione posizione per il Ticket
**Obiettivo**: Consentire all’utente di indicare la posizione geografica del ticket tramite una mappa interattiva, salvando le coordinate `latitude` e `longitude`.
**FR coperti**: FR‑1, FR‑2, FR‑3, FR‑4, FR‑5, FR‑6.

#### Story 7.2.1 – Creazione del componente **MapLocationInput**

**User story**
*Come* sviluppatore front‑end, *voglio* un nuovo campo Filament / Livewire chiamato `MapLocationInput` che mostri una mappa interattiva, *così che* l’utente possa centrare la mappa sulla propria posizione, spostare un marker e avere le coordinate lat/long aggiornate in tempo reale.

**Acceptance Criteria**
- **AC‑1**: *Given* la pagina del wizard è caricata e il browser ha il permesso di geolocalizzazione, *When* il componente viene inizializzato, *Then* la mappa si centra sulle coordinate attuali del dispositivo (fallback a coordinate predefinite se il permesso è negato).
- **AC‑2**: *Given* la mappa centrata, *When* l’utente trascina il marker, *Then* i campi hidden `latitude` e `longitude` del form vengono aggiornati istantaneamente con le nuove coordinate.
- **AC‑3**: *Given* i campi di lat/long aggiornati, *When* l’utente invia il wizard, *Then* i valori vengono inviati al backend come parte del payload del form.
- **AC‑4**: *Given* il componente, *When* la pagina è visualizzata su viewport ≥ 320 px, *Then* la mappa è responsive (si ridimensiona senza overflow).
- **AC‑5**: *Given* l’uso di assistive technology, *When* il marker è focalizzato, *Then* viene fornita una descrizione ARIA “Posizione selezionata, lat = …, long = …”.
- **AC‑6**: *Given* il componente, *When* viene eseguito il test unitario, *Then* le funzioni `mount()`, `updateCoordinates()` e `render()` restituiscono i risultati attesi.

#### Story 7.2.2 – Sostituzione di **AddressInput** con **MapLocationInput** nello step “Place” del wizard

**User story**
*Come* utente che crea una segnalazione, *voglio* inserire la posizione tramite la mappa anziché digitare un indirizzo, *così che* il sistema memorizzi direttamente latitude / longitude senza passaggi manuali.

**Acceptance Criteria**
- **AC‑1**: *Given* il widget `CreateTicketWizardWidget` nella sezione “Place”, *When* il codice è stato aggiornato, *Then* il campo `AddressInput::make('address')` è sostituito da `MapLocationInput::make('location')`.
- **AC‑2**: *Given* il nuovo campo, *When* l’utente interagisce con la mappa, *Then* i valori `latitude` e `longitude` sono presenti nel form e l’indirizzo visualizzato è opzionale, non richiesto.
- **AC‑3**: *Given* il backend, *When* il payload contiene `latitude` e `longitude`, *Then* il modello `Ticket` li salva senza errori di validazione.
- **AC‑4**: *Given* la vista Blade del wizard, *When* la modifica è applicata, *Then* il layout rimane coerente con il design Comuni (nessun breaking CSS).
- **AC‑5**: *Given* il processo di build, *When* il nuovo codice è compilato, *Then* non compaiono warning di dipendenze mancanti (Leaflet è incluso in `vite.config.js`).
- **AC‑6**: *Given* il test di integrazione del wizard, *When* viene simulata la selezione della posizione, *Then* il test verifica che il ticket creato contenga le coordinate corrette.

#### Story 7.2.3 – Test automatizzati per **MapLocationInput** e integrazione con il wizard

**User story**
*Come* QA / sviluppatore, *voglio* una suite di test unitari e di integrazione per il nuovo campo, *così che* possa verificare che la mappa funzioni correttamente e che le coordinate vengano salvate.

**Acceptance Criteria**
- **AC‑1**: *Given* la classe `MapLocationInput`, *When* viene eseguito il test unitario, *Then* il metodo `mount()` restituisce le coordinate di fallback quando il permesso non è disponibile.
- **AC‑2**: *Given* il componente, *When* il marker viene spostato via JavaScript simulato, *Then* i valori hidden cambiano e il test verifica l’aggiornamento.
- **AC‑3**: *Given* il wizard completo, *When* l’utente compila la mappa e invia il form (test di integrazione con Laravel Dusk/Livewire), *Then* il ticket creato ha `latitude` e `longitude` popolati.
- **AC‑4**: *Given* il report di copertura, *When* tutti i test sono passati, *Then* la copertura dei file `MapLocationInput.php` e la modifica della wizard è ≥ 90 %.
- **AC‑5**: *Given* il CI, *When* viene eseguito il comando `npm run test && php artisan test`, *Then* la pipeline non fallisce per linting o errori di dipendenza.

