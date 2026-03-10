# Sintassi Array - SEMPRE Short Array

## Regola Fondamentale
**SEMPRE** usare la sintassi short array `[]` invece di `array()`.

## ✅ CORRETTO
```php
return [
    'navigation' => [
        'name' => 'Nome',
        'plural' => 'Nomi',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo',
        ],
    ],
];
```

## ❌ ERRATO
```php
return array (
    'navigation' => 
    array (
        'name' => 'Nome',
        'plural' => 'Nomi',
    ),
    'fields' => 
    array (
        'id' => 
        array (
            'label' => 'ID',
            'help' => 'Identificativo',
        ),
    ),
);
```

## Motivazione
- Coerenza con le convenzioni moderne PHP
- Codice più leggibile e pulito
- Standard del progetto Laraxot/PTVX
- Evita confusione e errori di sintassi

## Checklist
- [ ] Mai usare `array()`
- [ ] Sempre usare `[]`
- [ ] Applicare a tutti i file PHP
- [ ] Verificare prima di ogni commit

## Applicazione
Questa regola si applica a:
- File di traduzioni (`lang/*.php`)
- Configurazioni
- Return di funzioni
- Qualsiasi array in PHP

**CRITICO**: Non dimenticare mai questa regola! 