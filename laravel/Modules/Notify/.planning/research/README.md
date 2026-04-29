# UI/UX Skills Research Index

**Created:** March 30, 2026
**Last Updated:** March 30, 2026

## Research Files

This directory contains comprehensive research on UI/UX and frontend design skills for Claude Code and other AI coding agents.

| File | Purpose | Size |
|------|---------|------|
| [`UI_UX_SKILLS_SUMMARY.md`](./UI_UX_SKILLS_SUMMARY.md) | Executive summary with roadmap implications | ~8KB |
| [`UI_UX_SKILLS_COMPARISON.md`](./UI_UX_SKILLS_COMPARISON.md) | Detailed comparison table of 15+ skills | ~25KB |
| [`UI_UX_SKILLS_INSTALLATION_GUIDE.md`](./UI_UX_SKILLS_INSTALLATION_GUIDE.md) | Step-by-step installation instructions | ~18KB |

## Quick Navigation

### Start Here
1. **New to UI/UX Skills?** → Read [`UI_UX_SKILLS_SUMMARY.md`](./UI_UX_SKILLS_SUMMARY.md) first
2. **Want to compare skills?** → See [`UI_UX_SKILLS_COMPARISON.md`](./UI_UX_SKILLS_COMPARISON.md)
3. **Ready to install?** → Follow [`UI_UX_SKILLS_INSTALLATION_GUIDE.md`](./UI_UX_SKILLS_INSTALLATION_GUIDE.md)

## Key Findings Summary

### Top 5 Skills by Popularity
1. **frontend-design** (Anthropic) - 106k stars
2. **ui-ux-pro-max** - 54.9k stars
3. **web-design-guidelines** (Vercel) - 24.1k stars
4. **taste-skill** - 6.5k stars
5. **impeccable** - 10k stars

### Recommended Starter Stack
```bash
# Essential 3-skill workflow
npx skills add anthropics/skills --skill frontend-design
npx skills add ibelick/ui-skills
npx skills add vercel-labs/agent-skills --skill web-design-guidelines
```

### Installation Methods
- **Universal:** `npx skills add <repository> --skill <skill-name>`
- **Claude Code:** `/plugin marketplace add <repository>`
- **Smithery:** `npx @smithery/cli@latest skill add <skill-id>`
- **Manual:** Copy to `~/.claude/skills/`

## Skill Categories

### Design Generation
- `frontend-design` (Anthropic)
- `ui-ux-pro-max`
- `taste-skill`
- `impeccable`
- `frontend-design` (Smithery)

### Design Audit
- `web-design-guidelines` (Vercel)
- `design-audit` (bencium)
- `baseline-ui` (ibelick)

### Design Polish
- `fixing-accessibility` (ibelick)
- `fixing-motion-performance` (ibelick)
- `fixing-metadata` (ibelick)
- `typography` (bencium)

### Specialized
- `react-best-practices` (Vercel)
- `composition-patterns` (Vercel)
- `webapp-testing` (Anthropic)
- `ux-researcher-designer`

## Research Methodology

### Sources Investigated
1. GitHub repositories (9 official)
2. Official documentation (Anthropic, Vercel)
3. Community articles and reviews
4. Skill marketplaces (Smithery, MCP Market)

### Confidence Levels
- **HIGH:** Verified with official docs + multiple sources
- **MEDIUM:** Single source or community reports
- **LOW:** Unverified claims (flagged in reports)

### Data Collected
- Skill names and descriptions
- Installation commands
- Usage examples
- Star counts and fork counts
- Last update dates (when available)
- Compatibility information
- Dependencies

## Gaps and Limitations

### Known Gaps
- Some skill repositories don't display clear last commit dates
- Full SKILL.md content requires direct repository access for some skills
- Limited quantitative user feedback beyond star counts
- No standardized performance benchmarks between skills

### Areas for Future Research
- User satisfaction surveys
- Output quality comparisons
- Context overhead measurements
- Skill interaction effects

## Related Research

### Internal Documents
- See `.planning/research/` for other domain research

### External Resources
- [Anthropic Skills Repository](https://github.com/anthropics/skills)
- [Vercel Agent Skills](https://github.com/vercel-labs/agent-skills)
- [Claude Code Blog - Skills](https://claude.com/blog/improving-frontend-design-through-skills)
- [Skills.sh Documentation](https://skills.sh)

## Update History

| Date | Change | Author |
|------|--------|--------|
| 2026-03-30 | Initial research complete | Research Agent |

## How to Use This Research

### For Roadmap Planning
1. Read `UI_UX_SKILLS_SUMMARY.md` for executive overview
2. Review "Recommended Skill Combinations" section
3. Note "Research Flags for Phases" in summary

### For Implementation
1. Consult `UI_UX_SKILLS_INSTALLATION_GUIDE.md`
2. Follow "Quick Start: Recommended Installations"
3. Use troubleshooting section if needed

### For Skill Selection
1. See `UI_UX_SKILLS_COMPARISON.md` for detailed matrix
2. Compare features across top skills
3. Check compatibility with your tech stack

## Contact

For questions about this research:
- Review the source files linked in each document
- Check the "Additional Resources" sections
- Refer to official skill documentation

---

**Research Status:** ✅ Complete
**Next Steps:** Use findings to inform roadmap creation in `.planning/roadmap/`
