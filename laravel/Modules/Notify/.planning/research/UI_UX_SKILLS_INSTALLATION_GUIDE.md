# UI/UX Skills Installation Guide

**Last Updated:** March 30, 2026

## Quick Start: Recommended Installations

### For Most Users (Best Value)
```bash
# Install the essential 3-skill workflow
npx skills add anthropics/skills --skill frontend-design
npx skills add ibelick/ui-skills
npx skills add vercel-labs/agent-skills --skill web-design-guidelines
```

This gives you:
- **frontend-design**: Generate distinctive interfaces
- **baseline-ui + fixing-accessibility + fixing-motion-performance**: Polish and audit
- **web-design-guidelines**: 100+ rule compliance check

### For Design-Focused Projects
```bash
# Premium design stack
npx skills add https://github.com/Leonxlnx/taste-skill
npx skills add nextlevelbuilder/ui-ux-pro-max-skill
npx skills add bencium/bencium-marketplace --skill typography
```

### For Enterprise/Production
```bash
# Enterprise-grade stack
npx skills add anthropics/skills --skill frontend-design
npx skills add ibelick/ui-skills --all
npx skills add vercel-labs/agent-skills --skill react-best-practices
npx skills add vercel-labs/agent-skills --skill web-design-guidelines
npx skills add anthropics/skills --skill webapp-testing
```

---

## Installation Methods

### Method 1: Skills.sh CLI (Recommended - Universal)

The `npx skills` command is the universal installer for Claude Code skills.

#### Prerequisites
- Node.js 18+ installed
- npm/npx available in PATH

#### Basic Installation
```bash
# Install a single skill from a repository
npx skills add <repository-url> --skill <skill-name>

# Install all skills from a repository
npx skills add <repository-url> --all

# List available skills before installing
npx skills add <repository-url> --list
```

#### Examples
```bash
# Anthropic frontend-design
npx skills add anthropics/skills --skill frontend-design

# Vercel web-design-guidelines
npx skills add vercel-labs/agent-skills --skill web-design-guidelines

# Full taste-skill pack
npx skills add https://github.com/Leonxlnx/taste-skill

# All UI skills from ibelick
npx skills add ibelick/ui-skills --all

# Specific skill from ibelick
npx skills add ibelick/ui-skills --skill baseline-ui

# All bencium design skills
npx skills add bencium/bencium-marketplace --all

# Specific bencium skill
npx skills add bencium/bencium-marketplace --skill typography
```

#### Global vs Local Installation
```bash
# Global installation (available in all projects)
npx skills add <repository> -g --skill <skill-name>

# Local installation (project-specific)
npx skills add <repository> --skill <skill-name>
```

---

### Method 2: Claude Code Plugin System

Claude Code has a built-in plugin marketplace.

#### Add a Marketplace Repository
```bash
/plugin marketplace add <repository>
```

#### Browse and Install
```bash
# Open interactive installer
/plugin marketplace add anthropics/skills

# Then select:
# 1. Browse and install plugins
# 2. Select marketplace (e.g., anthropic-agent-skills)
# 3. Choose skill package (e.g., document-skills, example-skills)
# 4. Install now
```

#### Direct Installation
```bash
# Install specific plugin from marketplace
/plugin install <plugin-name>@<marketplace>

# Examples
/plugin install document-skills@anthropic-agent-skills
/plugin install example-skills@anthropic-agent-skills
/plugin install bencium-controlled-ux-designer@bencium-marketplace
```

#### Available Marketplaces
```bash
# Anthropic official skills
/plugin marketplace add anthropics/skills

# UI UX Pro Max
/plugin marketplace add nextlevelbuilder/ui-ux-pro-max-skill

# Bencium marketplace
/plugin marketplace add bencium/bencium-marketplace

# Designer skills
/plugin marketplace add Owl-Listener/designer-skills
```

---

### Method 3: Smithery CLI

For skills hosted on Smithery platform.

