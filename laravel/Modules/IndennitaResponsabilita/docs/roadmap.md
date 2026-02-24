# IndennitaResponsabilita Module Roadmap

## Visione

Sistema di valutazione e calcolo indennità dirigenziali per PA: criteri configurabili, calcolo automatico, audit trail e documentazione PDF.

**Business Logic**: [business-logic](business-logic.md) — PERCHÉ e COME funziona

## Fasi di Sviluppo

### Fase 1: Stabilizzazione (In Progress)

- [x] PHPStan Level 10 Compliance
- [x] Compila Page Systematization (Unified Form + Live Summary)
- [x] Validazione criteri minimi (2+ con punteggio > 0) — [minimum-positive-ratings-validation](minimum-positive-ratings-validation.md)
- [ ] Test Coverage improvement
  - [ ] Unit test `IndennitaCalculationService` (post-refactoring)
  - [ ] Feature test pagina Compila
  - [ ] Feature test salvataggio e validazione
- [ ] Documentazione consolidata
  - [ ] Pulizia file duplicati in docs/
  - [ ] Indice documentazione aggiornato

### Fase 2: Refactoring DRY+KISS+SOLID (Planned)

Dettaglio: [refactoring-action-plan](refactoring-action-plan.md)

- [ ] **Foundation & Services** (Giorni 1-3)
  - [ ] IndennitaCalculationService — estrarre logica calcolo da CompilaIndennitaResponsabilita
  - [ ] RatingService — estrarre getRatingsForYear, prepareRatingsForView
  - [ ] DTO: IndennitaCompilazioneData, RatingValueData
- [ ] **Compila Page Refactoring** (Giorni 4-6)
  - [ ] Ridurre God Class (457 linee → <200)
  - [ ] Iniettare Services invece di logica inline
  - [ ] Separare recalculateReadonlyFields in RatingService
- [ ] **Trait Responsibility** (Giorni 7-8)
  - [ ] Spostare getRatingsWhere da HasRatingsTrait a RatingService — [why-getratings-should-move](why-getratings-should-move.md)
  - [ ] Refactoring rating functions — [refactoring-rating-functions](refactoring-rating-functions.md)
- [ ] **Integrazione PDF avanzata**
  - [ ] HTML2PDF — [html2pdf](html2pdf/index.md)
  - [ ] Lettere ufficiali e report

### Fase 3: Integrazione e Ottimizzazione (Future)

- [ ] Integrazione con Performance/Quaeris
- [ ] Reportistica avanzata
- [ ] Performance form reattivo (lazy load ratings)
- [ ] Traduzioni it/en/de complete — [translations](translations.md)

## Technical Debt

| Area | Stato | Target | Riferimento |
|------|-------|--------|-------------|
| PHPStan | Level 10 | 0 errori | [quality/phpstan](quality/phpstan.md) |
| God Class Compila | 417 linee | <200 | [refactoring-action-plan](refactoring-action-plan.md) |
| Service Layer | Assente | IndennitaCalculationService, RatingService | [refactoring-action-plan](refactoring-action-plan.md) |
| DTO Pattern | Assente | IndennitaCompilazioneData | [refactoring-action-plan](refactoring-action-plan.md) |
| Test Coverage | Parziale | >85% | [development/testing](development/testing.md) |

## Dipendenze

- **Rating**: HasRatingsTrait, Rating model — [Rating/docs](../Rating/docs/)
- **Ptv**: BaseScheda, CompilaAction — [Ptv/docs](../Ptv/docs/)
- **Activity**: Audit trail — [activity-log-integration](activity-log-integration.md)
- **Sigma**: Dati anagrafici — [architecture/models](architecture/models.md)

## Collegamenti

- [README](README.md)
- [Business Logic](business-logic.md)
- [Refactoring Action Plan](refactoring-action-plan.md)
- [Compila Form Architecture](compila-form-architecture.md)
- [Trait Responsibility Violation](trait-responsibility-violation.md)

## Checklist Qualità

- [x] PHPStan Level 10
- [ ] Test coverage flussi critici
- [ ] Traduzioni it/en complete
- [x] Documentazione business-logic
- [ ] Service layer implementato
- [ ] DTO pattern implementato

---

**Ultimo aggiornamento**: Febbraio 2026
