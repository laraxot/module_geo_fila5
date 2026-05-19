---
title: Pattern SACRO per Accessor con Auto-Persistenza
description: Standard per gli accessor Eloquent che persistono automaticamente il risultato nel database
tags:
  - architecture
  - models
  - pattern
  - accessor
created: 2026-04-15
updated: 2026-04-15
sources:
  - bashscripts/ai/.agents/docs/accessor-auto-persistence.md
---

# Pattern SACRO per Accessor con Auto-Persistenza

Questo pattern (Livello 3/4) definisce lo standard per gli accessor Eloquent che devono persistere automaticamente il risultato del calcolo nel database.

## La Regola Chiave

Il pattern si basa sulla separazione netta tra l'accessor e la logica di calcolo:

1.  `getSomeValueAttribute()`: L'accessor (chiamato da Laravel quando si accede a `$model->some_value`). Si occupa dell'orchestrazione, del controllo della cache e della persistenza.
2.  `getSomeValue()`: Il metodo puro che esegue il calcolo effettivo (testabile e isolato).

## Esempio di Implementazione

```php
/**
 * Accessor per il valore calcolato con auto-persistenza.
 *
 * @param float|null $value
 * @return float|null
 */
protected function getSomeValueAttribute(?float $value): ?float
{
    // 1. Cache check - se già calcolato e presente nel DB, lo restituisce subito
    if (is_float($value)) {
        return $value;
    }

    // 2. Delega il calcolo a un metodo separato (senza "Attribute")
    $result = $this->getSomeValue();

    // 3. Persiste automaticamente nel DB se il modello esiste
    if ($this->exists) {
        static::withoutEvents(function () use ($result): void {
            $this->update(['some_value' => $result]);
        });
    }

    return $result;
}

/**
 * Logica di calcolo pura e testabile.
 *
 * @return float
 */
protected function getSomeValue(): float
{
    // Logica complessa qui (50+ righe se necessario)
    return $this->calculateComplexLogic();
}
```

## Vantaggi

1.  **Separazione delle Responsabilità (SOLID)**: L'accessor non conosce i dettagli del calcolo.
2.  **Testabilità**: È possibile testare `getSomeValue()` in modo unitario senza passare dal database.
3.  **Performance**: Il valore viene calcolato una sola volta e poi persistito per gli accessi successivi.
4.  **Integrità**: L'uso di `static::withoutEvents` evita loop infiniti di eventi di aggiornamento.

## Quando Usarlo

Usare questo pattern quando un valore derivato è costoso da calcolare e deve essere memorizzato nel database per ricerche veloci o per evitare ricalcoli frequenti, mantenendo la sincronizzazione automatica.

## Vedi anche

- [BaseModel Pattern](../../../laravel/Modules/Xot/docs/wiki/BaseModel.md) — Pattern di base per i modelli
- [Actions Over Services](actions-over-services.md) — Pattern di azioni invece di servizi
- [Accessor zen level 3](accessor-zen-level-3.md) — Pattern completo per accessor e mutator