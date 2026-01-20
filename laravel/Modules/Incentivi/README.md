# Modulo applicativo Incentivi

Questo Modulo applicativo consente di gestire l'attribuzione degli incentivi ai dipendenti provinciali.


## Requisiti e Funzionalità richiesti nella Prima Fase

L'applicativo Incentivi ha l'obiettivo di permettere ai Settori beneficiari degli incentivi di poter inserire tutti i dati relativi ai loro progetti e le relative attività svolte da ogni componente dei gruppi di lavoro.
L'inserimento tramite l'applicativo permetterà di:
evitare errori manuali, facendo in modo che l'utente si limiti a inserire solo i dati strettamente richiesti, effettuando poi i calcoli necessari in modo automatico;
rendere più rapido il processo di raccolta di questi dati.
Una volta che i dati verranno caricati, il Personale potrà quindi stampare/esportare il resoconto del Progetto e procedere con la fase di liquidazione.

## Aggiornamenti Recenti

### 16 Gennaio 2025
- ✅ **Implementazione Policies Complete**: Creati prototipi per tutte le policies del modulo
  - **Policies implementate**: 13 policies complete per tutti i modelli del dominio
  - **Business logic**: Definita logica di autorizzazione specifica per incentivi
  - **Struttura base**: Creata IncentiviBasePolicy con metodi helper comuni
  - **Ruoli specifici**: Definiti ruoli per amministratori, responsabili workgroup, HR, finance
  - **Stati progetto**: Implementati controlli basati sugli stati dei progetti
  - **Documentazione**: Creati `policies-implementation.md`, `policies-prototypes.md` e `implementation-commands.md`
  - **Implementazione fisica**: Tutte le 13 policies create e testate con PHPStan livello 9
  - **Business logic completa**: Autorizzazioni specifiche per stati progetto, ruoli e workgroup

## Documentazione Tecnica

- [Architettura Modulo](./docs/architettura-modulo.md)
- [Domain Model](./docs/models/domain-model.md)
- [Policies Implementation](./docs/policies-implementation.md)
- [Policies Prototypes](./docs/policies-prototypes.md)