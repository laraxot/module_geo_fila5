# ⚠️ MAI FARE migrate:refresh O migrate:fresh - DATI SACRI

## Errore Critico Commesso

**Data**: 2026-03-24  
**Errore**: Eseguito `php artisan migrate:refresh --path=Modules/Activity/database/migrations/2024_01_01_000002_create_activity_table.php`  
**Conseguenza**: Tabella `activity_log` cancellata e ricreata - **0 record** (tutti i dati persi)

## Perché è GRAVISSIMO

```bash
# ❌ MAI E POI MAI FARE QUESTO
php artisan migrate:refresh
php artisan migrate:fresh
php artisan migrate:rollback
```

Questi comandi:
1. **Distruggono i dati** (down() cancella tutto)
2. **Violano il principio Forward-Only** di Laraxot
3. **Sono proibiti** dalla filosofia del progetto

## I Dati Sono SACRI 🔴

> **REGOLA FONDAMENTALE**: I dati nel database sono **EVIDENZA** da ispezionare ed evolvere, **NON** un sandbox da resettare.

### Cosa Fare Invece

```bash
# ✅ CORRETTO: Eseguire solo la migration (idempotente)
php artisan migrate --path=Modules/Activity/database/migrations/2024_01_01_000002_create_activity_table.php

# ✅ CORRETTO: Se la tabella esiste già, la migration usa tableUpdate()
# e aggiunge solo le colonne mancanti con if (! $this->hasColumn())
```

## La Migration è Idempotente

La migration corretta:

```php
public function up(): void
{
    // -- CREATE --
    $this->tableCreate(function (Blueprint $table): void {
        // ... definizione tabella
        $table->uuid('batch_uuid')->nullable();
        $table->string('event')->nullable();
    });

    // -- UPDATE --
    $this->tableUpdate(function (Blueprint $table): void {
        // Aggiunge SOLO se manca
        if (! $this->hasColumn('batch_uuid')) {
            $table->uuid('batch_uuid')->nullable()->after('properties');
        }

        if (! $this->hasColumn('event')) {
            $table->string('event')->nullable()->after('batch_uuid');
        }
        
        // ... altri aggiornamenti
    });
}
```

**Perché funziona**:
- `tableCreate()` salta se la tabella esiste già
- `tableUpdate()` esegue sempre
- `if (! $this->hasColumn())` aggiunge solo colonne mancanti
- **Nessun dato viene cancellato**

## Come Ripristinare i Dati Persi

Se hai eseguito per sbaglio `migrate:refresh`:

### Opzione 1: Ripristino da Backup
```bash
# Se hai un dump SQL
mysql -u user -p ptv_lara < backup_2026-03-24.sql
```

### Opzione 2: Ricostruire i Log (se sono activity log)
I log di activity possono essere rigenerati dal modello:

```php
// In tinker o script di recovery
use Spatie\Activitylog\Facades\Activity;

// I log si rigenerano automaticamente quando i modelli vengono modificati
// Non serve fare nulla - il sistema li ricrea
```

### Opzione 3: Accettare la Perdita (solo per log non critici)
Se i dati persi sono log non essenziali:
1. Documentare l'errore
2. Procedere con sviluppo
3. Implementare backup automatici

## Documentazione Correlata

- [Forward-Only Philosophy](../../Xot/docs/philosophy-complete.md)
- [Git Forward-Only Rule](../../Xot/docs/git-forward-only-rule.md)
- [Never Use RefreshDatabase](../../Xot/docs/testing-refresh-database-rule.md)
- [Database Safety Rules](../../docs/claude/project-rules-summary.md#1-forward-only-git--migrations)
- [Migration Safety Rules](../../User/docs/database/migration-safety-rules.md)

## Memoria Permanente

**Qwen AI - Da non dimenticare MAI PIÙ**:

```
🔴 DATI SACRI - MAI DISTRUGGERE 🔴

1. migrate:refresh  = down() + up() = DATI CANCELLATI
2. migrate:fresh    = drop + create = DATI CANCELLATI  
3. migrate:rollback = down()        = DATI CANCELLATI

✅ SOLO migrate (forward) = dati preservati

Le migration Laraxot sono IDEMPOTENTI:
- Usano if (! $this->hasColumn())
- Non cancellano mai dati
- Aggiungono solo ciò che manca

SE HAI DUBBI:
1. Leggi la migration PRIMA di eseguire
2. Controlla se usa tableCreate() o tableUpdate()
3. Verifica che abbia controlli hasColumn()
4. Esegui SOLO migrate, MAI refresh/fresh
```

## Come Non Dimenticarlo Mai Più

### 1. Pre-Commit Checklist

Prima di eseguire qualsiasi comando migration:

```
[ ] Ho letto la migration file?
[ ] Capisco cosa fa up() e down()?
[ ] I dati sono importanti?
[ ] Sto per usare migrate (✅) o migrate:refresh (❌)?
```

### 2. Alias Protettivi

Aggiungi al tuo `.bashrc` o `.zshrc`:

```bash
# Proteggiti da te stesso
alias php:artisan:migrate:refresh="echo '❌ MAI FARE QUESTO! I dati sono SACRI!' && false"
alias php:artisan:migrate:fresh="echo '❌ MAI FARE QUESTO! I dati sono SACRI!' && false"
```

### 3. GitHub Issue di Monitoraggio

Crea una GitHub Issue per tracciare:
- Titolo: "⚠️ CRITICAL: Never Use migrate:refresh/fresh"
- Label: `critical`, `documentation`, `reminder`
- Assegnala a te stesso come promemoria

## Lezione Appresa

**Contesto**: Errore commesso il 2026-03-24 durante fix colonna `batch_uuid` mancante.

**Causa**: Fretta, non ho letto la documentazione che pure esiste:
- `docs/claude/project-rules-summary.md` - Forward-Only rule
- `QWEN.md` - Regola 6: Forward-Only Git
- `AGENTS.md` - Read → Reason → Study → Update → Improve

**Azione Correttiva**:
1. ✅ Documentare l'errore (questo file)
2. ✅ Aggiornare le rules dell'AI
3. ✅ Creare promemoria permanente
4. ⏳ Ripristinare i dati (da backup o rigenerazione)

**Impatto**: 0 record in `activity_log` - log di sistema persi

---

*Documento creato come monito permanente - Da leggere prima di ogni operazione di migration*
