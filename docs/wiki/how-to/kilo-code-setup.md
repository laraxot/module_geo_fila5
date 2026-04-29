---
name: Kilo Code Setup and Configuration Guide
description: Complete guide to installing and configuring Kilo Code for the PTVX project
type: how-to
related: [qmd-search-guide.md, context-mode-overflow-prevention.md]
---

# Kilo Code Setup and Configuration Guide

Kilo Code is an open-source AI coding assistant that works in your IDE, terminal, or browser. This guide covers installation, configuration, and usage for the PTVX project.

## What is Kilo Code?

Kilo Code provides:
- **AI-powered coding** — Generate, refactor, and debug code through conversation
- **IDE integration** — Works in VS Code, JetBrains, and other editors
- **Wiki integration** — Direct access to project documentation (QMD + context-mode)
- **Automation** — AI-powered code reviews, testing, and PR generation
- **Multi-platform** — CLI, IDE extensions, web, mobile

See: [kilo.ai/docs](https://kilo.ai/docs/)

## Installation

### Step 1: Install Globally (Already Done)

Kilo Code is installed globally at version 7.2.25:

```bash
npm list -g @kilocode/cli
# /home/zorin/.nvm/versions/node/v25.6.0/lib
# └── @kilocode/cli@7.2.25
```

### Step 2: Verify Installation

```bash
kilo --version
# 7.2.25
```

### Step 3: Install IDE Extensions

#### VS Code

```bash
code --install-extension kilocode.kilo-code
```

Or via VS Code Extensions marketplace: Search "Kilo Code"

#### JetBrains (IntelliJ, PyCharm, WebStorm)

1. Open IDE → Settings/Preferences → Plugins
2. Search "Kilo Code"
3. Install and restart

#### Cursor / Windsurf

Comes pre-installed with Kilo Code integration.

## Configuration

### Project Configuration

A `.kilo.jsonc` file is provided in the project root:

```
<project>/.kilo.jsonc
```

This configures:
- AI provider (Claude via Anthropic API)
- Codebase context (modules, themes, scripts)
- Wiki integration (QMD collections)
- Context-mode settings (token overflow prevention)
- Testing and git integration

### Home Directory Configuration

Copy to home directory for global settings:

```bash
cp .kilo.jsonc ~/.kilo.jsonc
```

Or configure per-project (recommended to keep settings isolated):

```bash
# Use project-level config
kilo config --config .kilo.jsonc
```

### Configuration Options

Key settings in `.kilo.jsonc`:

```jsonc
{
  // AI Provider
  "defaultModel": "claude-sonnet-4-6",
  "models": {
    "code-analysis": "claude-opus-4-7",     // Complex analysis
    "documentation": "claude-sonnet-4-6",   // Doc writing
    "quick-questions": "claude-haiku-4-5"   // Fast answers
  },

  // Project Context
  "codebaseContext": {
    "rootPath": "/var/www/_bases/base_ptvx_fila5",
    "language": "php",
    "framework": "laravel"
  },

  // Wiki Integration
  "wiki": {
    "enabled": true,
    "collections": ["project-wiki", "module-wikis", "theme-wikis"]
  },

  // QMD Integration
  "qmd": {
    "enabled": true,
    "semanticSearchEnabled": true,
    "performanceTarget": 2000  // milliseconds
  },

  // Context-Mode
  "contextMode": {
    "sandboxProcessing": true,
    "overflowPrevention": { "enabled": true }
  }
}
```

## Setting Up AI Provider

### Option 1: Use Claude API (Recommended)

1. **Get API Key**:
   - Go to [anthropic.com/api](https://www.anthropic.com/api)
   - Create account and generate API key

2. **Set Environment Variable**:
   ```bash
   export ANTHROPIC_API_KEY="sk-ant-..."
   ```

3. **Verify in Kilo**:
   ```bash
   kilo config --show
   ```

### Option 2: Use Kilo's Built-in Credits

Kilo Code offers built-in credits (limited free usage):

```bash
# Kilo will prompt for auth on first use
kilo chat
```

### Option 3: Use Ollama (Local Models)

```bash
# Install Ollama
brew install ollama  # macOS
# or download from ollama.ai for Linux/Windows

# Start Ollama server
ollama serve

# Configure Kilo
kilo config --add-model ollama:llama2
```

## Using Kilo Code

### CLI Usage

```bash
# Start interactive chat
kilo chat

# Ask a question
kilo ask "How does the Activity module track events?"

# Generate code
kilo generate "Create a GDPR consent form component"

# Explain code
kilo explain path/to/file.php

# Run a task
kilo task "Add missing docstrings to module"
```

### IDE Integration

#### VS Code

1. Open Kilo sidebar (Kilo icon in activity bar)
2. Ask questions in chat
3. Use code actions (right-click → Kilo → ...)
4. Reference files with `@filename` mentions

#### JetBrains

1. Open Kilo sidebar
2. Use Alt+K (Windows/Linux) or Cmd+K (Mac) to open chat
3. Select code and ask for help
4. Use Kilo code actions from context menu

### Key Features

#### Context Mentions

Reference files, functions, or symbols:

```
@src/Models/User.php
@function getPermissions
@symbol DatabaseMigration

Explain how this works and suggest improvements
```

#### Wiki Context

Access project documentation directly:

```
Using context from @docs/wiki/concepts/actions-over-services.md

Refactor this service to use the Actions pattern
```

#### Multi-File Editing

Ask Kilo to modify multiple files:

```
@laravel/Modules/Gdpr/app/Models/Consent.php
@laravel/Modules/Gdpr/app/Models/Profile.php

Add missing relationships and validation
```

#### Task Breakdown

Ask for complex work to be broken down:

```
@docs/wiki/how-to/ Implement QMD search integration

Break down the work into steps
```

## Workflow: Development with Kilo

### 1. Starting a New Feature

```bash
# Ask Kilo for context from docs
kilo chat
> @docs/wiki/concepts/actions-over-services.md
> How should I implement this feature using the Actions pattern?

# Kilo suggests approach based on project patterns
```

### 2. Implementing

```bash
# Use Kilo in IDE for assistance
# VS Code: Open Kilo sidebar, ask questions while coding
# @mention files or functions you're working on
```

### 3. Writing Tests

```bash
kilo task
> @tests/ @laravel/Modules/Gdpr/app/Models

Add comprehensive tests for this module
```

### 4. Documentation

```bash
kilo generate
> @docs/wiki/module-wikis/gdpr Create implementation guide for consent workflow
```

### 5. Code Review

```bash
kilo ask
> @laravel/Modules/Gdpr/app/Models Review this code for security and performance issues
```

## Integration with Project Tools

### QMD Search

Kilo can search your wiki via QMD:

```bash
kilo ask
> Search the wiki for "consent workflow" and summarize related patterns
```

### Context-Mode

Kilo respects context-mode overflow prevention:

```
Kilo automatically uses:
- sandbox processing (ctx_execute, ctx_batch_execute)
- selective indexing (docs only)
- token-efficient queries
```

### Git Integration

```bash
kilo task
> Generate commit message for recent changes

# Kilo analyzes diff and suggests conventional commit
```

## Customization

### Add Custom Agents/Modes

Extend `.kilo.jsonc`:

```jsonc
{
  "customAgents": [
    {
      "name": "wiki-generator",
      "description": "Generate wiki documentation",
      "systemPrompt": "You help generate wiki content following the project's documentation standards"
    },
    {
      "name": "qmd-indexer",
      "description": "Help index content with QMD",
      "systemPrompt": "You help create well-indexed markdown documentation for QMD"
    }
  ]
}
```

### Custom Rules

Create `.kilo/rules.md` for project-specific guidelines:

```markdown
# Kilo Code Rules for PTVX

## Code Standards
- Use Laravel Actions pattern for business logic
- Add docstrings following phpDocumentor format
- Reference wiki documentation where relevant

## Documentation Standards
- All documentation goes in docs/wiki/ or module/theme wikis
- Use YAML frontmatter with qmd keywords
- Cross-reference using relative paths or qmd:// URLs

## Testing
- Require tests for all public methods
- Use integration tests for database operations
- Reference test coverage expectations
```

Then configure:
```jsonc
{
  "customRules": {
    "enabled": true,
    "path": ".kilo/rules.md"
  }
}
```

## Troubleshooting

### Connection Issues

**Issue**: "Cannot connect to AI provider"

**Solution**:
```bash
# Check API key
echo $ANTHROPIC_API_KEY

# Test connection
kilo ask "What is 2+2?"

# Check config
kilo config --show
```

### Model Issues

**Issue**: "Model not available"

**Solution**:
```bash
# List available models
kilo list-models

# Check .kilo.jsonc for valid model names
# Claude models: claude-opus-4-7, claude-sonnet-4-6, claude-haiku-4-5-20251001
```

### Context Limits

**Issue**: "Context length exceeded"

**Solution**:
- Kilo respects context-mode overflow prevention automatically
- Use specific file references instead of broad `@*` mentions
- Break large tasks into smaller steps
- See: [Context-Mode Overflow Prevention](./context-mode-overflow-prevention.md)

### Wiki Not Accessible

**Issue**: "Cannot find wiki documents"

**Solution**:
```bash
# Verify QMD is working
qmd status

# Check collections are indexed
qmd ls

# Force re-embed
qmd embed --collection wiki
qmd embed --collection module_*
```

## Best Practices

### 1. Reference Documentation

Always mention relevant wiki pages:

```
@docs/wiki/concepts/actions-over-services.md
@docs/wiki/how-to/qmd-search-guide.md

Implement this feature following these patterns
```

### 2. Provide Context

More specific context → better suggestions:

```bash
# ✅ Good: Mentions specific context
@laravel/Modules/Gdpr/app/Models/Consent.php
@docs/wiki/how-to/module-wiki-documentation.md

Refactor this model following documentation best practices

# ❌ Poor: Too vague
Refactor the code
```

### 3. Break Down Complex Tasks

Let Kilo help organize work:

```
@docs/wiki/implementation-artifacts/2-1-qmd-search-integration.md

Break down this story into concrete steps
```

### 4. Leverage Multiple Models

Use appropriate models for different tasks:

```jsonc
{
  "models": {
    "code-analysis": "claude-opus-4-7",      // Complex analysis
    "documentation": "claude-sonnet-4-6",    // Writing docs
    "quick-questions": "claude-haiku-4-5"    // Q&A
  }
}
```

## Performance Tips

### Faster Responses

1. **Use appropriate model** — haiku-4-5 for quick questions
2. **Limit file context** — Reference specific files, not entire modules
3. **Enable caching** — Already enabled in config
4. **Use CLI** — Faster than IDE for simple tasks

### Reducing Token Usage

1. **Be specific** — Narrow file mentions to exact files needed
2. **Reuse context** — Ask follow-up questions in same session
3. **Use smaller models** — haiku-4-5 uses fewer tokens
4. **Enable sandbox** — context-mode reduces token overhead

## Learning Resources

- [Kilo Code Documentation](https://kilo.ai/docs/)
- [Kilo GitHub Repository](https://github.com/Kilo-Org/kilocode)
- [Getting Started Guide](https://kilo.ai/docs/getting-started)
- [FAQ](https://kilo.ai/docs/getting-started/faq)

## Next Steps

1. **Install IDE extension** — VS Code or JetBrains
2. **Set API key** — `export ANTHROPIC_API_KEY="..."`
3. **Test integration** — `kilo chat` or open IDE
4. **Reference wiki** — Use `@docs/wiki/` in prompts
5. **Use in workflow** — Leverage for code generation, testing, docs

---

**Last Updated**: 2026-04-29  
**Status**: Active  
**Related Stories**: Story 2.1 (QMD Search Integration), Epic 3 (Advanced Knowledge Search)
