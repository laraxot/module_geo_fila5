# UI/UX Skills Comprehensive Comparison Table

**Researched:** March 30, 2026
**Total Skills Analyzed:** 15+ across 9 repositories

## Master Comparison Table

| # | Skill Name | Repository | Stars | Forks | Last Update | Installation | Compatibility | Confidence |
|---|------------|-----------|-------|-------|-------------|--------------|---------------|------------|
| 1 | **frontend-design** | anthropics/skills | 106k | 11.8k | Active | `npx skills add anthropics/skills --skill frontend-design` | Claude Code, Codex, Cursor, Gemini CLI, Copilot | HIGH |
| 2 | **ui-ux-pro-max** | nextlevelbuilder/ui-ux-pro-max-skill | 54.9k | 5.3k | Mar 10, 2026 (v2.5.0) | `/plugin marketplace add nextlevelbuilder/ui-ux-pro-max-skill` or `npm install -g uipro-cli` | Claude Code, Cursor, Windsurf, Copilot | HIGH |
| 3 | **web-design-guidelines** | vercel-labs/agent-skills | 24.1k | 2.2k | Active | `npx skills add vercel-labs/agent-skills --skill web-design-guidelines` | Claude Code, Cursor, Codex, Gemini CLI, Copilot | HIGH |
| 4 | **taste-skill** | Leonxlnx/taste-skill | 6.5k | 613 | Active | `npx skills add https://github.com/Leonxlnx/taste-skill` | Claude Code, Cursor, Antigravity, Codex, Windsurf, Copilot | HIGH |
| 5 | **impeccable** | pbakaus/impeccable | 10k+ | N/A | Active | `npx skills add pbakaus/impeccable` | Claude Code, Codex, Cursor | MEDIUM |
| 6 | **ui-skills** | ibelick/ui-skills | 1.1k | 49 | Active | `npx skills add ibelick/ui-skills` | Claude Code, Cursor, VS Code | HIGH |
| 7 | **bencium-marketplace** | bencium/bencium-marketplace | 121 | 19 | Active | `npx skills add bencium/bencium-marketplace --all` | Claude Code, Codex, Gemini CLI, Cursor, Windsurf, Copilot | HIGH |
| 8 | **frontend-design** | vnzzzz/frontend-design (Smithery) | N/A | N/A | N/A | `npx @smithery/cli@latest skill add vnzzzz/frontend-design` | Claude Code, Cursor, GitHub Copilot, Gemini CLI | MEDIUM |
| 9 | **designer-skills** | Owl-Listener/designer-skills | 164 | N/A | Active | `/plugin marketplace add Owl-Listener/designer-skills` | Claude Code | MEDIUM |
| 10 | **ui-design-brain** | carmahhawwari/ui-design-brain | 600+ | N/A | Active | Manual (clone + copy to /skills) | Claude Code, Compatible agents | MEDIUM |
| 11 | **ux-researcher-designer** | davila7/claude-code-templates | 23k+ (repo) | N/A | Active | `npx skills add davila7/claude-code-templates --skill ux-researcher-designer` | Claude Code | MEDIUM |
| 12 | **react-best-practices** | vercel-labs/agent-skills | 24.1k (repo) | 2.2k | Active | `npx skills add vercel-labs/agent-skills --skill react-best-practices` | Claude Code, Cursor, Codex | HIGH |
| 13 | **composition-patterns** | vercel-labs/agent-skills | 24.1k (repo) | 2.2k | Active | `npx skills add vercel-labs/agent-skills --skill composition-patterns` | Claude Code, Cursor | HIGH |
| 14 | **webapp-testing** | anthropics/skills | 106k (repo) | 11.8k | Active | `npx skills add anthropics/skills --skill webapp-testing` | Claude Code | HIGH |
| 15 | **Solo Design Studio** | Paid Product (Gumroad) | N/A | N/A | N/A | Purchase ($99) + manual install | Claude Code | MEDIUM |

---

## Detailed Skill Breakdown

### 1. frontend-design (Anthropic Official)

