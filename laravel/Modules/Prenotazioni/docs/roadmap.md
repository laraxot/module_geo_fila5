# Prenotazioni Module Roadmap

## Visione

Modulo per la gestione delle prenotazioni e degli appuntamenti: calendari, tipi di appuntamento, slot disponibili.

## Fasi di Sviluppo

### Fase 1: Stabilizzazione (Planned)

- [ ] PHPStan Level 10 Compliance
- [ ] Allineamento a XotBaseResource e pattern Laraxot
- [ ] Documentazione modulo completa

### Fase 2: Funzionalità Core (Planned)

- [ ] **Appuntamento** — CRUD appuntamenti
- [ ] **TipoAppuntamento** — tipologie configurabili
- [ ] **CalendarioAppuntamenti** — gestione slot e disponibilità
- [ ] Integrazione con FullCalendar (BaseCalendarWidget da UI)
- [ ] Resource Filament per ogni modello

### Fase 3: Integrazione (Future)

- [ ] Notifiche e promemoria (Notify)
- [ ] Test coverage
- [ ] Traduzioni it/en complete

## Modelli Esistenti

- `Appuntamento`, `TipoAppuntamento`, `CalendarioAppuntamenti`

## Dipendenze

- **UI**: BaseCalendarWidget per vista calendario
- **Notify**: Notifiche appuntamenti (future)

## Checklist Qualità

- [ ] PHPStan Level 10
- [ ] Estensione XotBaseResource
- [ ] Traduzioni in lang/it e lang/en
- [ ] Documentazione in docs/

---

**Ultimo aggiornamento**: Febbraio 2026
