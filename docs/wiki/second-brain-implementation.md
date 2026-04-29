# Second Brain Implementation - Sistema di Gestione della Conoscenza

## Panoramica
Il sistema Second Brain implementato segue i principi di **Tiago Forte (PARA Method)** e **Niklas Luhmann (Zettelkasten)** adattati al progetto Laravel.

## Struttura PARA
```
docs/wiki/
├── projects/       # Progetti attivi (es. implementazione nuova feature)
├── areas/          # Aree di responsabilità (es. documentazione moduli)
├── resources/      # Risorse riutilizzabili (es. pattern architetturali)
└── archives/       # Archivio (es. documentazione obsoleta)
```

## Principi Zettelkasten
- **Note Atomiche**: ogni nota tratta un solo concetto
- **Collegamenti Bidirezionali**: `[[note-id]]` per collegare idee
- **Identificativi Unici**: timestamp o codice breve (es. `z2026-04-29-001`)

## Implementazione nei Moduli
Ogni modulo segue la struttura:
```
laravel/Modules/{Module}/docs/wiki/
├── projects/        # Progetti specifici del modulo
├── areas/          # Aree di competenza del modulo
├── resources/       # Risorse condivisibili
├── archives/        # Documentazione archiviata
└── inbox/          # Note in arrivo (da processare)
```

## Implementazione nei Temi
```
laravel/Themes/{Theme}/docs/wiki/
├── projects/        # Progetti di tema
├── areas/          # Aree di design
├── resources/       # Componenti riutilizzabili
└── archives/        # Versioni precedenti
```

## Automazione
- **QMD Query**: `qmd query "topic"` per cercare nel knowledge base
- **ctx_search**: ricerca semantica nei documenti indicizzati
- **kilo stats**: monitoraggio token per sessioni lunghe

## Flusso di Lavoro
1. **Captura**: note in `inbox/`
2. **Processamento**: conversione in note atomiche
3. **Organizzazione**: spostamento in PARA (projects/areas/resources/archives)
4. **Collegamento**: aggiunta riferimenti bidirezionali
5. **Revisione**: settimanale con `ctx_stats` e `qmd query`

## Template Disponibili
- `PARA-note-template.md`: note strutturate per progetti/aree
- `zettelkasten-note-template.md`: note atomiche pure

## Metriche di Successo
- Riduzione tempo di ricerca: target 30%
- Copertura documentale: 100% moduli attivi
- Collegamenti attivi: minimo 3 per nota

## Prossimi Passi
1. Migrare documentazione esistente in struttura PARA
2. Creare note atomiche per ogni pattern architetturale
3. Implementare automazione per nuove note
