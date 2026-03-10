# PHP Array Syntax Rule

## CRITICAL: Always Use Short Array Syntax

**NEVER** use `array()` syntax. **ALWAYS** use short array syntax `[]`.

### ✅ CORRECT
```php
return [
    'navigation' => [
        'name' => 'Name',
        'plural' => 'Names',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Identifier',
        ],
    ],
];
```

### ❌ WRONG
```php
return array (
    'navigation' => 
    array (
        'name' => 'Name',
        'plural' => 'Names',
    ),
    'fields' => 
    array (
        'id' => 
        array (
            'label' => 'ID',
            'help' => 'Identifier',
        ),
    ),
);
```

## Why This Matters
- Modern PHP standard
- More readable code
- Project consistency (Laraxot/PTVX)
- Prevents syntax confusion

## When to Apply
- All PHP files
- Translation files (`lang/*.php`)
- Configuration files
- Function returns
- Any array declaration

**REMEMBER**: Short array syntax `[]` is MANDATORY for this project! 