---
name: leggi-ragiona-studia-docs
description: Regola fondamentale: Leggi → Ragiona → Studia → Aggiorna Docs + Quality Checks. Prima di modificare qualsiasi file, leggilo attentamente, poi ragiona sul contesto, studia il codice esistente e le convenzioni, infine aggiorna i docs nei moduli e nei temi. DOPO OGNI MODIFICA: esegui SEMPRE PHPStan, PHPMD e PHPInsights.
---

# Regola Fondamentale: Leggi → Ragiona → Studia → Aggiorna Docs + Quality Checks

## Prima di modificare qualsiasi file:

1. **Leggi** il file attentamente
   - Usa il tool Read per visualizzare tutto il contenuto
   - Non fare mai modifiche senza aver letto il file

2. **Ragiona** sul contesto e le implicazioni
   - Pensa a come la modifica influenzerà altre parti del sistema
   - Considera backward compatibility e side effects

3. **Studia** il codice esistente e le convenzioni
   - Controlla i pattern esistenti nel modulo/tema
   - Verifica naming conventions e style guide
   - Consulta i docs esistenti

4. **Aggiorna** i docs nelle cartelle dei moduli e dei temi
   - Aggiorna README.md se necessario
   - Aggiorna i file nella cartella docs/
   - Aggiorna le translation files

## DOPO OGNI MODIFICA - Quality Checks (OBBLIGATORI)

Esegui SEMPRE questi controlli dopo aver modificato il codice:

```bash
# PHPStan (Level 10 - obbligatorio, tutti gli errori devono essere risolti)
php -d memory_limit=2G ./vendor/bin/phpstan analyse

# PHPMD (PHP Mess Detector)
./vendor/bin/phpmd . text phpmd.xml --exclude vendor,node_modules,bootstrap,caches

# PHPInsights
./vendor/bin/phpinsights -v --no-interaction
```

Tutti gli errori di PHPStan, PHPMD e PHPInsights devono essere risolti prima di considerare completata la modifica.

## Quando Applicare

Questa regola si applica a:
- Modifiche a file PHP (models, controllers, actions, etc.)
- Modifiche a file Filament (Resources, Pages, Widgets)
- Creazione di nuove migration
- Scrittura di test
- Qualsiasi modifica al codice sorgente

## Tool Utili

- `glob` - Trova file per pattern
- `grep` - Cerca contenuto nel codice
- `read` - Leggi il contenuto di un file
- `codesearch` - Cerca documentazione esterna
