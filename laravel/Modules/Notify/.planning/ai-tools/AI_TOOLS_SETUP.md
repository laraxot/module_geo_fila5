# 🤖 AI Tools Installation & Configuration Guide

**Date**: 2026-03-30  
**Goal**: Match Design Comuni homepage HTML  
**Tools**: Superpowers, BMAD, GSD, Ralph Loop, OpenViking, NotebookLM MCP

---

## 📋 Tool Overview

| Tool | Purpose | Repository |
|------|---------|------------|
| **Superpowers** | AI agent workflow framework | https://github.com/obra/superpowers |
| **BMAD** | Business Method & Architecture Design | https://github.com/bmad-code-org/BMAD-METHOD |
| **GSD** | Get Shit Done - Phase execution | https://github.com/gsd-build/get-shit-done |
| **Ralph Loop** | Autonomous implementation agent | https://github.com/snarktank/ralph |
| **OpenViking** | Context management (installed) | https://github.com/volcengine/OpenViking |
| **NotebookLM MCP** | Source-grounded research | MCP Marketplace |

---

## 🔧 Installation Status

### ✅ Already Installed

**OpenViking**
- ✅ Installed globally
- ✅ Context: FixCity project
- ✅ Memory: Homepage corrections, icon fixes

### 🟡 To Install

**Superpowers**
- Type: AI agent plugin
- Platform: Claude Code / Cursor
- Command: `/plugin install superpowers@claude-plugins-official`

**BMAD**
- Type: Methodology framework
- Install: Clone repository
- Command: `git clone https://github.com/bmad-code-org/BMAD-METHOD.git`

**GSD**
- Type: Build methodology
- Install: Clone repository
- Command: `git clone https://github.com/gsd-build/get-shit-done.git`

**Ralph Loop**
- Type: Autonomous agent
- Install: Clone repository
- Command: `git clone https://github.com/snarktank/ralph.git`

**NotebookLM MCP**
- Type: MCP Server
- Install: Via MCP marketplace
- Command: Depends on MCP client

---

## 🎯 Integration Workflow

### Phase 1: Planning (BMAD + Superpowers)

```
1. BMAD: Analyze Design Comuni homepage structure
2. Superpowers: Create implementation plan
3. GSD: Break into phases (P0, P1, P2)
```

### Phase 2: Execution (GSD + Ralph Loop)

```
1. GSD: Execute P0 (Header, Navigation)
2. Ralph Loop: Generate Blade components
3. OpenViking: Track progress
```

### Phase 3: Testing (NotebookLM + OpenViking)

```
1. NotebookLM: Research best practices
2. OpenViking: Store test results
3. Verify HTML match
```

---

## 📐 File Structure

```
.planning/
├── ai-tools/
│   ├── SUPERPOWERS_SETUP.md
│   ├── BMAD_SETUP.md
│   ├── GSD_SETUP.md
│   ├── RALPH_SETUP.md
│   ├── OPENVIKING_SETUP.md
│   └── NOTEBOOKLM_MCP_SETUP.md
├── homepage-matching/
│   ├── ANALYSIS.md
│   ├── PLAN.md
│   └── PROGRESS.md
└── integration/
    └── WORKFLOW.md
```

---

## 🎯 Homepage Matching Strategy

### Reference HTML Structure (Design Comuni)

```html
<body>
  1. Top Bar (Region + Language)
  2. Header (Logo + Search + Social + Login)
  3. Navigation (Main Menu)
  4. Hero (City Banner)
  5. Featured Content (News)
  6. Government Bodies (Mayor, Council)
  7. Events (Calendar)
  8. Topics (Argomenti)
  9. Thematic Sites
  10. Feedback Section
  11. Contact Section
  12. Footer (4-5 columns)
</body>
```

### Current FixCity Structure

```blade
{{-- [slug].blade.php --}}
<x-layouts.app>
  @volt('tests.view')
  <div>
    <x-page side="content" :slug="$pageSlug" :data="$data" />
  </div>
  @endvolt
</x-layouts.app>
```

### JSON Config (tests.homepage.json)

```json
{
  "slug": "tests.homepage",
  "content_blocks": {
    "it": [
      {
        "type": "top-bar",
        "data": { "region_name": "Nome della Regione", "languages": [...] }
      },
      {
        "type": "header-enhanced",
        "data": { "city_name": "Nome del Comune", ... }
      },
      ...
    ]
  }
}
```

---

## 🔄 Workflow Integration

### Superpowers Flow

```yaml
Skills:
  - brainstorming: Refine homepage requirements
  - writing-plans: Create implementation tasks
  - test-driven-development: Write tests first
  - requesting-code-review: Review before merge

Session:
  1. "Help me match Design Comuni homepage"
  2. Agent asks clarifying questions
  3. Creates design spec
  4. Breaks into tasks
  5. Executes with TDD
  6. Reviews code
```

### BMAD Flow

```yaml
Phases:
  1. Business: Understand homepage goals
  2. Method: Define matching strategy
  3. Architecture: Component structure
  4. Development: Implementation
```

### GSD Flow

```yaml
Milestones:
  - Phase 0: Setup (tools, config)
  - Phase 1: Header & Navigation (P0)
  - Phase 2: Content Sections (P1)
  - Phase 3: Layout Corrections (P1)
  - Phase 4: Styling (P1)
```

### Ralph Loop Flow

```yaml
Autonomous Tasks:
  1. Read JSON config
  2. Generate Blade components
  3. Test rendering
  4. Fix issues
  5. Commit changes
```

### OpenViking Flow

```yaml
Context Storage:
  - Project: FixCity
  - Pages: 23 pages
  - Components: 10+ blocks
  - Progress: Tracking
  
Memory Updates:
  - After each task
  - Error tracking
  - Success tracking
```

### NotebookLM MCP Flow

```yaml
Research Topics:
  - Bootstrap Italia components
  - Design Comuni patterns
  - Accessibility best practices
  - Responsive design patterns

Integration:
  - Research → Store in OpenViking
  - Use in component generation
```

---

## ✅ Installation Checklist

### Superpowers
- [ ] Install for AI agent platform
- [ ] Verify installation
- [ ] Test with simple task

### BMAD
- [ ] Clone repository
- [ ] Read documentation
- [ ] Apply to homepage analysis

### GSD
- [ ] Clone repository
- [ ] Setup phases
- [ ] Create milestones

### Ralph Loop
- [ ] Clone repository
- [ ] Configure for Laravel
- [ ] Test component generation

### OpenViking
- [x] Already installed
- [ ] Update with homepage context
- [ ] Configure memory structure

### NotebookLM MCP
- [ ] Install MCP server
- [ ] Configure sources
- [ ] Test research queries

---

## 📊 Progress Tracking

| Tool | Status | ETA |
|------|--------|-----|
| Superpowers | 🟡 To Install | 30 min |
| BMAD | 🟡 To Install | 30 min |
| GSD | 🟡 To Install | 30 min |
| Ralph Loop | 🟡 To Install | 30 min |
| OpenViking | ✅ Installed | - |
| NotebookLM MCP | 🟡 To Install | 30 min |

**Total Setup Time**: 2.5h

---

## 🎯 Next Steps

1. **Install all tools** (2.5h)
2. **Configure integration** (1h)
3. **Analyze reference HTML** (1h)
4. **Create implementation plan** (1h)
5. **Execute Phase 1** (4h)
6. **Test & verify** (2h)

**Total ETA**: 11.5h

---

**Status**: 🟡 **SETTING UP**  
**Next**: Install all AI tools  
**Goal**: Match Design Comuni homepage HTML

**AI tools setup initiated! 🤖🚀**
