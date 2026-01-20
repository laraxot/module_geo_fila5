# Configurazione Claude Code per PTVX

---

## File di Configurazione

### 1. Configurazione Globale

**Percorso**: `~/.config/claude-code/config.json` (Linux) o `~/Library/Application Support/ClaudeCode/config.json` (macOS)

```json
{
  "editor": {
    "theme": "dark",
    "fontSize": 14
  },
  "mcp": {
    "enabled": true
  }
}
```

### 2. Configurazione Progetto

**Percorso**: `laravel/.mcp.json` (già configurato)

Questa configurazione è version-controlled e condivisa con il team.

---

## Configurazione MCP per PTVX

Il file `laravel/.mcp.json` contiene tutti i server MCP necessari:

- **laravel-boost**: Documentazione e analisi Laravel
- **filesystem**: Accesso file system del progetto
- **memory**: Memoria temporanea per contesto
- **fetch**: Chiamate HTTP/API
- **sequential-thinking**: Analisi e ottimizzazione codice
- **puppeteer**: Test UI e automazione
- **mysql**: Interazione database MySQL
- **git**: Operazioni Git

Vedi [Setup MCP](./mcp-setup.md) per dettagli completi.

---

## Variabili d'Ambiente

Per sicurezza, le credenziali database sono gestite tramite variabili d'ambiente:

```bash
export DB_HOST=localhost
export DB_PORT=3306
export DB_USERNAME=your_username
export DB_PASSWORD=your_password
export DB_DATABASE=ptvx_db
```

---

## Verifica Configurazione

```bash
# Verifica server MCP configurati
claude mcp list

# Test connessione database
claude mcp test mysql

# Verifica filesystem access
claude mcp test filesystem
```

---

## Collegamenti Correlati

- [Setup MCP](./mcp-setup.md)
- [Workflow](./workflow.md)
- [Best Practices](./best-practices.md)
