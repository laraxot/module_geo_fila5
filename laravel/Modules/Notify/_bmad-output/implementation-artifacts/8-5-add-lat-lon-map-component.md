# Story 8-5: Add Latitude/Longitude Map Component

## Story
Come utente che segnala un problema, voglio poter indicare la posizione esatta del disservizio usando una mappa interattiva, così da ridurre gli errori di inserimento e migliorare la qualità dei dati.

## Acceptance Criteria
- **AC1**: Un nuovo componente `LatitudeLongitudeInput` è disponibile in `Modules/Geo/app/Filament/Forms/Components` e può essere inserito nei form Filament.
- **AC2**: Nel wizard di creazione ticket (`CreateTicketWizardWidget`) il campo `AddressInput` è commentato e sostituito dal nuovo componente mappa.
- **AC3**: Il componente mostra una mappa (Leaflet) centrata sulla posizione corrente dell'utente quando si clicca su un pulsante "Usa la mia posizione".
- **AC4**: L'utente può spostare il marker; i campi nascosti `latitude` e `longitude` del modello `Ticket` vengono popolati automaticamente.
- **AC5**: I valori di `latitude` e `longitude` sono salvati correttamente nel database quando il ticket viene creato.
- **AC6**: La pagina di test `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione::data::wizard-step` mostra la mappa senza errori.
- **AC7**: Il componente rispetta le linee guida di accessibilità (etichetta, descrizione, focus) e lo stile del tema Design Comuni.
- **AC8**: Sono aggiunti test unitari e di integrazione per verificare il corretto funzionamento del binding lat/lng.

## Tasks / Subtasks
- [ ] **Implementazione componente**: creare `LatitudeLongitudeInput` con Leaflet, pulsante centrare posizione, drag marker, binding ai campi `latitude` e `longitude`.
- [ ] **Aggiornamento wizard**: commentare `AddressInput` e inserire `LatitudeLongitudeInput` nella sezione `place` del form.
- [ ] **Aggiornare modello Ticket**: aggiungere i campi `latitude` e `longitude` (se non già presenti) e gestire il fillable.
- [ ] **Scrivere test**: test unitari per il componente e test funzionali per il flusso di creazione ticket.
- [ ] **Documentazione**: aggiornare `docs/` del modulo Geo con esempi d'uso e linee guida.
- [ ] **Aggiornare story file**: impostare status a `in-progress` quando inizi.

## Dev Notes
- Utilizzare la libreria Leaflet già presente nel progetto (vedi `8-1-geo-filament-forms-components-ecosystem`).
- Riferimenti: https://github.com/CodeforKarlsruhe/farmshops.eu per pattern di mappa con geolocalizzazione.
- Verificare i permessi di geolocalizzazione del browser.

## Dev Agent Record
- **Implementation Plan**: ... (da compilare durante lo sviluppo)

## File List
- `laravel/Modules/Geo/app/Filament/Forms/Components/LatitudeLongitudeInput.php`
- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` (modifiche schema)
- Test files under `tests/Feature/`

## Change Log
- 2026-04-14: Story creata, aggiunta a sprint-status.yaml.

## Status
- ready-for-dev