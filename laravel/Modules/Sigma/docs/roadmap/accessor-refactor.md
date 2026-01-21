# Refactoring accessors e pattern save/update

## Obiettivo

Uniformare gli accessor e rimuovere pattern di salvataggio non coerenti, mantenendo il comportamento attuale e riducendo la complessita.

## Passi operativi

1. Mappare gli accessor con logica di scrittura implicita o duplicata.
2. Identificare i metodi che alternano `save()` e `update()` senza criteri chiari.
3. Standardizzare l'ordine delle operazioni (validazione, calcolo, persistenza).
4. Estrarre metodi puri per calcoli riutilizzabili.
5. Aggiornare la documentazione e aggiungere test mirati.

## Criticita

- Rischio di regressioni su accessor utilizzati in piu modelli.
- Presenza di dati storici con formati non omogenei.

## Punti di forza

- Logiche gia documentate in diversi report.
- Pattern ripetuti che facilitano la standardizzazione.

## Punti di debolezza

- Alta variabilita tra accessor legacy.
- Mancanza di test per casi limite.

## Colli di bottiglia

- Accessor che dipendono da relazioni non caricate.
- Difficolta nel riprodurre dati di produzione in test.

## Come risolverli

- Introdurre metodi puri con input espliciti.
- Usare factory e dataset per simulare i dati necessari.
- Validare gli accessor in test unitari dedicati.

## Religione

- Favorire chiarezza e verificabilita rispetto alla magia implicita.

## Filosofia

- Separare calcolo da persistenza per ridurre accoppiamento.

## Politica

- Cambiamenti piccoli e reversibili con test a supporto.

## Output attesi

- Accessor uniformi e prevedibili.
- Riduzione dei side effect non documentati.
- Test per i casi critici.

## Collegamenti correlati

- [`Roadmap Sigma`](../roadmap.md)
- [`phpstan-legacy-cleanup.md`](phpstan-legacy-cleanup.md)
- [`complexity-reduction.md`](complexity-reduction.md)
- [`test-coverage.md`](test-coverage.md)
- [`documentation-consolidation.md`](documentation-consolidation.md)
- [`accessor-refactoring-roadmap.md`](../accessor-refactoring-roadmap.md)