#### Installation
```bash
npx @smithery/cli@latest skill add <skill-id>

# Example
npx @smithery/cli@latest skill add vnzzzz/frontend-design
```

#### Prerequisites
- Node.js 18+
- Smithery CLI (installed automatically via npx)

---

### Method 4: UI Pro CLI (UI-UX-PRO-MAX Specific)

Dedicated CLI for UI UX Pro Max skill.

#### Installation
```bash
# Install CLI globally
npm install -g uipro-cli

# Initialize in project
cd /path/to/your/project
uipro init --ai claude

# Supports other AI tools
uipro init --ai cursor
uipro init --ai windsurf
uipro init --ai copilot
```

#### Usage
```bash
# Use design system generator
python3 .claude/skills/ui-ux-pro-max/scripts/search.py "beauty spa wellness" --design-system
```

---

### Method 5: Manual Installation

For skills not available via package managers or for custom skills.

#### Step 1: Clone Repository
```bash
git clone https://github.com/anthropics/skills.git
```

#### Step 2: Copy Skills
```bash
# Create skills directory if it doesn't exist
mkdir -p ~/.claude/skills/

# Copy skill folders
cp -r skills/.claude/skills/frontend-design ~/.claude/skills/
cp -r skills/.claude/skills/webapp-testing ~/.claude/skills/
```

#### Step 3: Verify Installation
```bash
# Check skills directory
ls ~/.claude/skills/

# Should see skill folders with SKILL.md files
```

#### Project-Specific Installation
```bash
# For project-specific skills
mkdir -p ./.claude/skills/
cp -r /path/to/skill/* ./.claude/skills/
```

---

## Skill-Specific Installation Guides

### 1. frontend-design (Anthropic)

```bash
# Option A: Skills.sh (Recommended)
npx skills add anthropics/skills --skill frontend-design

# Option B: Claude Code Plugin
/plugin marketplace add anthropics/skills
/plugin install example-skills@anthropic-agent-skills

# Option C: Manual
mkdir -p ~/.claude/skills/frontend-design
# Copy SKILL.md from repository
```

**Verify:**
```bash
ls ~/.claude/skills/frontend-design/SKILL.md
```

**Usage:**
```
/frontend-design Build a landing page for a productivity app
```

---

### 2. ui-ux-pro-max

```bash
# Option A: Claude Code Plugin
/plugin marketplace add nextlevelbuilder/ui-ux-pro-max-skill

# Option B: UI Pro CLI (Recommended)
npm install -g uipro-cli
uipro init --ai claude

# Option C: Skills.sh
npx skills add nextlevelbuilder/ui-ux-pro-max-skill
```

**Verify:**
```bash
ls ~/.claude/skills/ui-ux-pro-max/
# Should see: SKILL.md, data/, scripts/
```

**Usage:**
```
# Skill Mode (auto-activate)
Build a landing page for my SaaS product

# Workflow Mode
/ui-ux-pro-max Build a landing page for my SaaS product

# Design System Command
python3 .claude/skills/ui-ux-pro-max/scripts/search.py "beauty spa wellness" --design-system
```

---

### 3. taste-skill

```bash
# Skills.sh (Recommended)
npx skills add https://github.com/Leonxlnx/taste-skill
```

**Included Sub-Skills:**
- taste-skill (main)
- redesign-skill
- soft-skill
- output-skill
- minimalist-skill
- brutalist-skill (BETA)
- stitch-skill

**Verify:**
```bash
ls ~/.claude/skills/taste-skill/
```

**Configuration:**
Edit `~/.claude/skills/taste-skill/SKILL.md` to adjust:
- DESIGN_VARIANCE (1-10): Layout experimentalism
- MOTION_INTENSITY (1-10): Animation level
- VISUAL_DENSITY (1-10): Content density

**Usage:**
```
/taste-skill Build a luxury e-commerce homepage
/redesign-skill Audit and improve @src/pages/
/soft-skill Create a premium SaaS dashboard
```

---

