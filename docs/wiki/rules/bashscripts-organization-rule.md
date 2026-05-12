# 🗂️ **BASHSCRIPTS ORGANIZATION RULE - REGOLA FONDAMENTALE**

[![Organization](https://img.shields.io/badge/Organization-Mandatory-critical.svg)]()
[![Structure](https://img.shields.io/badge/Structure-Categorized-blue.svg)]()
[![Compliance](https://img.shields.io/badge/Compliance-Required-red.svg)]()
[![Best Practice](https://img.shields.io/badge/Best%20Practice-Enforced-green.svg)]()

## ⚠️ **REGOLA FONDAMENTALE - DA RICORDARE SEMPRE**

> **🚨 TUTTI gli script bash DEVONO essere organizzati e categorizzati nelle sottocartelle di `bashscripts/`**
> 
> **NON posizionare MAI script bash nella root del progetto o in posizioni casuali.**

## 📁 **Struttura Obbligatoria**

### 🏗️ **Gerarchia di Categorie**

```
bashscripts/
├── analysis/           # Script di analisi e audit
├── backup/             # Script di backup e ripristino  
├── composer/           # Script Composer e dipendenze
├── database/           # Script database e migrazioni
├── development/        # Script di sviluppo
├── docs/               # Script documentazione
├── git/                # Script Git e versioning
│   ├── gitignore/      # Script .gitignore specifici
│   ├── conflict_resolution/ # Risoluzione conflitti
│   └── subtrees/       # Gestione subtree
├── maintenance/        # Script manutenzione e fix
├── mcp/                # Script MCP server
├── phpstan/            # Script PHPStan e analisi
├── quality-assurance/  # Script QA e testing
├── setup/              # Script installazione
├── translations/       # Script traduzioni
├── utilities/          # Script utilità generiche
└── webmin/             # Script amministrazione web
```

## 🎯 **Categorizzazione degli Script**

### 🔧 **Git e .gitignore Scripts**
**Posizione**: `bashscripts/git/gitignore/`

**Esempi**:
- `fix_remaining_gitignore.sh` → `bashscripts/git/gitignore/fix_remaining_gitignore.sh`
- `update_gitignore.sh` → `bashscripts/git/gitignore/update_gitignore.sh`
- `standardize_gitignore.sh` → `bashscripts/git/gitignore/standardize_gitignore.sh`

### 🔍 **Analysis e Audit Scripts**  
**Posizione**: `bashscripts/analysis/`

**Esempi**:
- `analyze_modules.sh` → `bashscripts/analysis/analyze_modules.sh`
- `check_duplicates.sh` → `bashscripts/analysis/check_duplicates.sh`
- `audit_translations.sh` → `bashscripts/analysis/audit_translations.sh`

### 🛠️ **Maintenance Scripts**
**Posizione**: `bashscripts/maintenance/`

**Esempi**:
- `fix_structure.sh` → `bashscripts/maintenance/fix_structure.sh`
- `cleanup_old_files.sh` → `bashscripts/maintenance/cleanup_old_files.sh`
- `repair_database.sh` → `bashscripts/maintenance/repair_database.sh`

### 📊 **Quality Assurance Scripts**
**Posizione**: `bashscripts/quality-assurance/`

**Esempi**:
- `run_phpstan.sh` → `bashscripts/quality-assurance/run_phpstan.sh`
- `check_code_quality.sh` → `bashscripts/quality-assurance/check_code_quality.sh`
- `validate_modules.sh` → `bashscripts/quality-assurance/validate_modules.sh`

### 🌐 **Translation Scripts**
**Posizione**: `bashscripts/translations/`

**Esempi**:
- `update_translations.sh` → `bashscripts/translations/update_translations.sh`
- `sync_lang_files.sh` → `bashscripts/translations/sync_lang_files.sh`
- `validate_translations.sh` → `bashscripts/translations/validate_translations.sh`

### 🔧 **Utility Scripts**
**Posizione**: `bashscripts/utilities/`

**Esempi**:
- `generate_docs.sh` → `bashscripts/utilities/generate_docs.sh`
- `batch_rename.sh` → `bashscripts/utilities/batch_rename.sh`
- `convert_format.sh` → `bashscripts/utilities/convert_format.sh`

## 🚨 **Regole di Compliance**

### ✅ **OBBLIGATORIO**
- [x] **Tutti gli script** devono essere in sottocartelle di `bashscripts/`
- [x] **Categorizzazione logica** in base alla funzione
- [x] **Nomi descrittivi** per script e cartelle
- [x] **README.md** in ogni categoria quando necessario
- [x] **Permessi corretti** (executable per script)

### ❌ **VIETATO**
- [ ] Script nella root del progetto (❌ `/fix_script.sh`)
- [ ] Script in cartelle casuali (❌ `/temp/script.sh`)
- [ ] Categorie non standardizzate
- [ ] Script senza categorizzazione logica
- [ ] Duplicazioni tra cartelle

## 📋 **Checklist per Nuovi Script**

### 1️⃣ **Prima di Creare uno Script**
- [ ] Identificare la categoria appropriata
- [ ] Verificare se esiste già uno script simile
- [ ] Controllare le convenzioni di naming
- [ ] Preparare documentazione se necessario

### 2️⃣ **Durante la Creazione**
- [ ] Posizionare nella categoria corretta
- [ ] Usare nome descrittivo
- [ ] Aggiungere header con descrizione
- [ ] Impostare permessi executable
- [ ] Testare funzionalità

### 3️⃣ **Dopo la Creazione**  
- [ ] Aggiornare README.md della categoria
- [ ] Documentare utilizzo se complesso
- [ ] Aggiungere ai tool di controllo qualità
- [ ] Verificare non ci siano duplicazioni

## 🎯 **Esempi di Migrazione**

### ❌ **PRIMA (Scorretto)**
```bash
/var/www/html/_bases/base_ptvx_fila5_mono/fix_remaining_gitignore.sh
/var/www/html/_bases/base_ptvx_fila5_mono/update_gitignore.sh
/var/www/html/_bases/base_ptvx_fila5_mono/laravel/cleanup_script.sh
```

### ✅ **DOPO (Corretto)**
```bash
/var/www/html/_bases/base_ptvx_fila5_mono/bashscripts/git/gitignore/fix_remaining_gitignore.sh
/var/www/html/_bases/base_ptvx_fila5_mono/bashscripts/git/gitignore/update_gitignore.sh  
/var/www/html/_bases/base_ptvx_fila5_mono/bashscripts/maintenance/cleanup_script.sh
```

## 🗂️ **Struttura Moduli**

### 📁 **Script per Moduli Specifici**
Ogni modulo può avere la propria cartella bashscripts:

```
Modules/[ModuleName]/bashscripts/
├── setup/              # Setup modulo-specifico
├── maintenance/        # Manutenzione modulo
├── testing/            # Test modulo
└── utilities/          # Utilità modulo
```

**Esempio**:
```
Modules/Activity/bashscripts/
├── setup/
│   └── install_activity.sh
├── maintenance/
│   └── cleanup_logs.sh  
└── testing/
    └── run_activity_tests.sh
```

## 🚀 **Best Practices**

### 1️⃣ **Naming Convention**
- **Funzione chiara**: `fix_gitignore_issues.sh` ✅
- **Non generico**: `script.sh` ❌
- **Underscore separatore**: `update_module_docs.sh` ✅
- **No spazi**: `fix git files.sh` ❌

### 2️⃣ **Header Standard**
```bash
#!/bin/bash
# ================================================
# Script: [Nome Script]
# Categoria: [git/maintenance/quality-assurance/etc]
# Descrizione: [Breve descrizione funzione]
# Autore: [Team/Nome] 
# Data: [Data creazione]
# Uso: ./script.sh [parametri]
# ================================================
```

### 3️⃣ **Documentazione**
- **README.md** in ogni categoria principale
- **Commenti** per logica complessa
- **Esempi** di utilizzo
- **Parametri** e opzioni documentati

### 4️⃣ **Testing**
- **Test prima** di commit
- **Validazione parametri** 
- **Error handling** appropriato
- **Output informativi**

## 📊 **Controllo Compliance**

### 🔍 **Script di Verifica**
```bash
# Verifica script fuori posto
find . -name "*.sh" -not -path "./bashscripts/*" -not -path "./.git/*"

# Conta script per categoria  
find ./bashscripts -name "*.sh" | cut -d'/' -f3 | sort | uniq -c

# Verifica permessi executable
find ./bashscripts -name "*.sh" ! -executable -ls
```

## ⚡ **Quick Reference**

### 🎯 **Per Tipo di Script**

| Tipo Script | Categoria | Esempio |
|------------|-----------|---------|
| .gitignore | `git/gitignore/` | `fix_gitignore.sh` |
| Git conflicts | `git/conflict_resolution/` | `resolve_conflicts.sh` |
| PHPStan | `phpstan/` | `run_analysis.sh` |
| Database | `database/` | `migrate_db.sh` |
| Docs | `docs/` | `generate_docs.sh` |
| Backup | `backup/` | `backup_system.sh` |
| Traduzioni | `translations/` | `sync_translations.sh` |
| QA/Testing | `quality-assurance/` | `run_tests.sh` |
| Setup | `setup/` | `install_deps.sh` |
| Utilità | `utilities/` | `batch_process.sh` |

## 🏆 **Vantaggi dell'Organizzazione**

### ✅ **Benefici**
- 🔍 **Trovabilità**: Script facili da localizzare
- 🏗️ **Manutenibilità**: Struttura logica e ordinata
- 👥 **Collaborazione**: Team sa dove cercare/mettere script
- 📊 **Scalabilità**: Struttura cresce organicamente
- 🔧 **Riusabilità**: Script correlati raggruppati
- 📝 **Documentabilità**: Ogni categoria autodocumentata

### ❌ **Problemi dell'Approccio Disorganizzato**
- 🔍 Script impossibili da trovare
- 🔄 Duplicazione e confusione
- 👥 Team perde tempo a cercare
- 🚨 Script critici dimenticati
- 📝 Documentazione frammentata

## 🔄 **Processo di Migrazione**

### **Per Script Esistenti**
1. **Identifica categoria** appropriata
2. **Sposta** lo script nella sottocartella corretta
3. **Aggiorna** riferimenti e percorsi
4. **Testa** funzionalità post-migrazione  
5. **Documenta** il cambio se necessario

### **Per Nuovi Script**
1. **Pianifica categoria** prima di scrivere
2. **Crea direttamente** nella posizione corretta
3. **Segui naming convention**
4. **Aggiungi header** standard
5. **Documenta** nella categoria

---

## 🚨 **PROMEMORIA CRITICO**

> **⚠️ QUESTA È UNA REGOLA FONDAMENTALE**
>
> **OGNI VOLTA che crei, muovi, o organizzi script bash, RICORDA:**
> 1. **bashscripts/** è la directory root per TUTTI gli script
> 2. **Categorizza SEMPRE** logicamente  
> 3. **NON** posizionare script nella root del progetto
> 4. **Mantieni** la struttura esistente
> 5. **Documenta** quando appropriato

### 📞 **Riferimenti**

- **Struttura principale**: `/var/www/html/_bases/base_ptvx_fila5_mono/bashscripts/`
- **Moduli specifici**: `/var/www/html/_bases/base_ptvx_fila5_mono/laravel/Modules/[ModuleName]/bashscripts/`
- **Documentazione**: Ogni categoria ha il proprio README.md
- **Best practices**: Seguire sempre header standard e naming convention

---

**🔄 Ultimo aggiornamento**: 16 Settembre 2025  
**📦 Versione**: 1.0.0  
**🎯 Status**: Regola Attiva e Obbligatoria  
**⚡ Compliance**: 100% Richiesta per Tutti gli Script