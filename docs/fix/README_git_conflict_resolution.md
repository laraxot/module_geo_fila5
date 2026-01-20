# Git Conflict Resolution Scripts

Collezione di script per la risoluzione automatica dei conflitti Git mantenendo sempre la "current version" (HEAD).
## 📁 Script Disponibili
### 1. `auto_resolve_git_conflicts.sh`
**Scopo**: Risoluzione automatica completa di tutti i conflitti Git nel progetto.
**Caratteristiche**:
- Processamento completo di tutti i file con conflitti
- Backup automatico prima della risoluzione
- Validazione PHP per i file `.php`
- Validazione JSON per i file `.json`
- Logging dettagliato con colori
- Report finale completo
**Utilizzo**:
```bash
./bashscripts/fix/auto_resolve_git_conflicts.sh
```
**Output**:
- Crea una cartella di backup `conflict_backup_YYYYMMDD_HHMMSS`
- Log colorato con timestamp
- Report finale con statistiche
---
### 2. `batch_resolve_git_conflicts.sh`
**Scopo**: Risoluzione controllata in batch per grandi quantità di conflitti.
- Processamento a lotti configurabile
- Ideale per progetti con molti conflitti
- Controllo granulare del numero di file processati
- Monitoraggio dei conflitti rimanenti
# Processa 10 file (default)
./bashscripts/fix/batch_resolve_git_conflicts.sh
# Processa 5 file
./bashscripts/fix/batch_resolve_git_conflicts.sh 5
# Processa 20 file
./bashscripts/fix/batch_resolve_git_conflicts.sh 20
### 3. `test_single_file_conflict_resolver.sh`
**Scopo**: Test e debugging su singoli file.
- Test su file specifico
- Visualizzazione dei conflitti prima della risoluzione
- Validazione dettagliata post-risoluzione
- Perfetto per test e debugging
# Test sul file di default
./bashscripts/fix/test_single_file_conflict_resolver.sh
# Test su file specifico
./bashscripts/fix/test_single_file_conflict_resolver.sh "path/to/your/file.php"
## 🔧 Come Funziona la Risoluzione
Gli script utilizzano una logica AWK ottimizzata per mantenere solo la "current version":
```awk
BEGIN { in_conflict = 0 }
    in_conflict = 1  # Inizio sezione HEAD (da mantenere)
    next 
}
    if (in_conflict == 1) {
        in_conflict = 2  # Inizio sezione incoming (da scartare)
    }
    in_conflict = 0  # Fine conflitto
{
    if (in_conflict == 1 || in_conflict == 0) {
        print  # Mantieni solo HEAD e codice normale
## 📋 Tipi di File Supportati
- `*.php` - Con validazione sintassi
- `*.blade.php` - Template Laravel
- `*.md` - Documentazione Markdown
- `*.txt` - File di testo
- `*.json` - Con validazione JSON
- `*.js`, `*.ts` - JavaScript/TypeScript
- `*.vue` - Componenti Vue.js
- `*.css`, `*.scss` - Fogli di stile
- `*.yaml`, `*.yml` - File di configurazione
- `*.xml`, `*.html` - Markup
- `*.sql` - Query database
- `*.sh` - Script bash
## 🚫 Directory Escluse
- `vendor/` - Dipendenze Composer
- `node_modules/` - Dipendenze NPM
- `.git/` - Repository Git
- `storage/logs/` - Log Laravel
- `storage/framework/` - Cache Laravel
- `public/storage/` - Storage pubblico
- `.tmp/`, `tmp/` - File temporanei
## 🛡️ Sicurezza e Backup
### Backup Automatico
Tutti gli script creano backup prima di modificare i file:
- Formato: `conflict_backup_YYYYMMDD_HHMMSS/`
- Struttura flat con nomi file convertiti (es: `path_to_file.php`)
- Conservazione di tutti i file originali
### Validazione Post-Risoluzione
- **File PHP**: Validazione sintassi con `php -l`
- **File JSON**: Validazione con `jq` (se disponibile)
- **File JS/TS**: Validazione con `node -c` (se disponibile)
- **Ripristino Automatico**: In caso di errore, ripristino dal backup
## 🎯 Casi d'Uso Consigliati
### Scenario 1: Primi Test
# Test su singolo file
./bashscripts/fix/test_single_file_conflict_resolver.sh "Modules/Employee/Models/WorkHour.php"
### Scenario 2: Risoluzione Graduale
# Processa 10 file alla volta
./bashscripts/fix/batch_resolve_git_conflicts.sh 10
# Verifica risultati, poi continua
### Scenario 3: Risoluzione Completa
# Risolvi tutti i conflitti (attenzione: può richiedere tempo)
## 📊 Output e Logging
### Codici Colore
- 🔵 **BLU**: Informazioni generali
- 🟢 **VERDE**: Operazioni riuscite
- 🟡 **GIALLO**: Avvisi e warning
- 🔴 **ROSSO**: Errori
- 🟣 **VIOLA**: Processamento in corso
- 🔷 **CYAN**: Header e separatori
### Formato Log
[YYYY-MM-DD HH:MM:SS] LEVEL: Messaggio
### Report Finale
╔══════════════════════════════════════════════════════════╗
║                    RESOLUTION SUMMARY                    ║
╠══════════════════════════════════════════════════════════╣
║ Total files found: 404                                   ║
║ Successfully resolved: 398                               ║
║ Failed to resolve: 6                                     ║
║ Backup directory: conflict_backup_20250910_220102       ║
╚══════════════════════════════════════════════════════════╝
## ⚠️ Note Importanti
1. **Sempre HEAD**: Gli script mantengono SEMPRE la versione HEAD (current)
2. **Backup Obbligatorio**: Mai eseguire senza backup
3. **Validazione**: Controllo automatico della sintassi
4. **Reversibilità**: Possibilità di ripristino completo
5. **Logging**: Tracciamento dettagliato di ogni operazione
## 🔄 Workflow Consigliato
1. **Verifica Stato**:
   ```bash
   git status
   ```
2. **Test Singolo File**:
   ./bashscripts/fix/test_single_file_conflict_resolver.sh "file/problematico.php"
3. **Risoluzione Graduale**:
   ./bashscripts/fix/batch_resolve_git_conflicts.sh 5
4. **Verifica Risultati**:
   php -l file_modificato.php
5. **Commit**:
   git add .
   git commit -m "Resolve merge conflicts automatically"
## 📈 Monitoraggio Conflitti
Per monitorare i conflitti rimanenti:
# Conta conflitti PHP
# Lista file con conflitti
# Statistiche dettagliate
*Script creati per il progetto TechPlanner - Base Laravel con Filament*
