# ⚠️ CRITICAL: MAI FARE migrate:refresh O migrate:fresh 🔴

## I Dati Sono SACRI

**QUESTO È UN PROMEMORIA PERMANENTE PER TUTTI GLI AI AGENTI**

### ❌ MAI E POI MAI FARE

```bash
php artisan migrate:refresh    # CANCELLA I DATI
php artisan migrate:fresh      # CANCELLA I DATI
php artisan migrate:rollback   # CANCELLA I DATI
```

### ✅ SOLO FARE QUESTO

```bash
php artisan migrate                         # ✅ Preserva i dati
php artisan migrate --path=...              # ✅ Preserva i dati
```

## Perché

Le migration Laraxot sono **IDEMPOTENTI**:
- Usano `if (! $this->hasColumn())`
- Aggiungono solo ciò che manca
- **NON cancellano MAI i dati**

`migrate:refresh` esegue `down()` che **DISTRUGGE** la tabella e **CANCELLA** tutti i dati.

## Conseguenze

Se esegui `migrate:refresh`:
1. **Perdi tutti i dati** nella tabella
2. **Violazione grave** delle regole del progetto
3. **Devi ripristinare** da backup

## Documentazione Completa

📖 `laravel/Modules/Activity/docs/errori/MAI_FARE_MIGRATE_REFRESH.md`

## Regole Correlate

- [Forward-Only Philosophy](docs/claude/project-rules-summary.md)
- [QWEN.md](QWEN.md) - Sezione 7: Database SACRO
- [AGENTS.md](AGENTS.md) - Regola Critica

---

**URLATO PER ESSERE LETTO PRIMA DI OGNI MIGRATION** 🔴🔴🔴
