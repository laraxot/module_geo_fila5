# MCP Server Consigliati per il Modulo Setting

## Scopo del Modulo
Gestione impostazioni applicative, configurazioni e preferenze utente.

## Server MCP Consigliati
- `filesystem`: Per archiviazione e gestione file di configurazione.
- `memory`: Per caching temporaneo delle impostazioni.

## Configurazione Minima Esempio
```json
{
  "mcpServers": {
    "filesystem": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-filesystem"] },
    "memory": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-memory"] }
  }
}
```

## Note
- Personalizza la configurazione per esigenze di configurazione avanzata.
