# MCP (Model Context Protocol) Server Documentation

**Project**: FixCity  
**Last Updated**: 2026-04-09  
**Configuration**: `.qwen/settings.json`

---

## 📋 MCP Servers Installed & Configured

| Server | Type | Purpose | Status | Config |
|--------|------|---------|--------|--------|
| **laravel-boost** | PHP | Laravel development, routing, models, testing | ✅ Active | [laravel-boost](#laravel-boost) |
| **filament** | PHP | Filament admin panel, resources, widgets | ✅ Active | [filament](#filament) |
| **notebooklm** | Python | AI research, documentation analysis | ✅ Active | [notebooklm](#notebooklm) |
| **sequential-thinking** | Node.js | Complex reasoning, problem decomposition | ✅ Active | [sequential-thinking](#sequential-thinking) |
| **filesystem** | Node.js | File system access, directory operations | ✅ Active | [filesystem](#filesystem) |
| **puppeteer** | Node.js | Browser automation, screenshots, testing | ✅ Active | [puppeteer](#puppeteer) |
| **memory** | Node.js | Persistent context, memory management | ✅ Active | [memory](#memory) |
| **supermemory** | External API | Long-term memory, RAG, user profiles | ✅ Active | [supermemory](#supermemory) |

---

## 🔧 Server Configurations

### laravel-boost
**Command**: `php artisan boost:mcp`  
**Purpose**: Laravel development assistant  
**Capabilities**:
- Route analysis and generation
- Model relationship inspection
- Database queries
- Tinker/Debugging
- Search Laravel documentation

**Usage Example**:
```
Use laravel-boost to inspect the Ticket model relationships
```

---

### filament
**Command**: `npx -y filament-mcp-server`  
**Purpose**: FilamentPHP admin panel assistant  
**Capabilities**:
- Resource inspection
- Form schema analysis
- Table configuration
- Widget testing

**Usage Example**:
```
Use filament to check the TicketResource form schema
```

---

### notebooklm
**Command**: `uvx --from notebooklm-mcp-cli notebooklm-mcp`  
**Purpose**: AI research and documentation  
**Capabilities**:
- Research topic analysis
- Documentation synthesis
- Knowledge extraction

**Usage Example**:
```
Use notebooklm to research Bootstrap Italia color system
```

---

### sequential-thinking
**Command**: `npx -y @modelcontextprotocol/server-sequential-thinking`  
**Purpose**: Complex reasoning and problem decomposition  
**Capabilities**:
- Multi-step problem analysis
- Chain of thought reasoning
- Hypothesis generation and verification

**Usage Example**:
```
Use sequential-thinking to analyze why visual parity is at 80% instead of 90%
```

---

### filesystem
**Command**: `npx -y @modelcontextprotocol/server-filesystem /var/www/_bases/base_fixcity_fila5`  
**Purpose**: Enhanced file system access  
**Capabilities**:
- Read files with path validation
- Write files with safety checks
- List directories with filtering
- Check file existence and metadata

**Usage Example**:
```
Use filesystem to list all .blade.php files in Themes/Sixteen
```

---

### puppeteer
**Command**: `npx -y puppeteer-mcp-server`  
**Purpose**: Browser automation and testing  
**Capabilities**:
- Navigate to URLs
- Take screenshots
- Extract page content
- Execute JavaScript in browser
- Test responsive layouts

**Usage Example**:
```
Use puppeteer to take screenshot of segnalazione-01-privacy at 1440px width
```

---

### memory
**Command**: `npx -y @anthropic-ai/claude-code --mcp`  
**Purpose**: Persistent memory across sessions  
**Capabilities**:
- Store project decisions
- Remember user preferences
- Track implementation progress
- Maintain context between sessions

**Usage Example**:
```
Use memory to store the CSS color mapping decisions
```

---

### supermemory
**Type**: External API (`supermemory` npm package)  
**Purpose**: Long-term memory, RAG, user profiles  
**API Key**: Configured in `.env` (`SUPERMEMORY_API_KEY`)  
**Script**: `laravel/Themes/Sixteen/scripts/supermemory-context.js`

**Capabilities**:
- Memory API - Learned context from conversations
- User Profiles - Static + dynamic facts
- RAG - Semantic search across documents
- Container tags for isolation

**Usage Example**:
```bash
cd laravel/Themes/Sixteen
node scripts/supermemory-context.js index     # Index all docs
node scripts/supermemory-context.js query "CSS parity strategy"
node scripts/supermemory-context.js status    # Check indexed docs
```

---

## 📊 Installed Packages

### Global npm Packages
```bash
@modelcontextprotocol/server-filesystem
puppeteer-mcp-server
@anthropic-ai/claude-code
@modelcontextprotocol/server-sequential-thinking
```

### Local npm Packages (Theme)
```bash
supermemory (laravel/Themes/Sixteen/node_modules)
playwright (laravel/Themes/Sixteen/node_modules)
```

---

## 🚀 Quick Start

### Add New MCP Server

1. **Install globally**:
   ```bash
   npm install -g <mcp-server-package>
   ```

2. **Add to `.qwen/settings.json`**:
   ```json
   "mcpServers": {
     "new-server": {
       "command": "npx",
       "args": ["-y", "package-name"],
       "trust": true,
       "timeout": 30000
     }
   }
   ```

3. **Add to allowed list**:
   ```json
   "mcp": {
     "allowed": [..., "new-server"]
   }
   ```

4. **Update this documentation**

### Verify MCP Server

```bash
# Test if server is available
npx -y <package-name> --help

# Check installed servers
npm list -g --depth=0 | grep mcp
```

---

## 🔒 Security Rules

### Allowed Operations
- ✅ Read files in project directory
- ✅ Write files with validation
- ✅ Execute safe shell commands
- ✅ Browser automation for testing

### Restricted Operations
- ❌ No access to `/etc/**`, `/usr/**`
- ❌ No destructive commands (`rm -rf`, `mkfs`, etc.)
- ❌ No filesystem access outside project root

---

## 📝 Best Practices

1. **Use the right tool for the job**:
   - Laravel questions → `laravel-boost`
   - Filament questions → `filament`
   - Visual testing → `puppeteer`
   - Complex reasoning → `sequential-thinking`
   - Memory/context → `supermemory` or `memory`

2. **Document new servers**:
   - Add to this README
   - Update module/theme docs if relevant
   - Update `docs/README.md` index

3. **Test before deploying**:
   - Verify server loads correctly
   - Test basic operations
   - Check for conflicts with existing servers

---

## 🔗 Cross-References

- [Main Docs Index](../README.md)
- [Project Configuration](../project/configuration.md)
- [AI Workflow](../project/ai-workflow/)
- [Supermemory Script](../../laravel/Themes/Sixteen/scripts/supermemory-context.js)

---

**Maintained By**: AI Agents + Development Team  
**Last Updated**: 2026-04-09
