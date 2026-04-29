# Active Context - Current Session

**Date**: 2026-04-09  
**Session Focus**: CSS/JS improvements + MCP setup

## 🎯 Current Tasks

### Task 1: CSS/JS Visual Parity
**Pages**: 7 pagine Design Comuni
- segnalazione-area-personale ✅ HTML Parity 100%
- segnalazioni-elenco ✅ HTML Parity 100%
- segnalazione-dettaglio ✅ HTML Parity 100%
- segnalazione-01-privacy ✅ HTML Parity 100%
- segnalazione-02-dati ✅ HTML Parity 100%
- segnalazione-03-riepilogo ✅ HTML Parity 100%
- segnalazione-04-conferma ✅ HTML Parity 99.8%

**Status**: HTML parity >80% raggiunta ✅  
**Next Step**: CSS/JS only improvements (NO HTML changes)

### Task 2: MCP Servers Setup
**Installed**:
- ✅ memory (official knowledge graph)
- ✅ memory-bank (893 stars)
- ✅ context7 (52,094 stars)

**Config**: `laravel/.mcp.json` aggiornato  
**Memory Bank**: `.memory-bank/` inizializzato

## 🔍 Key Findings

### Font Discrepancy
**Reference**: `"Titillium Web" | 18px | 400 | normal`  
**Local**: `"Titillium Web", Geneva, Tahoma, sans-serif | 14px | 400 | 20px`

**Issue**: Font family string differisce (reference ha solo "Titillium Web", local ha fallback stack)  
**Impact**: 0 font matches su 30+ combinations  
**Fix Needed**: CSS font-family override per match esatto

## 📝 Decisions Made

1. **HTML Parity**: Mantenere >80% (attuale 99-100%) ✅
2. **Font Matching**: Priorità alta - CSS font-family adjustment
3. **MCP Servers**: Installati 3 nuovi server (memory-bank, context7)
4. **Documentation**: Centralizzata in MCP-SERVERS-INDEX.md (DRY)

## ⚠️ Blockers / Risks

- Nessuno attualmente
- CSS improvements richiedono screenshot comparison costante
- Font matching può richiedere font-face adjust
