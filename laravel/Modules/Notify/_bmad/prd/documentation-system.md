# 📚 Documentation System - PRD

**Version**: 1.0  
**Created**: 2026-03-30  
**Status**: Draft  
**Owner**: Multi-Agent Team

---

## 1. Executive Summary

### 1.1 Problem Statement

Il sistema di documentazione attuale soffre di:

- **43-57% di contenuto duplicato** (6,000-8,000 file ridondanti)
- **5-10 index files per modulo** (invece di 1-2)
- **500+ file con temporal strings** nei nomi (richiedono manutenzione continua)
- **43-57% di file orfani** (non linkati da nessun indice)
- **JSON pages con single-block** (non sfruttano Filament Forms Builder)

Questo crea:
- Confusione per sviluppatori e AI agents
- Onere di manutenzione esponenziale
- Conoscenza dispersa in archive graveyards
- Inconsistenza nella UX delle pagine CMS

### 1.2 Solution Overview

Implementare **Zen of Documentation**:

1. **Single Source of Truth (SSOT)** - Ogni concetto documentato UNA volta
2. **Living Documentation** - Docs che si auto-aggiornano (PHPDoc, tests, type hints)
3. **Bidirectional Indexing** - Ogni documento linkato e linkante
4. **No Temporal Strings** - Niente date, usa git per storico
5. **Multi-Block JSON** - Pagine CMS come composizione di blocchi Filament riutilizzabili

### 1.3 Success Metrics

| Metric | Baseline | Target (90 giorni) |
|--------|----------|-------------------|
| Total MD Files | 14,000 | 5,000 (-64%) |
| Duplicate Content | 43-57% | <1% |
| Index Files per Module | 5-10 | 1-2 |
| Orphaned Files | 43-57% | <5% |
| Temporal Filenames | 500+ | 0 |
| Multi-Block JSON Pages | 0 | 38 (100%) |

---

## 2. User Personas

### 2.1 Developer (Primary)

**Name**: Marco, 28 anni  
**Role**: Full-stack Laravel developer  
**Goals**:
- Trovare rapidamente come funziona un feature
- Capire pattern architetturali
- Implementare senza rompere existing code

**Frustrations**:
- Documentazione duplicata e contraddittoria
- Non sa quale file è "quello giusto"
- Archive directories più grandi delle docs attive

**Needs**:
- Single source of truth per ogni concetto
- Indici chiari con breadcrumb
- Esempi di codice reali e testati

### 2.2 AI Agent (Primary)

**Name**: gsd-codebase-mapper  
**Role**: Autonomous codebase analyzer  
**Goals**:
- Comprendere struttura del progetto
- Trovare pattern e convenzioni
- Produrre report coerenti

**Frustrations**:
- Documentazione contraddittoria
- Contesto disperso in 100+ file
- No clear entry point

**Needs**:
- OpenViking context preservation
- BMAD threads per coordinamento
- GSD phases per execution tracking

### 2.3 Technical Writer (Secondary)

**Name**: Paige (bmad-agent-tech-writer)  
**Role**: Documentation quality assurance  
**Goals**:
- Mantenere documentazione chiara e consistente
- Eliminare duplicazione
- Assicurare cross-references funzionanti

**Frustrations**:
- Temporal strings richiedono aggiornamenti continui
- Duplicazione crea inconsistency
- Orphaned docs impossible to maintain

**Needs**:
- Automated quality gates
- Duplicate detection scripts
- Link validation tools

---

## 3. Requirements

### 3.1 Functional Requirements

#### FR-1: Documentation Deduplication
**Description**: Sistema deve identificare e rimuovere duplicati  
**Acceptance Criteria**:
- [ ] Script `check-duplicates.sh` trova duplicati esatti (>90% similarità)
- [ ] Report automatico con lista duplicati
- [ ] Merge tool per unire contenuti duplicati
- [ ] Cross-reference automatico dopo merge

#### FR-2: Unified Indexing
**Description**: Ogni modulo ha UN indice unificato  
**Acceptance Criteria**:
- [ ] 1 index.md per modulo (00-index.md accettato)
- [ ] Breadcrumb navigation in ogni documento
- [ ] Cross-references bidirezionali
- [ ] Link validation in CI/CD

#### FR-3: No Temporal Strings
**Description**: Niente date nei nomi file o contenuto  
**Acceptance Criteria**:
- [ ] Rename script per file temporali
- [ ] Validation gate in CI/CD
- [ ] Git history per tracking temporale
- [ ] Documentation "timeless"

#### FR-4: Multi-Block JSON Pages
**Description**: Pagine CMS come composizione di blocchi Filament  
**Acceptance Criteria**:
- [ ] Ogni pagina JSON ha 3-5 blocchi (hero, content, cta, etc.)
- [ ] Blocchi riutilizzabili across pages
- [ ] Filament Forms Builder per admin
- [ ] Blade views per ogni blocco
- [ ] Test coverage 100%

