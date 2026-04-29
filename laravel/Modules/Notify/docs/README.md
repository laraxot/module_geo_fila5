# FixCity Documentation

**Project**: FixCity Platform  
**Theme**: Sixteen (Active)  
**Document Root**: public_html/  
**Last Updated**: 2026-03-30

## 🚀 Quick Start

| I want to... | Go to... |
|--------------|----------|
| Understand project structure | [Project Configuration](project/configuration.md) |
| Learn AI workflow (BMAD+GSD+Ralph) | [AI Workflow](project/ai-workflow/) |
| BMAD Method (setup, antigravity) | [docs/bmad/setup-guide.md](bmad/setup-guide.md) |
| Configure MCP servers (memory, dev tools) | [MCP Servers](MCP_SERVERS.md) |
| SuperMemory setup (AI memory) | [SuperMemory Quickstart](SUPERMEMORY_QUICKSTART.md) |
| Find module documentation | [Module Index](modules/index.md) |
| Fixcity ticket wizard (Filament `Wizard` / Design Comuni) | [ticket-wizard-frontoffice.md](../laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md) |
| Find theme documentation | [Theme Index](themes/index.md) |
| Check coding standards | [Conventions](project/conventions/) |

## 📚 Documentation Sections

### Project Documentation

Documentation that applies to the entire project:

- **[Configuration](project/configuration.md)** - Theme detection, paths, environment
- **[AI Workflow](project/ai-workflow/)** - BMAD, GSD, Ralph Loop, OpenViking integration
- **[MCP Servers](MCP_SERVERS.md)** - Memory systems, development tools, configuration ⭐ NEW
- **[SuperMemory Quickstart](SUPERMEMORY_QUICKSTART.md)** - AI memory infrastructure ⭐ NEW
- **[LLM Wiki — adozione Karpathy](project/karpathy-llm-wiki-adoption.md)** - strategia, mapping repo e governance
- **[LLM Wiki canonico](wiki/README.md)** - layer compilato in `docs/wiki/`, index e log operativi
- **[QMD — ricerca locale su docs](project/qmd-local-docs-search.md)** - ricerca hybrid BM25/vettoriale su Markdown (CLI / MCP opzionale)
- **[Conventions](project/conventions/)** - Coding standards, naming, structure

### Module Documentation

Module-specific documentation:

- **[Module Index](modules/index.md)** - List of all modules with docs
- AI Module - [Docs](../../laravel/Modules/AI/docs/)
- Activity Module - [Docs](../../laravel/Modules/Activity/docs/)
- Blog Module - [Docs](../../laravel/Modules/Blog/docs/)
- [View all modules...](modules/index.md)

### Theme Documentation

Theme-specific documentation:

- **Sixteen (Active)** - [Docs](../../laravel/Themes/Sixteen/docs/)
- TwentyOne (Inactive) - [Docs](../../laravel/Themes/TwentyOne/docs/)
- **[Theme Index](themes/index.md)** - Theme comparison and guides

### Script Documentation

Utility script documentation:

- **[Bash Scripts](../../bashscripts/docs/)** - Automation scripts
- **[MCP Servers](project/mcp-servers.md)** - Model Context Protocol servers configuration and usage

- AI Scripts - [Docs](../../bashscripts/docs/ai/)
- System Scripts - [Docs](../../bashscripts/docs/system/)
- **HTML Comparison** - [Docs](../../bashscripts/docs/html/) | [Results](html-structure-comparison.md)

## 📖 Key Documents

### Essential Reading

1. **[AGENTS.md](../AGENTS.md)** - AI agent guidelines and commands
2. **[Project Configuration](project/configuration.md)** - Theme, paths, setup
3. **[AI Workflow](project/ai-workflow/)** - How to use BMAD+GSD+Ralph
4. **[MCP Servers](project/mcp-servers.md)** - Configured MCP servers and usage
5. **[Coding Conventions](project/conventions/)** - Standards and best practices

### For New Developers

1. Start with [Project Configuration](project/configuration.md)
2. Read [AI Workflow](project/ai-workflow/) to understand methodology
3. Check [Module Index](modules/index.md) for your module
4. Review [Coding Conventions](project/conventions/)

### For AI Agents

