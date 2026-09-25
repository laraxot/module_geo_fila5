<<<<<<< HEAD
---
title: "Rimando a mcp_server_recommended.md"
description: "Documento unificato: il contenuto canonico vive in mcp_server_recommended.md."
status: merged
tags: [merge, duplicato, case-only]
---

# Documento unificato

Questo file era un duplicato esatto che differiva solo per maiuscole/minuscole, in violazione della regola no-case-only-variations. Il contenuto canonico si trova in [mcp_server_recommended.md](./mcp_server_recommended.md).
=======
# MCP Server Consigliati per il Modulo Geo

## Scopo del Modulo
Gestione dati geografici, mappe e geolocalizzazione.

## Server MCP Consigliati
- `fetch`: Per recupero dati geografici da API esterne.
- `memory`: Per caching temporaneo di dati geospaziali.
- `filesystem`: Per gestione file geojson, shapefile, ecc.

## Configurazione Minima Esempio
```json
{
  "mcpServers": {
    "fetch": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-fetch"] },
    "memory": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-memory"] },
    "filesystem": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-filesystem"] }
  }
}
```

## Note
- Estendi la configurazione se il modulo gestisce analisi geospaziali avanzate.
>>>>>>> laraxot/dev