#### FR-5: Multi-Agent Coordination
**Description**: Sistema supporta AI agents multipli  
**Acceptance Criteria**:
- [ ] OpenViking context globale
- [ ] BMAD threads per coordinamento
- [ ] GSD phases per execution
- [ ] Agent notes in documentazione

### 3.2 Non-Functional Requirements

#### NFR-1: Performance
- Duplicate check: <5 minuti per 14,000 file
- Link validation: <2 minuti per modulo
- JSON rendering: <100ms per pagina

#### NFR-2: Maintainability
- Zero manutenzione per temporal strings
- <1 ora/settimana per manutenzione ordinaria
- Automated quality gates in CI/CD

#### NFR-3: Scalability
- Sistema funziona con 1x a 10x documentazione corrente
- Supporta 10+ AI agents simultanei
- Indici gestiscono 1000+ documenti per modulo

#### NFR-4: Quality
- Duplicate content: <1%
- Orphaned files: <5%
- Link breakage: 0% (validati in CI/CD)
- Test coverage: 100% per multi-block JSON

---

## 4. User Stories

### Epic 1: Documentation Cleanup

**US-1.1**: Come sviluppatore, voglio trovare documentazione senza duplicati  
**Tasks**:
- [ ] Run `check-duplicates.sh`
- [ ] Merge duplicate content
- [ ] Create cross-references
- [ ] Delete duplicates

**US-1.2**: Come sviluppatore, voglio indici chiari per navigare  
**Tasks**:
- [ ] Create unified index per modulo
- [ ] Add breadcrumb navigation
- [ ] Add cross-references
- [ ] Validate all links

**US-1.3**: Come maintainer, voglio documentazione senza temporal strings  
**Tasks**:
- [ ] Identify temporal filenames
- [ ] Rename files (remove dates)
- [ ] Update cross-references
- [ ] Add CI/CD validation

### Epic 2: Multi-Block JSON

**US-2.1**: Come admin user, voglio creare pagine con blocchi riutilizzabili  
**Tasks**:
- [ ] Define block types (hero, content, cta, etc.)
- [ ] Create Filament block classes
- [ ] Create Blade views
- [ ] Test in admin panel

**US-2.2**: Come sviluppatore, voglio convertire JSON pages a multi-block  
**Tasks**:
- [ ] Analyze existing single-block JSON
- [ ] Design multi-block structure
- [ ] Convert 38 pages
- [ ] Write tests

**US-2.3**: Come QA, voglio testare rendering multi-block  
**Tasks**:
- [ ] Create Pest tests
- [ ] Test all block types
- [ ] Test block combinations
- [ ] Test responsive rendering

### Epic 3: Multi-Agent Coordination

**US-3.1**: Come AI agent, voglio contesto preservato in OpenViking  
**Tasks**:
- [ ] Create global context file
- [ ] Add memory for key decisions
- [ ] Enable context retrieval
- [ ] Test across sessions

**US-3.2**: Come AI agent, voglio coordinarmi via BMAD threads  
**Tasks**:
- [ ] Create coordination thread
- [ ] Log agent decisions
- [ ] Track progress
- [ ] Resolve conflicts

**US-3.3**: Come AI agent, voglio eseguire task via GSD phases  
**Tasks**:
- [ ] Create phase structure
- [ ] Define phase goals
- [ ] Execute with atomic commits
- [ ] Verify completion

---

## 5. Technical Architecture

### 5.1 Documentation Structure

```
docs/
├── MASTER_DOCUMENTATION_INDEX.md    # Root index
├── ZEN_OF_DOCUMENTATION.md          # Philosophy
├── DOCUMENTATION_GOVERNANCE.md      # Rules
├── architecture/
│   ├── 00-index.md
│   ├── system.md
│   └── modules.md
├── guides/
│   ├── 00-index.md
│   ├── development.md
│   └── testing.md
└── reports/
    ├── 00-index.md
    └── duplicate-report.md

laravel/Modules/*/docs/
├── 00-index.md                      # Unified index
├── architecture/
├── guides/
├── reference/
└── archive/                         # Historical only

.qwen/
├── openviking-context.md            # Global context
└── skills/
    └── bmad-agent-*/

_bmad/
├── threads/zen-documentation.md     # Coordination
├── prd/documentation-system.md      # This file
└── architecture/

.planning/phases/
├── 01-doc-audit/
├── 02-deduplication/
├── 03-indexing/
└── 04-multi-block-json/
```

### 5.2 Multi-Block JSON Architecture

