# Phase 1.1: Global Component & Data Parity - Execution Plan

**Goal**: Complete Phase 1.1 tasks per roadmap
**Method**: BMAD + GSD (Discuss → Plan → Execute)

## Current State
- ✅ HTML structural parity: 7/7 segnalazione pages passing
- ✅ MCP servers configured (10 servers)
- ✅ Documentation complete

## Remaining Tasks (Phase 1.1)

### Task 1: Header Alignment
**Issue**: `it-header-wrapper` DOM structure doesn't fully match reference
**Priority**: HIGH (affects all pages)
**Scope**: Shared header component

### Task 2: Alpine.js Interactivity  
**Issue**: JavaScript interactivity not working (accordion, tabs, modals)
**Priority**: HIGH (blocks user interaction)
**Scope**: All pages with interactive elements

### Task 3: Modal & Action Parity
**Issue**: Card triggers and modals need reference matching
**Priority**: MEDIUM
**Scope**: List pages (segnalazioni-elenco, area-personale)

## Execution Strategy

### Wave 1: Alpine.js Setup & Fix
- Verify Alpine.js is loaded
- Fix interactivity for accordion, tabs, modals
- Test on segnalazione-02-dati (has accordion + forms)

### Wave 2: Header Alignment
- Compare reference header DOM vs local
- Fix structural mismatches
- Verify on all 7 pages

### Wave 3: Modal & Action Parity
- Fix remaining modal triggers
- Verify card interactions
- Test all modals open/close

## Success Criteria
- [ ] All interactive elements work (accordion, tabs, modals)
- [ ] Header matches reference DOM structure 95%+
- [ ] All modal triggers functional
- [ ] No JavaScript console errors
