# PRD: Product Requirements Document - FixCity Platform

> **Version**: 1.0.0
> **Last Updated**: 2026-03-13
> **Status**: Draft
> **Standard**: Lean PRD 2025-2026

## 1. Purpose & Vision
FixCity è una piattaforma multi-tenant modulare basata su Laravel e architettura Laraxot. L'obiettivo è fornire strumenti completi per la gestione dei servizi cittadini, dei contenuti, degli utenti e dei media con prestazioni eccellenti e un'ottima esperienza per gli sviluppatori.

## 2. User Personas
- **Tenant Administrator**: IT Manager che gestisce utenti, permessi e compliance per un comune o azienda.
- **Developer**: Sviluppatore full-stack che estende la piattaforma seguendo i pattern XotBase.
- **Content Manager**: Gestisce contenuti, asset multimediali e ottimizzazione SEO.

## 3. KPIs & Success Metrics
- **PHPStan Errors**: 0 (Level 10 strict).
- **Test Coverage**: ≥90% (Pest PHP).
- **Page Load Time**: <200ms (p95).
- **Uptime**: 99.9%.

## 4. Functional Requirements

### P0 (Critical)
- **Multi-Tenancy**: Isolamento dei dati per tenant in un unico database.
- **User Management**: RBAC, 2FA e integrazione OAuth2.
- **XotBase Core**: Utilizzo obbligatorio di classi base per coerenza architetturale.

### P1 (High)
- **Media Processing**: Pipeline per immagini e video (FFmpeg).
- **Notification System**: Email, SMS, WhatsApp, Telegram.
- **SEO Optimization**: Meta tag, Schema.org e sitemaps automatiche.

### P2 (Nice to Have)
- **AI Integration**: Generazione contenuti e analisi dati.
- **Advanced Reporting**: Esportazione PDF/CSV delle attività.

## 5. Non-Functional Requirements
- **Type Safety**: PHPStan Level 10 mandatory.
- **Consistency**: Pattern Action-over-Services.
- **Performance**: Caching Redis e ottimizzazione code.

## 6. Technical Stack
- **Framework**: Laravel 12.x
- **Admin Panel**: Filament 5.x
- **Live Components**: Livewire 4.x
- **Quality Tools**: PHPStan, Pint, Pest.

## 7. References
- [roadmap.md](roadmap.md)
- [strategy.md](strategy.md)
- [PROJECT_OVERVIEW.md](PROJECT_OVERVIEW.md)
