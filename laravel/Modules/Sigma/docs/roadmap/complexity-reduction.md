# Riduzione complessita e metodi troppo lunghi

## Obiettivo

Ridurre la complessita ciclomatica e la NPath nei punti critici (es. importazioni) mantenendo invariata la logica.

## Passi operativi

1. Identificare i metodi con CC e NPath oltre soglia.
2. Estrarre funzioni pure con responsabilita singola.
3. Introdurre guard clause e ridurre nidificazione.
4. Applicare pattern di validazione coerenti.
5. Verificare con PHPMD e test di regressione.

## Criticita

- Metodi che combinano parsing, validazione e persistenza.
- Difficolta nel separare logica senza cambiare output.

## Punti di forza

- Metriche gia disponibili nei report.
- Struttura modulare che supporta estrazione di metodi.

## Punti di debolezza

- Scarsa copertura test su flussi di importazione.
- Dipendenze implicite da contesto runtime.

## Colli di bottiglia

- Parsing di payload eterogenei.
- Duplicazioni di logica tra importatori.

## Come risolverli

- Introdurre validatori dedicati.
- Usare DTO per normalizzare input.
- Aggiungere test per i casi limite.

## Religione

- La complessita va ridotta prima di introdurre nuove feature.

## Filosofia

- Leggibilita prima di ottimizzazione prematura.

## Politica

- Refactor graduale con metriche di feedback.

## Output attesi

- CC e NPath sotto soglia nei metodi critici.
- Maggiore riuso dei componenti di parsing.

## Collegamenti correlati

- [`Roadmap Sigma`](../roadmap.md)
- [`accessor-refactor.md`](accessor-refactor.md)
- [`phpstan-legacy-cleanup.md`](phpstan-legacy-cleanup.md)
- [`test-coverage.md`](test-coverage.md)
- [`documentation-consolidation.md`](documentation-consolidation.md)
- [`analysis-report.md`](../analysis-report.md)