```
CMS Page JSON
├── content_blocks (array)
│   ├── hero (Filament HeroBlock)
│   ├── content_grid (Filament GridBlock)
│   ├── cta_section (Filament CtaBlock)
│   └── details_card (Filament DetailsBlock)
├── sidebar_blocks (array)
│   └── navigation (Filament NavBlock)
└── footer_blocks (array)
    └── links (Filament LinksBlock)

Database Storage:
- pages.content_blocks (JSON column)
- pages.sidebar_blocks (JSON column)
- pages.footer_blocks (JSON column)

Filament Admin:
- PageResource → Builder field
- Dynamic block discovery
- Collapsible block UI

Rendering:
- page.blade.php → loops blocks
- @include($block->view, $block->data)
- Block-specific Blade views
```

### 5.3 Data Flow

```
User creates page in Filament Admin
    ↓
Filament Forms Builder (multi-block)
    ↓
JSON stored in database
    ↓
Page model loads JSON
    ↓
BlockData instances created
    ↓
Blade renders each block view
    ↓
HTML response to user
```

---

## 6. Implementation Timeline

### Phase 1: Documentation Audit (Week 1-2)
**Start**: 2026-03-30  
**End**: 2026-04-10  
**Owner**: Ralph Loop

**Deliverables**:
- Duplicate report
- Orphan analysis
- Temporal filename catalog
- Baseline metrics

### Phase 2: Deduplication (Week 3-4)
**Start**: 2026-04-13  
**End**: 2026-04-24  
**Owner**: GSD Executor

**Deliverables**:
- Merged duplicate content
- Cross-references created
- Archive cleanup
- Deduplication report

### Phase 3: Index Unification (Month 2)
**Start**: 2026-04-27  
**End**: 2026-05-15  
**Owner**: GSD Executor

**Deliverables**:
- Unified indices (1 per module)
- Breadcrumb navigation
- Bidirectional linking
- Link validation report

### Phase 4: Multi-Block JSON (Month 2-3)
**Start**: 2026-05-18  
**End**: 2026-06-12  
**Owner**: GSD Executor + Amelia

**Deliverables**:
- 16 Filament block classes
- 38 converted JSON pages
- Blade views for all blocks
- Test coverage 100%

### Phase 5: Automation (Month 3)
**Start**: 2026-06-15  
**End**: 2026-06-26  
**Owner**: GSD Executor

**Deliverables**:
- CI/CD quality gates
- Automated duplicate detection
- Link validation in CI
- Ralph Loop maintenance

---

## 7. Risks & Mitigations

### Risk 1: Breaking Changes
**Probability**: Alta  
**Impact**: Alto  
**Mitigation**:
- Feature flags per rollout graduale
- Backward compatibility layer
- Test approfonditi prima di merge

### Risk 2: Agent Collision
**Probability**: Media  
**Impact**: Alto  
**Mitigation**:
- GSD workspaces isolati
- Lock file per file in modifica
- Coordinamento via GitHub issues

### Risk 3: Documentation Churn
**Probability**: Alta  
**Impact**: Medio  
**Mitigation**:
- GSD phases sequenziali
- Atomic commits
- Clear ownership per phase

### Risk 4: Resistance to Change
**Probability**: Media  
**Impact**: Medio  
**Mitigation**:
- Training per team
- Documentazione chiara
- Quick wins per dimostrare valore

---

## 8. Success Criteria

### 8.1 Launch Criteria
- [ ] Duplicate content <1%
- [ ] 1 index per modulo
- [ ] 0 temporal filenames
- [ ] Orphaned files <5%
- [ ] 38 JSON pages converted to multi-block
- [ ] Test coverage 100%

### 8.2 Post-Launch Metrics
- Maintenance time: <1 ora/settimana
- User satisfaction: >8/10
- AI agent efficiency: +50%
- Documentation findability: <30 secondi

### 8.3 Long-Term Goals
- Zero duplicate content
- Self-healing links (auto-fix broken)
- AI-generated documentation drafts
- Real-time quality dashboard

---

## 9. Appendices

### 9.1 Glossary

- **SSOT**: Single Source of Truth
- **DRY**: Don't Repeat Yourself
- **KISS**: Keep It Simple, Stupid
- **BMAD**: Business Model, Architecture, Development framework
- **GSD**: Get Shit Done methodology
- **OpenViking**: Context preservation tool

### 9.2 References

- [Zen of Documentation](docs/ZEN_OF_DOCUMENTATION.md)
- [Documentation Governance](docs/DOCUMENTATION_GOVERNANCE.md)
- [Multi-Agent Collaboration](docs/MULTI_AGENT_COLLABORATION.md)
- [Filament Blocks System](laravel/Modules/Cms/docs/blocks/content-blocks-system.md)

### 9.3 Related Documents

- PRD: CMS JSON Philosophy
- Architecture: Documentation System
- Epic: Documentation Cleanup
- Thread: Zen Documentation Coordination

---

**Approvals**:
- **Product (John)**: Pending
- **Architecture (Winston)**: Pending
- **UX (Sally)**: Pending
- **Tech Writing (Paige)**: Pending
- **Development (Amelia)**: Pending

**Last Updated**: 2026-03-30  
**Next Review**: After Phase 1 completion
