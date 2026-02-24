# Mensa Module Roadmap

## Visione

Modulo per la gestione del servizio mensa aziendale: timbrature, contributi cassa, centri cottura, buoni pasto e adesioni.

## Fasi di Sviluppo

### Fase 1: Stabilizzazione (Planned)

- [ ] PHPStan Level 10 Compliance
- [ ] Allineamento a XotBaseResource e pattern Laraxot
- [ ] Documentazione modulo completa
- [ ] Creare docs/ con README e architecture

### Fase 2: Funzionalità Core (Planned)

- [ ] **Timbra** — gestione timbrature ingresso/uscita mensa
- [ ] **ContributoCassa** — contributi e adesioni
- [ ] **CentroTorri** — centri cottura
- [ ] **Mensile** — riepiloghi mensili
- [ ] **Cir, Testi, MensaManuali** — dati di supporto
- [ ] Report mensili e export

### Fase 3: Integrazione (Future)

- [ ] Integrazione con Badge (Mensa, FoodTicket)
- [ ] Test coverage
- [ ] Traduzioni it/en complete

## Modelli Esistenti

- `Timbra`, `CentroTorri`, `ContributoCassa`, `Mensile`, `MensaManuali`, `Testi`, `Cir`

## Dipendenze

- **Badge**: Modelli Mensa, FoodTicket (cross-module)

## Checklist Qualità

- [ ] PHPStan Level 10
- [ ] Estensione XotBaseResource
- [ ] Traduzioni in lang/it e lang/en
- [ ] Documentazione in docs/

---

**Ultimo aggiornamento**: Febbraio 2026
