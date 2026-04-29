# 📓 NotebookLM MCP Installation

**Date**: 2026-03-30  
**Platform**: MCP Server  
**Status**: 🟡 INSTALLING

---

## 📋 What is NotebookLM MCP?

NotebookLM MCP is a Model Context Protocol server that provides:
- Source-grounded research
- Document analysis
- Knowledge synthesis
- Citation tracking

**Integration**: Works with MCP-compatible AI agents

---

## 🔧 Installation Steps

### Step 1: Install MCP Client

Ensure your AI agent supports MCP:
- Claude Code: ✅ Supports MCP
- Cursor: ✅ Supports MCP
- Others: Check documentation

### Step 2: Install NotebookLM MCP

```bash
# Via MCP marketplace
mcp install notebooklm

# Or manually
git clone https://github.com/google/notebooklm-mcp.git
cd notebooklm-mcp
npm install
npm run build
```

### Step 3: Configure MCP Settings

Add to your MCP config file (`~/.mcp.json` or agent-specific config):

```json
{
  "mcpServers": {
    "notebooklm": {
      "command": "node",
      "args": ["/path/to/notebooklm-mcp/dist/index.js"],
      "env": {
        "NOTEBOOKLM_API_KEY": "your-api-key"
      }
    }
  }
}
```

### Step 4: Verify Installation

Restart your AI agent and ask:
```
"Research Design Comuni design patterns"
```

---

## 🎯 Research Topics for FixCity

| Topic | Purpose |
|-------|---------|
| **Bootstrap Italia Components** | Understand component structure |
| **Design Comuni Patterns** | Extract layout patterns |
| **WCAG 2.1 Accessibility** | Accessibility requirements |
| **Responsive Design** | Mobile-first patterns |
| **Color Contrast** | AGID color requirements |
| **Typography** | Font requirements |
| **Navigation Patterns** | Menu structures |
| **Form Design** | Accessible forms |

---

## 📐 Integration with FixCity

### Workflow Example

```
User: "Research accessibility requirements for Design Comuni"

NotebookLM MCP Flow:
1. Search sources
   - Design Comuni documentation
   - WCAG 2.1 guidelines
   - AGID accessibility requirements

2. Synthesize information
   - Color contrast ratios
   - Keyboard navigation
   - Screen reader support
   - ARIA requirements

3. Provide citations
   - Link to specific sections
   - Reference documentation
   - Quote requirements

4. Store in OpenViking
   - Save research results
   - Link to implementation tasks
   - Track compliance
```

---

## ✅ Installation Checklist

- [ ] Verify MCP client support
- [ ] Install NotebookLM MCP
- [ ] Configure MCP settings
- [ ] Test with research query
- [ ] Integrate with OpenViking
- [ ] Document workflow

---

## 🔗 Related Tools

| Tool | Status | Integration |
|------|--------|-------------|
| **OpenViking** | ✅ Installed | Context storage |
| **BMAD** | ✅ Cloned | Architecture |
| **GSD** | ✅ Cloned | Phase execution |
| **Ralph Loop** | ✅ Cloned | Implementation |
| **Superpowers** | ⚪ Pending | Workflow |

---

**Next**: Install MCP server and verify