| Attribute | Details |
|-----------|---------|
| **Repository** | https://github.com/anthropics/skills |
| **Stars/Forks** | 106k / 11.8k |
| **Installation** | `npx skills add anthropics/skills --skill frontend-design` |
| **Description** | Create distinctive, production-grade frontend interfaces with high design quality. Avoids generic "AI slop" aesthetics. |
| **Key Features** | - Design thinking framework (Purpose, Tone, Constraints, Differentiation)<br>- Typography guidelines (no Inter/Roboto/Arial)<br>- Color & theme systems with CSS variables<br>- Motion prioritization (CSS-only or Motion library)<br>- Spatial composition (asymmetry, overlap, diagonal flow)<br>- Background depth (gradients, noise, geometric patterns) |
| **Usage Examples** | - "Build a landing page for a productivity app. Typographic focus, dark editorial aesthetic."<br>- "Create a music player interface. Maximalist, tactile, 90s hardware-inspired." |
| **Dependencies** | None |
| **Best For** | General frontend development, avoiding generic AI aesthetics |
| **Confidence** | HIGH (Official Anthropic skill) |

---

### 2. ui-ux-pro-max

| Attribute | Details |
|-----------|---------|
| **Repository** | https://github.com/nextlevelbuilder/ui-ux-pro-max-skill |
| **Stars/Forks** | 54.9k / 5.3k |
| **Last Update** | March 10, 2026 (Release v2.5.0) |
| **Installation** | `/plugin marketplace add nextlevelbuilder/ui-ux-pro-max-skill` OR `npm install -g uipro-cli && uipro init --ai claude` |
| **Description** | Comprehensive design intelligence database with 57 UI styles, 95 color schemes, 50+ font pairings, 99 UX guidelines, 25 chart types. |
| **Key Features** | - AI-powered Design System Generator with 161 industry-specific reasoning rules<br>- 57 UI styles (Neumorphism, Acid Design, Corporate Minimalist, etc.)<br>- 95 production-grade, accessibility-tested color schemes<br>- Cross-platform adaptation logic (React Native vs Next.js)<br>- WCAG 2.1 contrast standards enforcement<br>- Design token injection system |
| **Usage Examples** | - Skill Mode: "Build a landing page for my SaaS product"<br>- Workflow Mode: `/ui-ux-pro-max Build a landing page for my SaaS product`<br>- Design System: `python3 .claude/skills/ui-ux-pro-max/scripts/search.py "beauty spa wellness" --design-system` |
| **Dependencies** | Python 3.x, Node.js/npm |
| **Best For** | Large-scale projects requiring persistent design systems, accessibility-first design |
| **Confidence** | HIGH |

---

### 3. web-design-guidelines (Vercel)

| Attribute | Details |
|-----------|---------|
| **Repository** | https://github.com/vercel-labs/agent-skills |
| **Stars/Forks** | 24.1k / 2.2k |
| **Installation** | `npx skills add vercel-labs/agent-skills --skill web-design-guidelines` |
| **Description** | Review UI code for compliance with web interface best practices. Audits against 100+ rules covering accessibility, performance, and UX. |
| **Key Features** | - 100+ audit rules<br>- Auto-syncs latest guidelines from source repository<br>- Validates files against all defined rules<br>- Outputs violations in `file:line` format<br>- Covers ARIA, focus states, semantic HTML, keyboard navigation |
| **Usage Examples** | - `/web-design-guidelines src/components/**/*.tsx`<br>- "Review my UI code for accessibility issues"<br>- "Audit this form component against web interface best practices" |
| **Dependencies** | None |
| **Best For** | Code review, accessibility audits, quality assurance |
| **Confidence** | HIGH (Official Vercel skill) |

---

### 4. taste-skill

| Attribute | Details |
|-----------|---------|
| **Repository** | https://github.com/Leonxlnx/taste-skill |
| **Stars/Forks** | 6.5k / 613 |
| **Installation** | `npx skills add https://github.com/Leonxlnx/taste-skill` |
| **Description** | Collection of skills that improve how AI tools write frontend code, enabling modern, premium designs with proper animations, spacing, and visual quality. |
| **Key Features** | - **taste-skill**: Main design skill (layout, typography, colors, spacing, motion)<br>- **redesign-skill**: Project upgrader (audits existing projects)<br>- **soft-skill**: Soft UI aesthetic (premium fonts, whitespace, depth, spring animations)<br>- **output-skill**: Quality control (prevents AI laziness, placeholder comments)<br>- **minimalist-skill**: Editorial style (Notion/Linear-inspired)<br>- **brutalist-skill**: Raw mechanical aesthetic (Swiss typography + CRT terminal)<br>- **stitch-skill**: Semantic design (Google Stitch-compatible)<br>- Configurable parameters: DESIGN_VARIANCE (1-10), MOTION_INTENSITY (1-10), VISUAL_DENSITY (1-10) |
| **Usage Examples** | - Install full pack and invoke via `/taste-skill`<br>- Adjust settings in SKILL.md for desired aesthetic |
| **Dependencies** | None (framework-agnostic) |
| **Best For** | Premium/luxury brands, e-commerce, creative portfolios |
| **Confidence** | HIGH |