### 4. web-design-guidelines (Vercel)

```bash
# Skills.sh
npx skills add vercel-labs/agent-skills --skill web-design-guidelines

# Or install entire Vercel pack
npx skills add vercel-labs/agent-skills --all
```

**Included Vercel Skills:**
- web-design-guidelines
- react-best-practices
- react-native-skills
- composition-patterns

**Verify:**
```bash
ls ~/.claude/skills/web-design-guidelines/
```

**Usage:**
```
/web-design-guidelines src/components/**/*.tsx

# Or natural language
Review my UI code for accessibility issues
Audit this form component against web interface best practices
```

---

### 5. ui-skills (ibelick)

```bash
# Install all skills
npx skills add ibelick/ui-skills --all

# Install specific skills
npx ui-skills add baseline-ui
npx ui-skills add fixing-accessibility
npx ui-skills add fixing-motion-performance
npx ui-skills add fixing-metadata
```

**Included Skills:**
- baseline-ui
- fixing-accessibility
- fixing-motion-performance
- fixing-metadata
- 12-principles-of-animation
- responsive-design

**Verify:**
```bash
ls ~/.claude/skills/ui-skills/
```

**Usage:**
```
# Recommended workflow
/frontend-design Build @src/pages/HabitFocus.vue
/baseline-ui src/pages/HabitFocus.vue
/fixing-accessibility src/pages/HabitFocus.vue
/fixing-motion-performance src/pages/HabitFocus.vue
```

---

### 6. bencium-marketplace

```bash
# Install all 6 design skills
npx skills add bencium/bencium-marketplace --all

# Install specific skills
npx skills add bencium/bencium-marketplace --skill typography
npx skills add bencium/bencium-marketplace --skill design-audit
npx skills add bencium/bencium-marketplace --skill bencium-impact-designer

# List available skills
npx skills add bencium/bencium-marketplace --list
```

**Included Design Skills:**
- bencium-controlled-ux-designer
- bencium-innovative-ux-designer
- bencium-impact-designer
- design-audit
- typography
- relationship-design

**Verify:**
```bash
ls ~/.claude/skills/bencium-marketplace/
```

**Usage:**
```
/bencium-controlled-ux-designer Design a checkout flow
/design-audit src/components/
/typography Review this landing page
```

---

### 7. impeccable

```bash
npx skills add pbakaus/impeccable
```

**Included Commands:**
- /polish
- /audit
- /distill
- /enhance
- /refine
- (17 total commands)

**Usage:**
```
/polish src/components/
/audit src/pages/
/distill Extract design principles from @src/
```

---

### 8. frontend-design (Smithery - vnzzzz)

```bash
npx @smithery/cli@latest skill add vnzzzz/frontend-design
```

**Usage:**
```
/frontend-design Create a music player interface
```

---

## Post-Installation Verification

### Check Installed Skills
```bash
# List all installed skills
ls ~/.claude/skills/

# Or for project-specific
ls ./.claude/skills/
```

### Test Skill Activation
```bash
# In Claude Code, test skill invocation
claude-code

# Then ask:
"List my available skills"
"Use the frontend-design skill to build a landing page"
```

### Verify Skill Files
Each skill should have:
```
skill-name/
├── SKILL.md          # Required: Skill definition
├── plugin.json       # Optional: Plugin metadata
└── [scripts/]        # Optional: Helper scripts
```

---

## Troubleshooting

### Skill Not Found
```bash
# Verify installation
ls ~/.claude/skills/<skill-name>/SKILL.md

# If missing, reinstall
npx skills add <repository> --skill <skill-name>
```

### Skill Not Auto-Activating
Some skills require explicit invocation:
```
# Use slash command
/<skill-name> <task>

# Or mention in prompt
"Use the frontend-design skill to..."
```

### Permission Errors
```bash
# Fix permissions on skills directory
chmod -R 755 ~/.claude/skills/
```

### Skills Not Loading in Claude Code
```bash
# Restart Claude Code
# Clear cache if needed
rm -rf ~/.claude/cache/
```

