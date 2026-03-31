# ⚠️ MAI FARE `migrate --force` - COMANDO PERICOLOSO 🔴

## Errore Critico Commesso

**Data**: 2026-03-24  
**Errore**: Eseguito `php artisan migrate --force --path=...`  
**Perché è sbagliato**: `--force` bypassa i controlli di sicurezza in produzione

## Perché `--force` è PERICOLOSO

Il flag `--force` dice a Laravel di eseguire le migration **ANCHE IN PRODUZIONE** senza chiedere conferma.

### Rischi

1. **Bypassa i controlli di sicurezza**
   - Laravel in produzione chiede conferma per proteggere i dati
   - `--force` ignora questa protezione

2. **Può eseguire migration distruttive**
   - Se una migration ha `down()` pericoloso, viene eseguito comunque
   - Nessuna conferma prima di operazioni rischiose

3. **Downtime non pianificato**
   - Migration lunghe bloccano l'applicazione
   - In produzione questo significa utenti bloccati

4. **Nessun rollback automatico**
   - Se fallisce a metà, i dati possono rimanere corrotti
   - In produzione serve procedura di rollback testata

## Cosa Fare Invece

### ✅ Ambiente Locale / Sviluppo

```bash
# Locale - nessun --force necessario
php artisan migrate
php artisan migrate --path=Modules/Activity/database/migrations/2026_03_24_120000_add_batch_uuid_and_event_to_activity_table.php
```

### ✅ Ambiente di Produzione

In produzione, segui questa procedura:

1. **Backup del database** (OBBLIGATORIO)
```bash
mysqldump -u user -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql
```

2. **Test in staging** (OBBLIGATORIO)
```bash
# Esegui la migration prima in staging
php artisan migrate --path=...
# Verifica che tutto funzioni
```

3. **Maintenance mode** (CONSIGLIATO)
```bash
# Metti l'app in maintenance
php artisan down
```

4. **Esegui migration SENZA --force**
```bash
# Laravel chiederà conferma in produzione
php artisan migrate --path=...
# Rispondi 'yes' dopo aver verificato
```

5. **Riattiva l'app**
```bash
php artisan up
```

6. **Verifica**
```bash
# Controlla che le colonne esistano
php artisan tinker --execute="Schema::hasColumn('activity_log', 'batch_uuid')"
```

## Casi d'Uso Accettabili per `--force`

L'UNICO caso in cui `--force` è accettabile:

### ✅ CI/CD Pipeline Automatizzate

```yaml
# .github/workflows/deploy.yml
- name: Run migrations
  run: php artisan migrate --force
  env:
    APP_ENV: production
    DB_HOST: ${{ secrets.PROD_DB_HOST }}
```

**Perché è OK**:
- Eseguito in ambiente controllato
- Backup automatico prima del deploy
- Rollback automatico se fallisce
- Testing preliminare in staging

### ❌ MAI usare `--force` per:

```bash
# ❌ Fix urgenti in produzione
php artisan migrate --force  # SBAGLIATO!

# ❌ Quando sei di fretta
php artisan migrate --force  # SBAGLIATO!

# ❌ Per evitare di digitare 'yes'
php artisan migrate --force  # SBAGLIATO!

# ❌ In produzione manuale
php artisan migrate --force  # SBAGLIATO!
```

## Procedura Corretta per Fix Urgenti

Se devi applicare una migration urgente in produzione:

### 1. Crea la Migration
```bash
php artisan make:migration fix_critical_issue
```

### 2. Test in Locale
```bash
php artisan migrate
php artisan tinker
# Verifica che funzioni
```

### 3. Test in Staging
```bash
# Deploy in staging
php artisan migrate
# Test completo
```

### 4. Produzione (con Maintenance)
```bash
# 1. Backup
mysqldump -u user -p db > backup.sql

# 2. Maintenance mode
php artisan down

# 3. Migration (SENZA --force)
php artisan migrate --path=...

# 4. Verifica
php artisan tinker --execute="DB::select('SHOW COLUMNS FROM table')"

# 5. Riattiva
php artisan up
```

## Alternative a `--force`

### Opzione 1: SSH con Conferma

```bash
# SSH in produzione
ssh user@production

# Esegui migration (Laravel chiederà conferma)
php artisan migrate --path=...
# > Do you really wish to run this command in production? [yes|No]
# Digita: yes
```

### Opzione 2: Script di Deploy

```bash
#!/bin/bash
# deploy-migration.sh

echo "⚠️  STAI PER ESEGUIRE UNA MIGRATION IN PRODUZIONE"
echo "Database: $DB_DATABASE"
echo "Migration: $MIGRATION_PATH"
read -p "Sei sicuro? (yes/no): " confirm

if [ "$confirm" != "yes" ]; then
    echo "❌ Annullato"
    exit 1
fi

# Backup
echo "📦 Backup in corso..."
mysqldump -u $DB_USER -p$DB_PASS $DB_DATABASE > backup_$(date +%Y%m%d_%H%M%S).sql

# Maintenance
echo "🔧 Maintenance mode..."
php artisan down

# Migration
echo "🚀 Esecuzione migration..."
php artisan migrate --path=$MIGRATION_PATH

# Verifica
echo "✅ Verifica..."
php artisan tinker --execute="echo 'Migration completed'"

# Riattiva
echo "🎯 Riattivazione..."
php artisan up

echo "✅ Completato!"
```

### Opzione 3: Laravel Envoyer / Deployer

Usa strumenti di deploy professionali che gestiscono:
- Backup automatici
- Zero-downtime deployment
- Rollback automatico
- Health checks

## Documentazione Ufficiale Laravel

> **Laravel Documentation**: "The `--force` flag should only be used in automated deployment pipelines where interactive confirmation is not possible."

## Regole d'Oro

1. **MAI `--force` manuale** - Solo in CI/CD automatizzato
2. **SEMPRE backup prima** - I dati sono SACRI
3. **SEMPRE test in staging** - Mai deploy diretto in produzione
4. **SEMPRE maintenance mode** - Evita corruzione dati
5. **SEMPRE verifica dopo** - Controlla che la migration abbia funzionato

## Memoria Permanente

**Qwen AI - Da non dimenticare MAI PIÙ**:

```
🔴 MAI migrate --force MANUALE 🔴

--force è SOLO per:
✅ CI/CD pipeline automatizzate
✅ Ambienti controllati
✅ Con backup e rollback automatici

MAI per:
❌ Fix manuali in produzione
❌ Quando sei di fretta
❌ Per evitare conferme
❌ SSH manuale in produzione

PROCEDURA CORRETTA:
1. Backup OBBLIGATORIO
2. Test in staging
3. Maintenance mode
4. migrate (SENZA --force)
5. Verifica
6. Riattiva

I dati sono SACRI - --force bypassa le protezioni!
```

## Documentazione Correlata

- [MAI FARE migrate:refresh](./MAI_FARE_MIGRATE_REFRESH.md)
- [Forward-Only Philosophy](../../Xot/docs/philosophy-complete.md)
- [Database Safety Rules](../../docs/claude/project-rules-summary.md)
- [Laravel Migration Documentation](https://laravel.com/docs/migrations#running-migrations)

---

*Documento creato come monito permanente - Da leggere prima di ogni migration in produzione*
