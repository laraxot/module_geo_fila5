# UI/UX Skills Research Summary

**Domain:** AI Agent Skills for UI/UX and Frontend Design
**Researched:** March 30, 2026
**Overall Confidence:** HIGH

## Executive Summary

The UI/UX skills ecosystem for Claude Code and other AI coding agents has matured significantly in 2025-2026. This research identified **15+ distinct UI/UX design skills** across multiple repositories, ranging from official Anthropic skills to community-driven collections.

The ecosystem is organized around several key players:
- **Anthropic** (official skills repository with 106k+ stars)
- **Vercel Labs** (web design guidelines and React best practices with 24k+ stars)
- **Community leaders** like `nextlevelbuilder`, `Leonxlnx`, `ibelick`, and `bencium`

Skills fall into three categories:
1. **Design Generation** - Creating distinctive, production-grade interfaces
2. **Design Audit** - Reviewing existing code for accessibility, performance, and UX compliance
3. **Design Polish** - Incremental improvements to spacing, typography, motion, and metadata

The most comprehensive skills combine multiple sub-skills into cohesive workflows, with installation via `npx skills add` or Claude Code's `/plugin marketplace add` commands.

## Key Findings

**Stack:** Skills are markdown-based (SKILL.md format) with optional scripts, compatible across Claude Code, Cursor, Windsurf, Codex, and Gemini CLI

**Architecture:** Skills load dynamically from `.claude/skills/` directory with YAML frontmatter for metadata and triggering

**Critical Pitfall:** Many skills overlap in functionality (e.g., 5+ skills provide "frontend design" capabilities) — choosing the wrong combination leads to context bloat without proportional quality gains

## UI/UX Skills Landscape

### Tier 1: Most Popular (20k+ stars)

| Skill | Repository | Stars | Focus |
|-------|-----------|-------|-------|
| **frontend-design** | anthropics/skills | 106k | Distinctive interface generation |
| **ui-ux-pro-max** | nextlevelbuilder/ui-ux-pro-max-skill | 54.9k | Comprehensive design intelligence database |
| **web-design-guidelines** | vercel-labs/agent-skills | 24.1k | UI audit against 100+ rules |
| **taste-skill** | Leonxlnx/taste-skill | 6.5k | Premium "expensive-looking" design |

### Tier 2: Specialized (1k-20k stars)

| Skill | Repository | Stars | Focus |
|-------|-----------|-------|-------|
| **impeccable** | pbakaus/impeccable | 10k+ | 17 design commands for workflow control |
| **ui-skills** | ibelick/ui-skills | 1.1k | Modular UI polish skills |
| **bencium-marketplace** | bencium/bencium-marketplace | 121 | 6 design skills (controlled UX, innovative UX, impact designer, etc.) |
| **frontend-design** | vnzzzz/frontend-design (Smithery) | 219 installs | Production-grade interfaces |

### Tier 3: Emerging (<1k stars)

| Skill | Repository | Stars | Focus |
|-------|-----------|-------|-------|
| **designer-skills** | Owl-Listener/designer-skills | 164 | 63 skills across 8 design domains |
| **ui-design-brain** | carmahhawwari/ui-design-brain | 600+ | 60+ component best practices |
| **ux-researcher-designer** | davila7/claude-code-templates | 23k+ (repo) | UX research methodologies |

## Installation Methods

### Method 1: Skills.sh CLI (Universal)
```bash
# Install single skill
npx skills add <repository> --skill <skill-name>

# Install all skills from repository
npx skills add <repository> --all

# Examples
npx skills add anthropics/skills --skill frontend-design
npx skills add ibelick/ui-skills --all
npx skills add https://github.com/Leonxlnx/taste-skill
```

### Method 2: Claude Code Plugin System
```bash
# Add marketplace
/plugin marketplace add <repository>

# Install specific plugin
/plugin install <skill-name>@<marketplace>

# Examples
/plugin marketplace add anthropics/skills
/plugin install document-skills@anthropic-agent-skills
```

### Method 3: Smithery CLI
```bash
npx @smithery/cli@latest skill add vnzzzz/frontend-design
```

### Method 4: Manual Installation
```bash
# Clone and copy to .claude/skills/
git clone <repository>
cp -r <repository>/skills/* ~/.claude/skills/
```

## Recommended Skill Combinations

### For Frontend Developers
1. `frontend-design` (Anthropic) - Base design generation
2. `baseline-ui` (ibelick) - Visual consistency
3. `fixing-accessibility` (ibelick) - WCAG compliance
4. `web-design-guidelines` (Vercel) - Audit against best practices

### For Designers
1. `ui-ux-pro-max` - Comprehensive design intelligence
2. `design-audit` (bencium) - Systematic UX audits
3. `extract-style` (Solo Design Studio) - Figma to design tokens

### For Rapid Prototyping
1. `taste-skill` - Premium aesthetics
2. `output-skill` - Prevent AI laziness
3. `frontend-design` - Production-ready code

## Confidence Assessment

| Area | Confidence | Notes |
|------|------------|-------|
| Skill Identification | HIGH | Verified across 10+ sources |
| Installation Commands | HIGH | Tested commands from official docs |
| Star Counts | MEDIUM | Some variation between sources; dates may have changed |
| Feature Descriptions | HIGH | Extracted from SKILL.md files and official docs |
| Comparisons | MEDIUM | Based on community reviews; subjective |

## Gaps to Address

- **Last Update Dates:** Many repositories don't display clear last commit dates in scraped content
- **SKILL.md Full Content:** Some skill files require direct repository access for complete configuration details
- **User Reviews:** Limited quantitative user feedback beyond star counts
- **Performance Benchmarks:** No standardized testing of output quality between skills

## Roadmap Implications

Based on this research, a UI/UX skills implementation should prioritize:

1. **Base Design Skill** - Install `frontend-design` or `taste-skill` for core generation
2. **Audit Skills** - Add `web-design-guidelines` or `baseline-ui` for quality control
3. **Accessibility** - Include `fixing-accessibility` for WCAG compliance
4. **Motion/Performance** - Consider `fixing-motion-performance` for animation optimization

**Phase Ordering Rationale:**
- Start with generation skills (immediate value)
- Add audit skills (quality improvement)
- Layer specialized skills (accessibility, motion, metadata)

**Research Flags:**
- Phase 1 (Base Skill): Standard patterns, unlikely to need deeper research
- Phase 2 (Audit Workflow): May need research on rule customization
- Phase 3 (Specialized Skills): Likely needs research on skill interactions and context management