1. Read [.windsurfrules](../.windsurfrules) for project rules
2. Check [Project Configuration](project/configuration.md) for theme/paths
3. Use [Module Index](modules/index.md) to find relevant docs
4. Follow [DRY + KISS](#dry--kiss-principles) principles

## 🔍 Finding Documentation

### By Topic

| Topic | Location |
|-------|----------|
| Theme configuration | [Project Config](project/configuration.md) |
| Module development | [Module Docs](modules/index.md) |
| Frontend development | [Theme Docs](themes/index.md) |
| AI workflow | [AI Workflow](project/ai-workflow/) |
| Quality standards | [Conventions](project/conventions/) |
| Scripts | [Bash Scripts Docs](../../bashscripts/docs/) |

### By File Type

- **`.md` files**: Documentation (this index)
- **`.windsurfrules`**: AI agent rules
- **`AGENTS.md`**: Project guidelines
- **`README.md`**: Section index

## 📐 Documentation Structure

```
docs/
├── README.md                      # This file (master index)
├── wiki/                          # Compiled LLM wiki layer
│   ├── README.md                  # Workflow and mapping
│   ├── index.md                   # Compiled knowledge index
│   └── log.md                     # Append-only wiki operations
├── project/                       # Project-wide docs
│   ├── configuration.md           # Theme, paths, environment
│   ├── ai-workflow/               # BMAD, GSD, Ralph, OpenViking
│   └── conventions/               # Coding standards
├── modules/                       # Module index + links
│   └── index.md                   # List of all module docs
├── themes/                        # Theme index + links
│   └── index.md                   # List of all theme docs
└── conventions/                   # Coding conventions
    └── README.md                  # Conventions index
```

## 🎯 DRY + KISS Principles

### DRY (Don't Repeat Yourself)

**Rule**: Every piece of knowledge has ONE authoritative source.

**Implementation**:
- ✅ Project docs in `docs/`
- ✅ Module docs in `laravel/Modules/*/docs/`
- ✅ Theme docs in `laravel/Themes/*/docs/`
- ❌ NO duplicates - use cross-reference links

**Example**:
```markdown
<!-- WRONG: Duplicating content -->
# PHPStan Guide
[full content...]

<!-- CORRECT: Cross-reference -->
# PHPStan Guide
See [Xot Module PHPStan Guide](../../laravel/Modules/Xot/docs/phpstan.md)
```

### KISS (Keep It Simple, Stupid)

**Rule**: Documentation should be essential and simple.

**Implementation**:
- ✅ Essential topics only
- ✅ Max 3 levels of nesting
- ✅ Clear, descriptive filenames
- ✅ One topic per file

**Example**:
```markdown
<!-- WRONG: Too complex -->
guide/advanced/topic/subtopic/details.md (5 levels)

<!-- CORRECT: Simple -->
topic-guide.md (1 level)
```

## 🔗 Cross-Reference Guidelines

### Linking Between Sections

```markdown
# From module docs to project docs
See [Project Configuration](../../../docs/project/configuration.md)

# From theme docs to module docs
See [Predict Module](../../../laravel/Modules/Predict/docs/)

# From project docs to theme docs
See [Sixteen Theme](../../laravel/Themes/Sixteen/docs/)
```

### Link Format

- Use relative paths: `../file.md`
- Use descriptive text: `[Theme Configuration](...)`
- Avoid absolute URLs in internal links

## 📊 Documentation Health

| Metric | Target | Status |
|--------|--------|--------|
| Duplicate files | 0 | ⏳ Checking |
| Broken links | 0 | ⏳ Checking |
| Indexed docs | 100% | ✅ Complete |
| Theme accuracy | 100% Sixteen | ✅ Complete |

## 🛠️ Maintenance

### Adding New Documentation

1. **Choose location**:
   - Project-wide → `docs/project/`
   - Module-specific → `laravel/Modules/*/docs/`
   - Theme-specific → `laravel/Themes/*/docs/`

2. **Follow naming**:
   - Lowercase: `configuration.md`
   - Kebab-case: `ai-workflow.md`
   - No dates: `update.md` NOT `2026-03-30-update.md`

3. **Update index**:
   - Add link to this README
   - Add to relevant section index

4. **Cross-reference**:
   - Link to related docs
   - Add "See Also" section

### Removing Duplicates

1. **Find duplicates**:
   ```bash
   bash bashscripts/docs/find-doc-duplicates.sh
   ```

2. **Review report**:
   - Check `docs-duplicates-report.md`

3. **Consolidate**:
   - Keep one copy
   - Update references
   - Use `git mv` to preserve history

4. **Commit**:
   ```bash
   git commit -m "docs: Remove duplicates (DRY compliance)"
   ```

## 📝 Related Files

| File | Purpose |
|------|---------|
| [.windsurfrules](../.windsurfrules) | AI agent rules and project config |
| [AGENTS.md](../AGENTS.md) | Project guidelines |
| [COMMIT_MESSAGE.md](../COMMIT_MESSAGE.md) | Commit message standards |

## 🆘 Help

### Finding Documentation

**Q**: Where do I find docs for [X]?  
**A**: Check the [Module Index](modules/index.md) or [Theme Index](themes/index.md)

**Q**: How do I know which theme is active?  
**A**: See [Project Configuration](project/configuration.md) - Theme Detection Algorithm

**Q**: Where are script docs?  
**A**: [Bash Scripts Documentation](../../bashscripts/docs/)

### Contributing

1. Follow [DRY + KISS](#dry--kiss-principles)
2. Use proper [naming conventions](#adding-new-documentation)
3. Add to appropriate [index](#documentation-structure)
4. Cross-reference related docs

---

**Next Steps**:
1. [Read Project Configuration](project/configuration.md)
2. [Explore AI Workflow](project/ai-workflow/)
3. [Check Module Index](modules/index.md)

**Last Sync**: 2026-03-30  
**Maintained By**: AI Agents + Development Team
