# 📚 FixCity Platform - Documentation Index

> **Last Updated**: 2026-03-31
> **Status**: ✅ Active  
> **Version**: 2.0

---

## 🎯 Quick Navigation

### For Developers
- 🚀 [Getting Started](quick-start.md)
- 📄 **Theme Sixteen — parity HTML `<body>`** (Design Comuni: body minimale, scope CSS su wrapper): [html-parity-body-policy.md](../laravel/Themes/Sixteen/docs/html-parity-body-policy.md)
- 🧭 **Wizard segnalazione-crea — geolocalizzazione step 2 e `?step=`** (doc modulo + story): [ticket-wizard-frontoffice.md](../laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md) · [story 7-33](../_bmad-output/implementation-artifacts/7-33-segnalazione-crea-step2-geolocation-use-my-location-and-step-query.md)
- 📖 [AGENTS.md](../../AGENTS.md) - Main development guide
- 🏗️ [Architecture](architecture/README.md)
- 📝 [Conventions](conventions/README.md)
- 🧪 [Testing](testing/README.md)

### For Product Teams
- 🗺️ [Product Roadmaps](roadmaps/README.md)
- 📊 [Analytics](analytics/README.md)
- 💡 [Feature Requests](feature-requests.md)

### For Operations
- 🔧 [Deployment](deployment/README.md)
- 🌐 [VHost Apache - fixcity.local](deployment/vhost-fixcity.md)
- 📈 [Monitoring](monitoring/README.md)
- 🔒 [Security](security/README.md)

### AI Agent Tools
- ⚡ [Superpowers Framework](superpowers.md) - Agentic skills (TDD, brainstorming, code review)
- 🧩 [Plugins & Skills](../.opencode/PLUGINS_AND_SKILLS.md) - Full plugin inventory

---

## 📁 Documentation Structure

```
docs/
├── architecture/           # System architecture docs
├── conventions/            # Coding standards & conventions
├── deployment/             # Deployment guides
├── fixes/                  # Bug fixes & solutions
├── github/                 # GitHub workflows
├── mcp/                    # MCP configuration
├── monitoring/             # Monitoring & logging
├── project/                # Project configuration & vhost
│   ├── README.md          # Project docs index
│   └── vhost-configuration.md  # Apache vhost for fixcity.local
├── quality/                # Quality assurance
├── regole-critiche/        # Critical rules (Italian)
├── rules/                  # Governance rules (English)
│   ├── README.md          # Rules index
│   └── vhost-governance.md  # VHost mandatory rules
├── roadmaps/               # Product roadmaps
├── security/               # Security documentation
├── superpowers/            # Superpowers framework docs
│   ├── README.md          # Overview & workflow
│   ├── installation.md    # Installation guide
│   ├── workflow.md        # Detailed workflow
│   └── skills-reference.md # All skills
├── testing/                # Testing guides
└── index.md               # This file
```

---

## 🔥 Recent Updates

### 2026-03-31
- ✅ Superpowers framework installed and configured
- ✅ Complete Superpowers documentation (4 files)
- ✅ Apache vhost configuration for fixcity.local
- ✅ VHost documentation across all layers (project, modules, themes)
- ✅ Document root governance: public_html/
- ✅ Governance rules created in docs/rules/

### 2026-03-13
- ✅ Database naming convention standardized
- ✅ .gitattributes files removed (now in .gitignore)
- ✅ MCP GitHub configuration added
- ✅ GitHub Issue #5 created
- ✅ Ollama optimization guide

---

## 📊 Documentation Status

| Category | Files | Status | Last Updated |
|----------|-------|--------|--------------|
| Architecture | 15+ | ✅ Active | 2026-03 |
| Conventions | 8+ | ✅ Active | 2026-03-13 |
| Deployment | 5+ | ✅ Active | 2026-02 |
| Fixes | 12+ | ✅ Active | 2026-03-13 |
| Quality | 20+ | ✅ Active | 2026-03 |
| Testing | 10+ | ✅ Active | 2026-02 |

---

## 🎓 Learning Paths

### New Developer Onboarding
1. [Quick Start](quick-start.md)
2. [AGENTS.md](../../AGENTS.md)
3. [Architecture Overview](architecture/overview.md)
4. [Conventions](conventions/README.md)
5. [First PR Guide](contributing/first-pr.md)

### Module Developer
1. [Module Structure](modules/structure.md)
2. [Best Practices](modules/best-practices.md)
3. [Testing Modules](modules/testing.md)
4. [Documentation](modules/documentation.md)

### DevOps Engineer
1. [Deployment Guide](deployment/README.md)
2. [Monitoring Setup](monitoring/setup.md)
3. [Backup Strategy](operations/backup.md)
4. [Disaster Recovery](operations/disaster-recovery.md)

---

## 🔍 Search Tips

### By Topic
```bash
# Search all docs
grep -r "your-topic" docs/

# Search specific category
grep -r "your-topic" docs/architecture/

# Search module docs
grep -r "your-topic" laravel/Modules/*/docs/
```

### By File Type
```bash
# Find all README files
find docs/ -name "README.md"

# Find all roadmap files
find docs/ -name "*roadmap.md"

# Find all convention files
find docs/ -name "*convention*.md"
```

---

## 📝 Contributing to Documentation

### Writing Guidelines
1. **Use clear headings** - H1 for title, H2 for sections
2. **Include examples** - Code blocks with language tags
3. **Add metadata** - Last updated, status, owner
4. **Link related docs** - Use relative paths
5. **Keep it current** - Update when code changes

### Documentation Standards
- **Markdown**: Use GitHub-flavored markdown
- **Language**: English (technical), Italian (comments)
- **Format**: .md files with .md extension
- **Location**: docs/ for project, Module/docs/ for modules

### Review Process
1. Write draft
2. Self-review
3. Peer review
4. Merge to main
5. Announce in #docs channel

---

## 🛠️ Documentation Tools

### Generation
- **phpDocumentor**: PHP API docs
- **Typedoc**: TypeScript docs
- **Mermaid**: Diagrams

### Validation
- **markdownlint**: Markdown linting
- **prettier**: Formatting
- **alex**: Inclusive language

### Publishing
- **GitBook**: Internal wiki
- **GitHub Pages**: Public docs
- **Notion**: Team collaboration

---

## 📞 Support

### Getting Help
- **Slack**: #documentation
- **Email**: docs @fixcity.example.com
- **GitHub**: Create issue with label `documentation`

### Documentation Team
- **Lead**: @marco76tv
- **Contributors**: [View contributors](https://github.com/laraxot/base_fixcity_fila5/graphs/contributors)

---

## 🔗 External Resources

### Laravel
- [Laravel Documentation](https://laravel.com/docs)
- [Laracasts](https://laracasts.com)
- [Laravel News](https://laravel-news.com)

### PHP
- [PHP Documentation](https://www.php.net/docs.php)
- [PHP The Right Way](https://phptherightway.com)
- [PSR Standards](https://www.php-fig.org/psr/)

### Tools
- [Git Documentation](https://git-scm.com/doc)
- [GitHub Docs](https://docs.github.com)
- [Markdown Guide](https://www.markdownguide.org)

---

**Maintainer**: @marco76tv  
**Contact**: docs @fixcity.example.com  
**Last Review**: 2026-03-13
