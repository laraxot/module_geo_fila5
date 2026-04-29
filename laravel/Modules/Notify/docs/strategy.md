# Product Strategy Doc - FixCity Platform

> **Version**: 1.0.0
> **Last Updated**: 2026-03-13
> **Status**: Draft

## 1. Visione Strategica
FixCity mira a diventare lo standard de facto per le piattaforme multi-tenant modulari in ambito municipale ed enterprise, sfruttando l'architettura Laraxot per garantire manutenibilità e scalabilità senza precedenti.

## 2. Pilastri Strategici

### Qualità Senza Compromessi
- **PHPStan Level 10** come requisito non negoziabile per ogni modulo.
- **TDD (Test-Driven Development)** con Pest per garantire la correttezza del comportamento di business.

### Esperienza Sviluppatore (DX)
- Utilizzo sistematico di **XotBase** per eliminare la duplicazione di codice.
- Pattern **Action-over-Services** per logica di business atomica, riutilizzabile e testabile.

### Agnosticismo del Dominio
- Ogni modulo è progettato per essere indipendente e riutilizzabile in contesti diversi (Dental, Clinical, Municipal).

## 3. Differenziatori Competitivi
- **Architettura Modulare**: 18+ moduli pronti all'uso e facilmente estensibili.
- **Type Safety**: Massima protezione dagli errori a runtime tramite analisi statica rigorosa.
- **Filament Integration**: Interfacce admin moderne, veloci e altamente personalizzabili.

## 4. Roadmap Alignment
La strategia si riflette nella roadmap Q1-Q4 con un focus iniziale sulla stabilità (PHPStan/Filament 5) e una successiva espansione su funzionalità a valore aggiunto (AI/Enterprise).

## 5. Success Metrics
- **Adozione Moduli**: Numero di moduli riutilizzati in nuovi progetti.
- **Tempo di Sviluppo**: Riduzione del time-to-market grazie ai pattern XotBase.
- **Stabilità**: Zero bug critici in produzione.

## 6. References
- [prd.md](prd.md)
- [roadmap.md](roadmap.md)
- [ARCHITECTURE_ANALYSIS.md](ARCHITECTURE_ANALYSIS.md)
