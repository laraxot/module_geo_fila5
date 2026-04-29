# Product Context - FixCity Platform

**Created**: 2026-04-09  
**Last Updated**: 2026-04-09  
**Project Type**: Citizen reporting platform for urban issue management

## 🎯 Project Overview

FixCity è una piattaforma di citizen reporting per la gestione di problemi urbani. I cittadini segnalano problemi (buche stradali, illuminazione rotta, etc.), gli amministratori li gestiscono.

## 🏗️ Architecture

- **Modular Monolith**: Nwidart/Laravel-Modules + Laraxot
- **Backend**: Laravel 12.24.0 + PHP 8.3.20 + SQLite
- **Backoffice**: Filament 3.x + Laraxot (admin panels)
- **Frontoffice**: Folio + Volt + Livewire 3.x (citizen interface)
- **Theme**: Sixteen (active), Bootstrap Italia replica con TailwindCSS

## 📦 Core Modules

| Module | Purpose | Status |
|--------|---------|--------|
| Fixcity | Core ticket system | Active |
| User | Authentication, profiles | Active |
| Cms | Content management | Active |
| Geo | Geographic data | Active |
| Notify | Notifications | Active |
| Xot | Framework base | Active |

## 🎨 Theme System

- **Active Theme**: Sixteen
- **CSS**: TailwindCSS v4 + @apply per Bootstrap Italia parity
- **JS**: Alpine.js per interattività
- **HTML Parity**: 99-100% con design-comuni-pagine-statiche
- **Build**: `npm run build && npm run copy` da `Themes/Sixteen/`

## 📊 Current State

- **HTML Parity**: >90% su tutte le pagine Design Comuni
- **Font**: Titillium Web (matching reference)
- **Routing**: Folio file-based (NO web.php/api.php)
- **Documentation**: 7,300+ files docs

## 🚧 Active Development

- CSS/JS visual improvements per Design Comuni parity
- MCP servers integration (memory, context7, memory-bank)
- Font matching optimization (fingerprint discrepancies)
