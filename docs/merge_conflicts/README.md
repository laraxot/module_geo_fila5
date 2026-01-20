# 🐄 SuperMucca Merge Conflict Resolver

Collezione di script bash per risolvere automaticamente i merge conflicts Git, accettando sempre le "incoming changes" dal branch `filament4`.
## 📁 Script Disponibili
### 1. `resolve_all_conflicts.sh` - Risolutore Base
**Uso:** Risoluzione rapida e semplice dei conflitti standard
```bash
./bashscripts/merge_conflicts/resolve_all_conflicts.sh
```
**Caratteristiche:**
- ✅ Risolve conflitti semplici automaticamente
- ✅ Crea backup di sicurezza (`.backup`)
- ✅ Statistiche dettagliate
- ✅ Conferma utente prima dell'esecuzione
- ✅ Colori per output leggibile
### 2. `advanced_conflict_resolver.sh` - Risolutore Avanzato
**Uso:** Gestione di conflitti complessi e multipli
./bashscripts/merge_conflicts/advanced_conflict_resolver.sh
- 🔍 Analizza la complessità dei conflitti
- 🧠 Gestisce conflitti multipli nello stesso file
- 🛡️ Rileva file malformati
- 📊 Categorizza i file (semplici/complessi/malformati)
- 🔄 Processamento linea per linea per casi complessi
**Quando usarlo:**
- File con conflitti multipli
- Conflitti annidati o complessi
- Quando il risolutore base fallisce
### 3. `cleanup_and_verify.sh` - Cleanup e Verifica
**Uso:** Verifica post-risoluzione e cleanup
./bashscripts/merge_conflicts/cleanup_and_verify.sh
- 🔍 Controlla conflitti residui
- 🐘 Verifica sintassi PHP
- 📊 Esegue PHPStan sui moduli critici
- 🗑️ Cleanup file di backup
- 📋 Menu interattivo
- 🔄 Controllo stato Git
## 🚀 Workflow Consigliato
### Scenario 1: Conflitti Semplici
# 1. Risolvi i conflitti
# 2. Verifica e cleanup
# 3. Committa
git add .
git commit -m "Resolve merge conflicts - accept filament4 changes"
### Scenario 2: Conflitti Complessi
# 1. Usa il risolutore avanzato
# 2. Verifica accuratamente
# 3. Test aggiuntivi se necessario
./vendor/bin/phpstan analyze Modules --level=9
# 4. Committa
git commit -m "Resolve complex merge conflicts - accept filament4 changes"
## 🛡️ Sicurezza e Backup
### File di Backup
Gli script creano automaticamente backup:
- `.backup` - Risolutore base
- `.advanced_backup` - Risolutore avanzato
### Rimuovere i Backup
# Manuale
find . -name "*.backup" -delete
find . -name "*.advanced_backup" -delete
# Tramite script di cleanup
# Scegli opzione 5
### Ripristino di Emergenza
# Ripristina un singolo file
mv file.php.backup file.php
# Ripristina tutti i file
find . -name "*.backup" -exec bash -c 'mv "$1" "${1%.backup}"' _ {} \;
## 🔧 Personalizzazione
### Modificare la Strategia di Risoluzione
Per accettare le "current changes" invece delle "incoming changes", modifica negli script:
# Cambia da:
# A:
### Aggiungere Altri Tipi di File
Modifica il pattern di ricerca:
# Da:
## 🐛 Troubleshooting
### Problema: "Permission denied"
chmod +x bashscripts/merge_conflicts/*.sh
### Problema: "File malformati"
I file con conflitti malformati richiedono intervento manuale:
1. Apri il file in un editor
2. Cerca i marker di conflitto
3. Risolvi manualmente
4. Rimuovi i marker
### Problema: "Errori di sintassi PHP"
Dopo la risoluzione automatica:
1. Esegui il cleanup script
2. Controlla gli errori segnalati
3. Correggi manualmente i file problematici
### Problema: "PHPStan errors"
# Test specifico su un modulo
./vendor/bin/phpstan analyze Modules/NomeModulo --level=8
# Con più dettagli
./vendor/bin/phpstan analyze Modules/NomeModulo --level=8 -v
## 📊 Statistiche e Logging
Gli script forniscono statistiche dettagliate:
- Numero totale di file processati
- File risolti con successo
- File saltati o con errori
- Conflitti complessi gestiti
## 🤝 Contribuire
Per migliorare gli script:
1. Testa su diversi tipi di conflitti
2. Aggiungi gestione per nuovi edge case
3. Migliora l'output e la user experience
4. Aggiungi supporto per altri tipi di file
## 📝 Note Tecniche
### Strategia di Risoluzione
- **HEAD section**: Rimossa (versione corrente/locale)
- **Incoming section**: Mantenuta (versione filament4)
- **Marker removal**: Tutti i marker Git vengono rimossi
### Limitazioni
- Non gestisce conflitti in file binari
- Richiede marker Git standard
- Non supporta merge tools esterni
### Compatibilità
- ✅ Bash 4.0+
- ✅ GNU sed
- ✅ Git 2.0+
- ✅ PHP 7.4+ (per syntax check)
---
**Creato da SuperMucca AI Assistant 🐄**  
*"Perché anche i conflitti Git meritano una risoluzione elegante!"*