---

### 5. impeccable

| Attribute | Details |
|-----------|---------|
| **Repository** | https://github.com/pbakaus/impeccable |
| **Stars** | 10k+ |
| **Installation** | `npx skills add pbakaus/impeccable` |
| **Description** | Enhanced frontend design skill with 17 design commands for precise workflow control and optimization. |
| **Key Features** | - 17 design commands<br>- `/polish` - Refine existing designs<br>- `/audit` - Design review<br>- `/distill` - Extract design principles<br>- `/enhance` - Add visual improvements<br>- `/refine` - Iterative refinement |
| **Usage Examples** | - `/polish src/components/`<br>- `/audit src/pages/` |
| **Dependencies** | None |
| **Best For** | Professionals needing granular control over design iterations |
| **Confidence** | MEDIUM (Limited source data) |

---

### 6. ui-skills (ibelick)

| Attribute | Details |
|-----------|---------|
| **Repository** | https://github.com/ibelick/ui-skills |
| **Stars/Forks** | 1.1k / 49 |
| **Installation** | `npx skills add ibelick/ui-skills` or `npx ui-skills add <skill-name>` |
| **Description** | Set of 15 independent, modular skills focused on specific UI problems, allowing on-demand installation. |
| **Key Features** | - **baseline-ui**: Opinionated UI baseline, removes "AI slop"<br>- **fixing-accessibility**: Keyboard navigation, labels, focus rings, semantic HTML<br>- **fixing-motion-performance**: Safe, performance-first UI motion, prefers-reduced-motion compliance<br>- **fixing-metadata**: Page titles, meta tags, social cards (SEO)<br>- **12-principles-of-animation**: Animation best practices<br>- **responsive-design**: Responsive design audits |
| **Usage Examples** | - `/baseline-ui review src/`<br>- Recommended workflow:<br>  1. `/frontend-design` (generate)<br>  2. `/baseline-ui` (polish)<br>  3. `/fixing-accessibility` (a11y)<br>  4. `/fixing-motion-performance` (motion) |
| **Dependencies** | None |
| **Best For** | Modular workflows, teams wanting to pick specific improvements |
| **Confidence** | HIGH |

---

### 7. bencium-marketplace

| Attribute | Details |
|-----------|---------|
| **Repository** | https://github.com/bencium/bencium-marketplace |
| **Stars/Forks** | 121 / 19 |
| **Installation** | `npx skills add bencium/bencium-marketplace --all` or individual: `npx skills add bencium/bencium-marketplace -g --skill <skill-name>` |
| **Description** | Claude Code plugin marketplace with 6 design skills for systematic UX, innovative design, production interfaces, audits, typography, and relationship design. |
| **Key Features** | - **bencium-controlled-ux-designer**: Systematic UX (WCAG 2.1 AA, mathematical scales, enterprise)<br>- **bencium-innovative-ux-designer**: Bold creative UX (shadows, gradients, experimental typography)<br>- **bencium-impact-designer**: Production-grade interfaces (avoids generic AI aesthetics)<br>- **design-audit**: Systematic visual UI/UX audits (implementation-ready plans)<br>- **typography**: Professional typography rules (quote marks, dashes, spacing)<br>- **relationship-design**: AI-first interfaces with memory and trust evolution |
| **Usage Examples** | - `npx skills add bencium/bencium-marketplace -g --skill typography`<br>- `/plugin install bencium-controlled-ux-designer@bencium-marketplace` |
| **Dependencies** | Node.js (for npx), Claude Code or compatible agent |
| **Best For** | Enterprise design systems, typography-heavy projects |
| **Confidence** | HIGH |

---

### 8. frontend-design (Smithery - vnzzzz)

