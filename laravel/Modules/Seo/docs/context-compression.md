# KiloCLI Contestazione Contesto Configurazione

Configurazione consigliata per gestire i limiti di token (262144) con compressione contesto:

```json
{
  "context_mode": {
    "max_tokens": 262144,
    "compression": {
      "enabled": true,
      "algorithm": "zstd",
      "buffer_size": "500MB",
      "exclude": ["code", "images", "frames"]
    }
  }
}
```

## Sezioni Principali

1. **max_tokens**: Imposta al valore massimo supportato (262144)
2. **compression.algorithum**: Utilizza zstd per la compressione efficiente
3. **buffer_size**: 500MB per ottimizzare memoria durante compressione
4. **exclude**: Esclude file che non necessitano di compressione (codice, immagini, frame video)

## Procedure di Test
- Esegui chiamata di prova con testo lungo (es. 10000 righe di commenti)
- Verifica dimensione del payload prima/subito dopo richiesta
- Monitora utilizzo token sia in CLI che tramite API

## Best Practice Kilo.ai
[RRR: Inserire link ai capitoli rilevanti della documentazione Kilo.ai]

## Configurazione Complementare
- Imposta vm.swappiness=10 nel file `/etc/sysctl.conf`
- Alloca 4GB di swap space dedicate
- Disabilita compressione per dati già compressi (es. zip/zip compresso)

# Risorse Utenza
- [KiloCLI Official Docs](https://kilo.ai/docs/)
- [Kilo Code Documentation > Context Compression](/docs/code-with-ai)[Custom Rules](/docs/code-with-ai)

# Note
- Aggiornare configurazione ogni 3 mesi con nuove release KiloCLI
- Monitorare log system per errori di compressione