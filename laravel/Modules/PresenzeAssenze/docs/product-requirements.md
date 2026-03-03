# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Approved |
| **Last Updated** | 2026-03-03 |
| **Owner** | HR Team |
| **Module** | PresenzeAssenze |
| **Repository** | laraxot/module_presenzeassenze_fila5 |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
Il modulo PresenzeAssenze gestisce il **monitoraggio presenze e assenze** del personale nella Pubblica Amministrazione. Include timbrature, richieste permesso, ferie e calcolo bilanci.

### Visione
Digitalizzare completamente la gestione delle presenze con:
- Clock-in/out digitale
- Richieste online
- Calendario giustificativi
- Reportistica

### Target Users
- **Dipendente**: Timbrature, richieste
- **Responsabile**: Approvazione
- **HR Admin**: Reportistica

---

## 2. Problema

### Problema Risolto
- Registrazione presenze cartacea
- Richieste permesso via email
- Calcolo manuale ferie
- Assenza report centralizzati

### Pain Points
- Timbrature perse
- Ritardi approvazione
- Calcolo straordinari
- Compliance normativa

---

## 3. Soluzione Proposta

### Funzionalità Core

#### 3.1 Time Tracking
- [x] Clock-in/out
- [x] Geo-localization (opzionale)
- [x] Badge RFID (integrazione)
- [x] Timbrature manuali

#### 3.2 Leave Management
- [x] Richiesta ferie
- [x] Richiesta permessi
- [x] Malattia
- [x] smart working
- [x] Approvazione workflow
- [x] Calendario ferie team

#### 3.3 Giustificativi
- [x] Tipologie giustificativo
- [x] Documentazione upload
- [x] Validazione responsabile

#### 3.4 Reportistica
- [x] Mensile presenze
- [x] Riepilogo ore
- [x] Straordinari
- [x] Export Excel/PDF

### Workflow Richiesta Permesso
```
1. Dipendente richiede permesso
2. Sistema verifica saldo
3. Responsabile approva/rifiuta
4. Calendario aggiornato
5. Dipendente notificato
```

---

## 4. Scope

### In Scope
- [x] Time tracking
- [x] Leave requests
- [x] Giustificativi
- [x] Reportistica

### Out of Scope
- [ ] Integrazione payroll
- [ ] Badge hardware

### Non-Goals
- Rilevamento biometrico
- Attendance device management

---

## 5. Metriche

| KPI | Target |
|-----|--------|
| Tempo approvazione | <24h |
| Accuratezza calcolo | 100% |
| User satisfaction | >4/5 |

---

## 6. Dipendenze

### Interne
Xot, Tenant, User, Notify, UI

### Esterne
- spatie/laravel-sluggable

---

## 7. Compliance

### Normativa Riferimento
- CCNL Pubblico Impiego
- Legge Brunetta (performance PA)
- GDPR per dati sensibili

### Dati Trattati
- Orari entrata/uscita
- Giustificativi
- Ferie/permessi
- Richieste malattia