| Attribute | Details |
|-----------|---------|
| **Repository** | https://smithery.ai/skills/vnzzzz/frontend-design |
| **Installs** | 219 |
| **Installation** | `npx @smithery/cli@latest skill add vnzzzz/frontend-design` |
| **Description** | Create distinctive, production-grade frontend interfaces with high design quality. |
| **Key Features** | - Design thinking (Purpose, Tone, Constraints, Differentiation)<br>- Typography (non-default fonts)<br>- Color (strong palettes)<br>- Motion (meaningful animations)<br>- Spatial composition<br>- Background details<br>- Avoids generic AI aesthetics |
| **Usage Examples** | - Use for UI tasks involving web components, pages, applications<br>- Combine with repository UI/UX requirements (e.g., `docs/ui/requirements.md`) |
| **Dependencies** | None specified |
| **Best For** | General frontend development |
| **Confidence** | MEDIUM |

---

### 9. designer-skills (Owl-Listener)

| Attribute | Details |
|-----------|---------|
| **Repository** | https://github.com/Owl-Listener/designer-skills |
| **Stars** | 164 |
| **Installation** | `/plugin marketplace add Owl-Listener/designer-skills` |
| **Description** | Complete designer toolbox with 63 skills and 27 commands covering full design lifecycle. |
| **Key Features** | - 8 domains: User Research, Design Systems, UX Strategy, UI Design, Interaction Design, Prototype Testing, Design Ops, Toolkits<br>- Figma integration<br>- 27 commands for specific workflows |
| **Usage Examples** | - Domain-specific skill invocation |
| **Dependencies** | None |
| **Best For** | Full-stack designers, UX teams |
| **Confidence** | MEDIUM |

---

### 10. ui-design-brain

| Attribute | Details |
|-----------|---------|
| **Repository** | https://github.com/carmahhawwari/ui-design-brain |
| **Stars** | 600+ |
| **Installation** | Manual (clone + copy md files to `/skills`) |
| **Description** | Library of 60+ component best practices from component.gallery, replacing AI guessing with established knowledge. |
| **Key Features** | - 60+ UI components (buttons, forms, nav, etc.)<br>- 5 design styles (SaaS, Minimal, Enterprise, Creative, Data Dashboard)<br>- Anti-pattern library<br>- Layout patterns<br>- Accessibility rules<br>- Auto-activates during UI construction |
| **Usage Examples** | - Auto-activates when building UI components |
| **Dependencies** | None |
| **Best For** | Component library development, design system consistency |
| **Confidence** | MEDIUM |

---

### 11. ux-researcher-designer

| Attribute | Details |
|-----------|---------|
| **Repository** | https://github.com/davila7/claude-code-templates |
| **Stars** | 23k+ (repository) |
| **Installation** | `npx skills add davila7/claude-code-templates --skill ux-researcher-designer` |
| **Description** | Focuses on UX research methodologies and design processes. |
| **Key Features** | - Research methods<br>- Usability testing design<br>- User journey mapping<br>- Information architecture planning<br>- Design decision documentation |
| **Usage Examples** | - UX research workflows<br>- Usability testing planning |
| **Dependencies** | None |
| **Best For** | UX researchers, product designers |
| **Confidence** | MEDIUM |

---

### 12-14. Vercel Agent Skills (react-best-practices, composition-patterns, react-native-skills)

| Attribute | Details |
|-----------|---------|
| **Repository** | https://github.com/vercel-labs/agent-skills |
| **Stars/Forks** | 24.1k / 2.2k |
| **Installation** | `npx skills add vercel-labs/agent-skills --skill <skill-name>` |
| **Descriptions** | - **react-best-practices**: 57 performance optimization rules for React/Next.js<br>- **composition-patterns**: Compound components, context providers, clean APIs<br>- **react-native-skills**: 16 rules for React Native/Expo |
| **Usage Examples** | - "Review this component for performance issues"<br>- "Refactor to use compound components" |
| **Best For** | React/Next.js performance, component architecture |
| **Confidence** | HIGH (Official Vercel) |

---

### 15. Solo Design Studio (Paid)

| Attribute | Details |
|-----------|---------|
| **Source** | Gumroad ($99) |
| **Installation** | Purchase → Unzip → Place files in project |
| **Description** | Paid product with 40 skills, 6 agents, 14 knowledge notes for product designers. |
| **Key Features** | - **audit-ux**: 50-point heuristic evaluation<br>- **extract-style**: Figma to design tokens<br>- **design-critique**: 6 evaluation frameworks<br>- **spec-doc**: Specification documents<br>- **stakeholder-comms**: Executive communications<br>- **build-frontend**: Figma to code<br>- **ux-teardown**: Competitive audits<br>- **case-study**: Portfolio pieces |
| **Usage Examples** | - `/audit-ux https://competitor.com/checkout`<br>- `/extract-style design-system` |
| **Best For** | Professional product designers, UX consultants |
| **Confidence** | MEDIUM (Paid product, limited public info) |

