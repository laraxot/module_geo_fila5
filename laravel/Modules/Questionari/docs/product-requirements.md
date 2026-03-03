# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Approved |
| **Last Updated** | 2026-03-03 |
| **Owner** | Admin Team |
| **Module** | Questionari |
| **Repository** | laraxot/module_questionari_fila5 |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
Il modulo Questionari fornisce un sistema per la **creazione e gestione di questionari e survey**. Include builder visuale, risposte multiple, analisi risultati.

### Visione
Strumento flessibile per:
- Rilevazioni customer satisfaction
- Sondaggi interni
- Valutazioni performance
- Feedback collection

### Target Users
- **Admin**: Creazione questionari
- **Utente**: Compilazione
- **PM**: Analisi risultati

---

## 2. Problema

### Problema Risolto
- Survey frammentate
- Nessuna analisi centralizzata
- Platforma esterna costosa
- Dati non strutturati

---

## 3. Soluzione Proposta

### Funzionalità

#### 3.1 Questionario Builder
- [x] Tipi domanda: testo, scelta multipla, scala, data
- [x] Logica condizionale
- [x] Randomizzazione
- [x] Obbligatorietà

#### 3.2 Distribution
- [x] Link diretto
- [x] Email invitation
- [x] Token access
- [x] Scadenza

#### 3.3 Risposte
- [x] Raccolta risposte
- [x] Validazione
- [x] Partial save
- [x] Anonimato

#### 3.4 Analytics
- [x] Dashboard risposte
- [x] Grafici
- [x] Export dati
- [x] Cross-tabulation

---

## 4. Scope

### In Scope
- [x] Builder questionari
- [x] Raccolta risposte
- [x] Analytics base

### Out of Scope
- [ ] Survey automation
- [ ] Advanced statistics

---

## 5. Tipi Domanda Supportati

| Tipo | Descrizione |
|------|-------------|
| Text | Testo libero |
| Textarea | Testo lungo |
| Select | Scelta singola |
| MultiSelect | Scelta multipla |
| Scale | Likert 1-5/1-10 |
| Date | Data |
| File | Upload |
