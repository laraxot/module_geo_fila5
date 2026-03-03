# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Approved |
| **Last Updated** | 2026-03-03 |
| **Owner** | HR Team |
| **Module** | ContoAnnuale |
| **Repository** | laraxot/module_contoannuale_fila5 |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
Il modulo ContoAnnuale gestisce il **Rendiconto Annuale** delle spese del personale della Pubblica Amministrazione, con invio telematico alla Ragioneria Generale dello Stato (RGS).

### Visione
Semplificare l'invio del Conto Annuale con:
- Raccolta dati automatizzata
- Validazione pre-invio
- Generazione file RGS
- Storico invii

### Target Users
- **HR Admin**: Preparazione dati
- **Dirigente**: Verifica
- **RGS**: Ricezione dati

---

## 2. Problema

### Problema Risolto
- Raccolta dati manuale
- Errori di compilazione
- Invio con procedura complessa
- Assenza storico

---

## 3. Soluzione Proposta

### Funzionalità

#### 3.1 Data Collection
- [x] Anagrafica personale
- [x] Rappresentativi sindacali
- [x] Straordinari
- [x] Indennità
- [x] Posizioni organizzative

#### 3.2 Validazione
- [x] Controllo campi obbligatori
- [x] Verifica coerenza
- [x] Warning/errori

#### 3.3 Generazione File
- [x] Formato RGS
- [x] Firma digitale
- [x] Invio telematico

#### 3.4 Report
- [x] Riepilogo dati
- [x] Comparativo anni
- [x] Export PDF

---

## 4. Scope

### In Scope
- [x] Data collection
- [x] Validazione
- [x] Invio RGS

### Out of Scope
- [ ] Altri modelli PA (SIL)
- [ ] Payroll

---

## 5. Schema RGS

### Tabelle Principali
| Tabella | Descrizione |
|---------|-------------|
| T1 | Personale a tempo indeterminato |
| T2 | Personale a tempo determinato |
| T3 | Straordinari |
| T4 | Indennità |
| T5 | Posizioni organizzative |