---

## Feature Comparison Matrix

| Feature | frontend-design (Anthropic) | ui-ux-pro-max | taste-skill | web-design-guidelines | ui-skills |
|---------|----------------------------|---------------|-------------|----------------------|-----------|
| **Design Generation** | ✅ Excellent | ✅ Excellent | ✅ Excellent | ❌ Audit only | ❌ Polish only |
| **Design Audit** | ❌ | ✅ Built-in | ✅ (redesign-skill) | ✅ Excellent (100+ rules) | ✅ Good |
| **Accessibility** | ⚠️ Basic | ✅ WCAG 2.1 enforced | ⚠️ Basic | ✅ Excellent | ✅ Dedicated skill |
| **Typography** | ✅ Strong guidelines | ✅ 50+ pairings | ✅ Premium fonts | ⚠️ Audit only | ⚠️ Basic |
| **Motion/Animation** | ✅ Guidelines | ✅ 25 chart types | ✅ Spring animations | ⚠️ Audit only | ✅ Dedicated skill |
| **Color Systems** | ✅ CSS variables | ✅ 95 palettes | ✅ Premium palettes | ⚠️ Audit only | ⚠️ Basic |
| **Component Library** | ❌ | ✅ 57 styles | ❌ | ❌ | ⚠️ Basic |
| **Figma Integration** | ❌ | ❌ | ❌ | ❌ | ❌ |
| **Design Tokens** | ❌ | ✅ Yes | ❌ | ❌ | ❌ |
| **Modular** | ❌ Monolithic | ⚠️ Partial | ✅ 7 sub-skills | ❌ Monolithic | ✅ 15 skills |
| **Weekly Installs** | 110k+ | N/A | N/A | 133.4k+ | N/A |

---

## Installation Quick Reference

### Universal Installation (Skills.sh)
```bash
# Anthropic frontend-design
npx skills add anthropics/skills --skill frontend-design

# Vercel web-design-guidelines
npx skills add vercel-labs/agent-skills --skill web-design-guidelines

# Taste skill (full pack)
npx skills add https://github.com/Leonxlnx/taste-skill

# UI skills (ibelick)
npx skills add ibelick/ui-skills

# Bencium marketplace (all skills)
npx skills add bencium/bencium-marketplace --all

# UI UX Pro Max
npx skills add nextlevelbuilder/ui-ux-pro-max-skill
```

### Claude Code Plugin System
```bash
# Add Anthropics marketplace
/plugin marketplace add anthropics/skills
/plugin install document-skills@anthropic-agent-skills

# Add UI UX Pro Max
/plugin marketplace add nextlevelbuilder/ui-ux-pro-max-skill

# Add Bencium marketplace
/plugin marketplace add bencium/bencium-marketplace
/plugin install bencium-controlled-ux-designer@bencium-marketplace
```

### Smithery CLI
```bash
npx @smithery/cli@latest skill add vnzzzz/frontend-design
```

### Manual Installation
```bash
# Clone repository
git clone https://github.com/anthropics/skills.git

# Copy skills to .claude/skills/
cp -r skills/.claude/skills/ ~/.claude/skills/
```

---

## Sources

- https://github.com/anthropics/skills
- https://github.com/nextlevelbuilder/ui-ux-pro-max-skill
- https://github.com/vercel-labs/agent-skills
- https://github.com/Leonxlnx/taste-skill
- https://github.com/ibelick/ui-skills
- https://github.com/bencium/bencium-marketplace
- https://smithery.ai/skills/vnzzzz/frontend-design
- https://claude.com/blog/improving-frontend-design-through-skills
- https://ricoui.com/blog/top-8-design-skills/
- https://www.agensi.io/learn/best-claude-code-frontend-skills
- https://dev.to/blamsa0mine/claude-code-skills-install-ui-skills-build-a-frontend-design-workflow-claude-code-cursorvs-4n43
- https://composio.dev/content/top-claude-skills
- https://solodesign.cc/blog/claude-code-for-designers/
