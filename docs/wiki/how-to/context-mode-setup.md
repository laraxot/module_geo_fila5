---
title: "Context-Mode Optimal Setup"
type: "how-to"
tags: [context-mode, setup, performance, bun, tokens]
created: 2026-05-12
updated: 2026-05-12
---

# Context-Mode Optimal Setup — Complete Guide

> **Status:** ✅ Installed & Configured v1.0.121 + Bun v1.3.13  
> **Date:** 2026-05-12  
> **Problem Fixed:** 419K tokens → on-demand atomic loading

---

## 📋 What Was Fixed

| Before | After |
|--------|-------|
| 419K tokens → API Error 400 | < 50K tokens per session |
| Pre-load all wiki files | Load on-demand via triggers |
| No compression | 98% compression via context-mode |
| Bun missing | Bun v1.3.13 installed (3-5x speedup) |

---

## ✅ Installation Checklist

- [x] **Bun runtime** — `npm install -g bun` → v1.3.13
- [x] **context-mode** — upgraded to v1.0.121
- [x] **SQLite/FTS5** — verified working
- [x] **Hooks configured** — sessionstart, pretooluse, postcompact
- [x] **Knowledge base purged** — fresh start from 2026-05-12

---

## 📁 Documentation Created

### Root Level
- ✅ `docs/wiki/concepts/context-mode-optimal-configuration.md` — Best practices + config
- ✅ `docs/wiki/concepts/context-overflow-prevention.md` — Updated with Bun + v1.0.121
- ✅ `docs/wiki/rules/00-TRIGGER_MAP.md` — Updated with context-mode triggers

### Module Level
- ✅ `laravel/Modules/Xot/docs/wiki/concepts/context-mode-xot-discipline.md`
- ✅ `laravel/Modules/User/docs/wiki/concepts/context-mode-user-discipline.md`
- ✅ `laravel/Modules/Lang/docs/wiki/concepts/context-mode-lang-discipline.md`
- ✅ `laravel/Modules/Activity/docs/wiki/concepts/context-mode-activity-discipline.md`
- ✅ `laravel/Modules/Rating/docs/wiki/concepts/context-mode-rating-discipline.md`

### Theme Level
- ✅ `laravel/Themes/CONTEXT_MODE_TEMPLATE.md` — Template per tutti i temi

### Configuration
- ✅ `.env.context-mode.example` — Copy to `.env.local` and customize

---

## 🚀 Quick Start

### 1. Copy Configuration
```bash
cp .env.context-mode.example .env.local
# Personalizza se necessario
```

### 2. Verify Installation
```bash
# Check Bun
bun --version  # v1.3.13+

# Check context-mode
node "${CLAUDE_PLUGIN_ROOT}/hooks/sessionstart.mjs"  # Should show v1.0.121+
```

### 3. Load Rules On-Demand
```bash
# Never load everything
qmd search "context-mode" --limit 3

# Specific module
qmd search "xotbase resource zen" --limit 2
```

---

## 📏 Discipline Rules

### ✅ DO
- File wiki ≤ 500 righe (target: ≤ 200)
- Una idea per file
- `qmd search --limit 5` always
- Cross-link pages con `[[name]]`
- Load on-demand via triggers

### ❌ DON'T
- File wiki > 500 righe
- Embed regole in CLAUDE.md
- Pre-load intero `docs/wiki/`
