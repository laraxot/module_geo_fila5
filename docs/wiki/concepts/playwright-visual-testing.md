---
title: Playwright — Visual Testing MapPicker
description: Uso di Playwright MCP per verificare visualmente il MapPicker e componenti mappa
tags: [playwright, screenshot, map-picker, leaflet, visual-testing]
---

# Playwright — Visual Testing MapPicker

Per verificare visualmente il componente MapPicker (Leaflet + Lit Web Component) usare il Playwright MCP server:

```
browser_navigate → http://127.0.0.1:8000/it/segnalazione/crea
browser_screenshot → verifica rendering mappa, marker, controlli fullscreen
```

## Scenari da verificare

- Mappa inizializzata con marker centrato sulla posizione di default (Roma)
- Click sulla mappa → marker si sposta, input lat/lng aggiornati
- Drag del marker → stessa sincronizzazione
- Toggle fullscreen → mappa si espande, `invalidateSize()` chiamato
- Switch layer stradale/satellitare
- Input lat/lng manuale → marker si sposta sulla mappa

## Documentazione di riferimento

Vedere: `docs/wiki/concepts/playwright-mcp-screenshots.md` (root project)
