# Pulizia PHPStan Level 10 sui modelli legacy

## Obiettivo

Eliminare gli errori PHPStan sui modelli legacy mantenendo il livello 10 e la coerenza con le regole del modulo.

## Passi operativi

1. Catalogare gli errori per file e tipologia.
2. Prioritizzare gli errori che bloccano build o test.
3. Correggere tipizzazioni mancanti e PHPDoc incoerenti.
4. Eliminare accessi a proprieta non definite.
5. Eseguire analisi PHPStan per blocchi incrementali.

## Criticita

- Tipi impliciti non documentati in modelli storici.
- Dipendenze cross-modulo che introducono classi non risolte.

## Punti di forza

- Baseline gia ridotta e documentata.
- Pattern di errore ripetitivi e correggibili in batch.

## Punti di debolezza

- Strati legacy con naming non uniforme.
- Scarsa copertura test su modelli minori.

## Colli di bottiglia

- Classi non caricate in autoload PSR-4.
- Annotazioni PHPDoc obsolete.

## Come risolverli

- Allineare namespace e classmap.
- Introdurre PHPDoc con shape e generics.
- Aggiungere test minimi per evitare regressioni.

## Religione

- Nessun errore ignorato: correggere, non mascherare.

## Filosofia

- Tipi espliciti come documentazione eseguibile.

## Politica

- Correzioni atomiche, con verifiche rapide e frequenti.

## Output attesi

- PHPStan Level 10 senza errori sui modelli legacy.
- Tipizzazione coerente e riutilizzabile.

## Collegamenti correlati

- [`Roadmap Sigma`](../roadmap.md)
- [`accessor-refactor.md`](accessor-refactor.md)
- [`complexity-reduction.md`](complexity-reduction.md)
- [`test-coverage.md`](test-coverage.md)
- [`documentation-consolidation.md`](documentation-consolidation.md)
- [`phpstan-errors-analysis.md`](../phpstan-errors-analysis.md)
