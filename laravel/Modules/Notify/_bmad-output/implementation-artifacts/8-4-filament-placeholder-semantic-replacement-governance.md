# Story 8.4: Filament Placeholder semantic replacement governance

**Stato**: ready-for-dev  
**Epic**: 8 (Tooling & Developer Experience)  
**Ultimo aggiornamento**: 2026-04-14

---

## Story

Come **maintainer del repository Laraxot/Fixcity**,  
voglio una regola canonica che governi la sostituzione di `Filament\Forms\Components\Placeholder`,  
cosi che moduli, temi, docs, skills e agent memory convergano su una sola semantica e non producano nuove duplicazioni o refactor incoerenti.

---

## Contesto

Nel repository erano presenti tesi tra loro conflittuali:

1. "Sostituire sempre `Placeholder` con `TextEntry`"
2. "Nel wizard usare Infolists per il summary"
3. "Nel wizard usare solo Schemas prime per il read-only"

La documentazione Filament 5.x chiarisce il quadro:

- `Schema` e il contenitore unificato
- `Forms` servono per input
- `Infolists` servono per dati read-only strutturati
- `Schemas` prime servono per contenuto statico/arbitrario
- `Placeholder` e deprecated e internamente estende `TextEntry`

Quindi la regola corretta e:

- `Placeholder` non va piu usato nei nuovi sviluppi
- la migrazione dipende dalla semantica del contenuto, non dal namespace storico

---

## Regola Canonica

| Caso | Sostituto |
|---|---|
| Input utente | `Filament\Forms\Components\*` |
| Dato read-only strutturato | `Filament\Infolists\Components\*` |
| Testo statico, notice, microcopy, HTML arbitrario | `Filament\Schemas\Components\*` |

Formula breve:

```text
Forms per editare
Infolists per riepilogare
Schemas prime per spiegare
Placeholder da dismettere
```

---

## Acceptance Criteria

1. Esiste un documento canonico repository-level che esplicita la regola semantica di sostituzione di `Placeholder`
2. I documenti modulo-base (`Xot`) e modulo-dominio (`Fixcity`) non si contraddicono piu su `Infolists` vs `Schemas` prime
3. Almeno un documento del tema (`Sixteen`) richiama la stessa distinzione semantica
4. Skill/rules agentiche includono la policy `Placeholder -> semantic replacement`
5. Agent memories includono la regola per prevenire regressioni future
6. La story documenta dove applicare in futuro i refactor di codice reali

---

## Task

### Task 1 — Canonical docs

- [ ] Mantenere `docs/schemas-unified-religion.md` come fonte canonica root
- [ ] Allineare `Xot/docs/filament/widgets/infolists-for-summary.md`
- [ ] Allineare `Fixcity/docs/form-vs-infolist-religion.md`

### Task 2 — Indici e anti-duplicazione

- [ ] Aggiornare gli indici rilevanti in `Fixcity`, `Xot`, `Sixteen`
- [ ] Evitare nuovi file paralleli sullo stesso tema senza fonte canonica

### Task 3 — Rules, skills, memories

- [ ] Aggiornare skill/rules Filament Laraxot
- [ ] Aggiornare memory agentica con la regola canonica

### Task 4 — Backlog tecnico futuro

- [ ] Classificare gli usi correnti di `Placeholder` in:
  - da migrare a `Infolists`
  - da migrare a `Schemas` prime
  - legacy temporaneo
- [ ] Applicare i refactor modulo per modulo solo dopo classificazione, evitando churn massivo

---

## File canonici

- [docs/schemas-unified-religion.md](/var/www/_bases/base_fixcity_fila5/docs/schemas-unified-religion.md)
- [infolists-for-summary.md](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Xot/docs/filament/widgets/infolists-for-summary.md)
- [form-vs-infolist-religion.md](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Fixcity/docs/form-vs-infolist-religion.md)
- [CreateTicketWizardWidget.md](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md)

---

## Fonti esterne

- https://filamentphp.com/docs/5.x/schemas/overview
- https://filamentphp.com/docs/5.x/infolists/overview
- https://filamentphp.com/docs/5.x/schemas/primes
- [Placeholder.php](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/vendor/filament/forms/src/Components/Placeholder.php)
