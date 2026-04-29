# Story 7-49: Placeholder migration policy — non tutto diventa Infolist

**Stato**: ready-for-dev  
**Epic**: 7 (Wizard / Filament schema governance)  
**Ultimo aggiornamento documento**: 2026-04-14

---

## Story

Come **maintainer dei wizard Filament del progetto**,  
voglio una regola chiara per migrare `Filament\Forms\Components\Placeholder`,  
così eliminiamo i placeholder usati male senza cadere nel falso dogma che tutto debba diventare `Infolist`.

---

## Decisione

`Placeholder` non va più usato come default, ma la sostituzione corretta dipende dalla semantica del contenuto:

- **dato read-only strutturato** → `Infolists` (`TextEntry`, `ImageEntry`, ecc.)
- **testo statico / notice / microcopy / HTML editoriale** → `Schemas` prime (`Text`, `Image`, ecc.)
- **input utente** → `Forms`

Quindi:

- `Placeholder` nel summary del wizard → sì, in generale va migrato verso `Infolist`
- `Placeholder` usato per privacy notice o testo legale statico → no, lì la destinazione giusta è `Schemas\Text`

---

## Perché

Il problema non è il nome `Placeholder` in sé. Il problema è quando un componente generico viene usato per trasportare una semantica che Filament esprime già meglio con componenti dedicati.

### Perché NON tutto deve diventare Infolist

Gli `Infolists` sono perfetti per:

- liste di dati strutturati
- schede read-only
- riepiloghi campo/valore

Ma non sono il contenitore più naturale per:

- un paragrafo legale lungo
- una notice editoriale
- testo statico introduttivo

In quei casi il layer corretto è `Schemas`, non `Forms`, e non serve forzare un Infolist.

---

## Fonti

- Filament Infolists overview: https://filamentphp.com/docs/5.x/infolists/overview
- Filament Schemas overview: https://filamentphp.com/docs/5.x/schemas/overview
- Filament Schemas primes: https://filamentphp.com/docs/5.x/schemas/primes

---

## Acceptance Criteria

```gherkin
Feature: Placeholder migration policy

  Scenario: Summary data
    Dato un placeholder che mostra dati read-only strutturati
    Quando applico la policy
    Allora lo sostituisco con Infolist

  Scenario: Static notice
    Dato un placeholder che mostra testo statico o legale
    Quando applico la policy
    Allora lo sostituisco con un componente Schemas prime
    E non con Infolist per dogma

  Scenario: Governance
    Dato un nuovo refactor Filament
    Quando scelgo il componente
    Allora seguo semantica del contenuto prima della moda del componente
```

---

## Change Log

| Data | Autore | Descrizione |
|------|--------|-------------|
| 2026-04-14 | Codex | Story creata per fissare la policy corretta di migrazione dei Placeholder |

---

## Status

ready-for-dev
