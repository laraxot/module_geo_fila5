---
name: Kilo Performance
description: Ottimizzazioni per ridurre consumo di token e migliorare latency.
type: reference
---

# Ottimizzazioni di Kilo Code

## Cache locale

Kilo utilizza una cache locale per ridurre richieste duplicate:

```bash
ls -la ~/.kilocli/cache.json
```

Pulisci la cache se necessario:

```bash
kilo cache clear
```

## Compressione del contesto

La compressione è già attiva con `context.compression = true`.

Verifica lo stato con:

```bash
mcp__plugin_context-mode_context-mode__ctx_stats
```

Output atteso:

```
With context-mode: |#####################| 13.9 KB in your conversation
Without context-mode: |########################################| 26.8 KB
```

## Limite token

`KILO_MAX_TOKENS=262144` garantisce che non si superi il limite dell'endpoint.

Se il valore viene superato, la compressione entra in azione e la risposta viene troncata o riassunta automaticamente.

## Statistiche in tempo reale

```bash
kilo stats --format json
```

Campi principali:

| Campo | Descrizione |
|-------|-------------|
| `total_tokens` | Token totali utilizzati |
| `input_tokens` | Token in input |
| `output_tokens` | Token in output |
| `cost` | Costo stimato |

## Automazione di fallback

Script Bash per monitorare e terminare sessioni in overflow:

```bash
#!/usr/bin/env bash
# monitor_kilo.sh – termina sessioni Kilo se superano il limite di token

MAX=262144
while true; do
  tokens=$(kilo stats --format json | jq '.total_tokens')
  if [[ $tokens -gt $MAX ]]; then
    echo "⚠️ Token limit exceeded ($tokens > $MAX) – terminating Kilo session."
    pkill -f "kilo"
  fi
  sleep 30
done
```

## Integrazione con context-mode

context-mode v1.0.103 fornisce:

- **ctx_stats**: monitoraggio token salvati
- **ctx_doctor**: diagnostica completa
- **ctx_upgrade**: aggiornamento automatico

Esegui diagnostics:

```bash
mcp__plugin_context-mode_context-mode__ctx_doctor
```

## Best practice

1. **Mantieni i documenti modulari**: spezzare file grandi in moduli più piccoli
2. **Usa qmd query**: ricerca nel knowledge base invece di caricare interi documenti
3. **Attiva compressione**: sempre abilitata per sessioni lunghe
4. **Monitora costi**: controlla `kilo stats` regolarmente
5. **Pulisci cache**: periodicamente con `kilo cache clear`
