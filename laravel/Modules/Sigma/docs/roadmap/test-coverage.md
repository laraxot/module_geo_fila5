# Copertura test (Pest) per logiche critiche

## Obiettivo

Portare la copertura test sulle logiche critiche del modulo con test unitari e di integrazione mirati.

## Passi operativi

1. Mappare le funzioni di calcolo e i trait piu usati.
2. Definire dataset di input rappresentativi.
3. Scrivere test unitari per accessors e metodi puri.
4. Scrivere test di integrazione per flussi di calcolo.
5. Verificare copertura e correggere i gap.

## Criticita

- Dati reali complessi e difficili da sintetizzare.
- Dipendenze cross-modulo nelle relazioni.

## Punti di forza

- Logiche di calcolo gia documentate.
- Struttura dei trait facilmente testabile.

## Punti di debolezza

- Test storici incompleti o non presenti.
- Mancanza di factory per alcuni modelli legacy.

## Colli di bottiglia

- Setup dati e relazioni per i test di integrazione.
- Tempi di esecuzione elevati per test su dataset ampi.

## Come risolverli

- Usare factory e stati dedicati.
- Isolare i test con transazioni e dataset piccoli.
- Introdurre helper per la costruzione dei dati.

## Religione

- Testare il comportamento osservabile, non l'implementazione.

## Filosofia

- Ogni regressione deve essere prevenibile con un test.

## Politica

- Incrementi piccoli di copertura, ma continui.

## Output attesi

- Copertura elevata sulle logiche di calcolo.
- Test stabili e ripetibili.

## Collegamenti correlati

- [`Roadmap Sigma`](../roadmap.md)
- [`accessor-refactor.md`](accessor-refactor.md)
- [`phpstan-legacy-cleanup.md`](phpstan-legacy-cleanup.md)
- [`complexity-reduction.md`](complexity-reduction.md)
- [`documentation-consolidation.md`](documentation-consolidation.md)
- [`business-logic-analysis.md`](../business-logic-analysis.md)