### Version Conflicts
```bash
# Update skills.sh
npm update -g skills

# Or reinstall
npm uninstall -g skills
npm install -g skills
```

---

## Configuration Options

### Global Settings (~/.claude/settings.json)

Add spinner verbs for better UX:
```json
{
  "spinner_verbs": ["designing", "polishing", "auditing", "refining"]
}
```

### Skill-Specific Configuration

Edit SKILL.md files to customize:
```yaml
# ~/.claude/skills/taste-skill/SKILL.md
---
name: taste-skill
description: Premium frontend design
settings:
  DESIGN_VARIANCE: 7  # 1-10
  MOTION_INTENSITY: 6  # 1-10
  VISUAL_DENSITY: 4  # 1-10
---
```

### Project-Specific Overrides
```bash
# Create project-specific skill overrides
mkdir -p ./.claude/skills/
cp ~/.claude/skills/frontend-design/SKILL.md ./.claude/skills/frontend-design/
# Edit with project-specific guidelines
```

---

## Best Practices

### 1. Start Small
Begin with 1-2 core skills, then add based on need:
```bash
# Start with these two
npx skills add anthropics/skills --skill frontend-design
npx skills add ibelick/ui-skills --skill baseline-ui
```

### 2. Avoid Skill Bloat
Too many skills can cause:
- Context overhead
- Conflicting instructions
- Slower response times

**Recommended maximum:** 5-7 active skills

### 3. Use Modular Skills
Prefer modular skills (like ibelick/ui-skills) where you can install only what you need:
```bash
# Install only needed skills
npx ui-skills add baseline-ui
npx ui-skills add fixing-accessibility
# Skip fixing-metadata if not needed
```

### 4. Keep Skills Updated
```bash
# Reinstall to get latest version
npx skills add <repository> --skill <skill-name> --force
```

### 5. Document Your Stack
Create a `.claude/SKILLS.md` in your project:
```markdown
# Project Skills

## Installed
- frontend-design (Anthropic)
- baseline-ui (ibelick)
- fixing-accessibility (ibelick)

## Usage
/frontend-design for new components
/baseline-ui for polish
/fixing-accessibility before commit
```

---

## Quick Reference Card

| Skill | Install Command | Invoke |
|-------|----------------|--------|
| frontend-design | `npx skills add anthropics/skills --skill frontend-design` | `/frontend-design` |
| ui-ux-pro-max | `/plugin marketplace add nextlevelbuilder/ui-ux-pro-max-skill` | `/ui-ux-pro-max` |
| taste-skill | `npx skills add https://github.com/Leonxlnx/taste-skill` | `/taste-skill` |
| web-design-guidelines | `npx skills add vercel-labs/agent-skills --skill web-design-guidelines` | `/web-design-guidelines` |
| baseline-ui | `npx skills add ibelick/ui-skills --skill baseline-ui` | `/baseline-ui` |
| fixing-accessibility | `npx skills add ibelick/ui-skills --skill fixing-accessibility` | `/fixing-accessibility` |
| design-audit | `npx skills add bencium/bencium-marketplace --skill design-audit` | `/design-audit` |
| typography | `npx skills add bencium/bencium-marketplace --skill typography` | `/typography` |

---

## Additional Resources

- **Anthropic Skills Documentation:** https://github.com/anthropics/skills
- **Skills.sh Documentation:** https://skills.sh
- **Smithery Skills:** https://smithery.ai
- **Claude Code Blog:** https://claude.com/blog/improving-frontend-design-through-skills
- **Community Skills List:** https://composio.dev/content/top-claude-skills

---

## Support

For issues with specific skills:
1. Check the skill's GitHub repository issues
2. Review SKILL.md for configuration options
3. Try reinstalling the skill
4. Check Claude Code version compatibility

For general skills questions:
- Claude Code Discord
- r/ClaudeCode subreddit
- Skills.sh documentation
