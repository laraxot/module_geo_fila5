---
name: Kilo Integration
description: Guida all'integrazione di Kilo Code con il progetto Laravel.
type: reference
---

# Integrazione di Kilo Code

## Installazione globale

Kilo Code è installato globalmente via npm:

```bash
which kilo
# → /home/zorin/.nvm/versions/node/v25.6.0/bin/kilo
```

Verifica versione:

```bash
kilo --version
```

## Configurazione del limite di token

Imposta la variabile d'ambiente per il limite massimo di token:

```bash
export KILO_MAX_TOKENS=262144
```

Per renderla persistente, aggiungi a `~/.bashrc`:

```bash
echo 'export KILO_MAX_TOKENS=262144' >> ~/.bashrc
source ~/.bashrc
```

## Abilitazione della compressione del contesto

Il plugin context-compression è parte di **context-mode v1.0.103**. Per integrarlo con Kilo:

```bash
kilo config set context.compression true
kilo config set context.compression.maxTokens $KILO_MAX_TOKENS
```

## Verifica della configurazione

```bash
kilo config check
```

Output atteso:

```
✅ Configurazione valida
🧠 KILO_MAX_TOKENS = 262144
🧠 context.compression = true
🧠 context.compression.maxTokens = 262144
```

## Monitoraggio

Utilizza `kilo stats` per controllare il consumo di token in tempo reale:

```bash
watch -n 30 "kilo stats --format json | jq '.total_tokens'"
```

Per una visione sintetica:

```bash
kilo stats
```

## Test rapido

Esegui un test con un documento di grandi dimensioni:

```bash
kilo run "$(cat docs/wiki/second_brain.md)" --model claude-opus-4-7
```

Verifica che `total_tokens` in `kilo stats` rimanga ≤ 262144.

## Automazione di fallback

Script per terminare sessioni che superano il limite:

```bash
#!/usr/bin/env bash
# scripts/monitor_kilo.sh

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

Rendi eseguibile:

```bash
chmod +x scripts/monitor_kilo.sh
```

## Comandi utili

| Comando | Descrizione |
|---------|-------------|
| `kilo --help` | Mostra tutti i comandi disponibili |
| `kilo config check` | Verifica configurazione |
| `kilo stats` | Statistiche token e costi |
| `kilo models` | Lista modelli disponibili |
| `kilo debug` | Strumenti di debug |
