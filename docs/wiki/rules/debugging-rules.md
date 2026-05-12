# Regola Debugging - NO Log::debug nel Codice

## Regola Fondamentale

**Vietato utilizzare `Log::debug()` per debugging temporaneo nel codice.**

## Motivazione

1. **Inquinamento log di produzione**: I log di debug rimangono nel codice e generano rumore nei log
2. **Difficili da rimuovere**: Facili da dimenticare e difficili da trovare in seguito
3. **Feedback inefficace**: Non forniscono output immediato come `dd()` o `ddd()`

## Approccio Corretto

### 1. Per Debugging Immediato
```php
// ✅ CORRETTO - Usare dd(), ddd(), dump() per debug rapido
public function mount(int|string $record): void
{
    dd($record);  // OK per debug, DA RIMUOVERE prima del commit
    // ...
}
```

### 2. Per Debugging Strutturato
- Usare **Xdebug** con breakpoint
- Utilizzare strumenti di profiling (Laravel Debugbar, Telescope)
- IDE debugging con watch expressions

### 3. Per Logging Permanente
```php
// ✅ OK solo se necessario per operazioni critiche
Log::info('Operazione completata', ['user_id' => $userId]);
Log::warning('Tentativo di accesso non autorizzato', ['ip' => $ip]);
Log::error('Errore durante il salvataggio', ['error' => $e->getMessage()]);
```

## Pattern Anti (VIETATO)

```php
// ❌ MAI FARE QUESTO
public function mount(int|string $record): void
{
    Log::debug('CompilaIndennitaResponsabilita mount called with record: ' . $record);
    // ...
}
```

## Checklist Pre-commit

- [ ] Nessun `Log::debug()` nel codice
- [ ] Nessun `dd()`, `dump()`, `ddd()` nel codice
- [ ] Solo logging necessario per produzione (info, warning, error)
- [ ] Rimosso tutto il codice di debug temporaneo

## Strumenti Consigliati

1. **Laravel Telescope**: Per debugging in sviluppo
2. **Laravel Debugbar**: Per query e performance
3. **Xdebug**: Per debugging passo-passo
4. **Ray**: Per debugging moderno (opzionale)

## Collegamenti

- [AGENTS.md](../AGENTS.md) - Linee guida generali
- [code-quality.md](code-quality.md) - Qualità del codice

---

**Ultimo aggiornamento**: 2026-02-24
**Stato**: Attivo
