# Readonly Field Styling - UI/UX Pattern

**Module**: IndennitaResponsabilita  
**Date**: 2026-02-11  
**Status**: Implemented

---

## Scopo

I campi readonly (calcolati automaticamente) devono essere visivamente distinguibili dai campi editabili per migliorare l'esperienza utente. L'utente deve capire immediatamente quali campi può modificare e quali sono calcolati dal sistema.

## Pattern Implementato

### Classi Tailwind CSS per campi readonly

```php
$item->readOnly()
    ->extraInputAttributes([
        'class' => 'bg-blue-50 dark:bg-blue-950/30 border-l-4 border-l-blue-400 dark:border-l-blue-500 text-blue-900 dark:text-blue-100 cursor-not-allowed',
    ]);
```

### Spiegazione delle classi

| Classe | Scopo | Light Mode | Dark Mode |
|--------|-------|------------|-----------|
| `bg-blue-50` | Sfondo azzurro tenue | `#eff6ff` | - |
| `dark:bg-blue-950/30` | Sfondo scuro con trasparenza | - | `rgba(23,37,84,0.3)` |
| `border-l-4` | Bordo sinistro spesso | 4px | 4px |
| `border-l-blue-400` | Colore bordo sinistro | `#60a5fa` | - |
| `dark:border-l-blue-500` | Colore bordo sinistro dark | - | `#3b82f6` |
| `text-blue-900` | Colore testo | `#1e3a8a` | - |
| `dark:text-blue-100` | Colore testo dark | - | `#dbeafe` |
| `cursor-not-allowed` | Cursore "non consentito" | ↕ | ↕ |

### Gerarchia visiva

```
┌──────────────────────────────────────────────┐
│  Campo editabile (sfondo bianco)              │  ← L'utente può modificare
├──────────────────────────────────────────────┤
│▌ Campo readonly (sfondo azzurro + bordo blu) │  ← Calcolato dal sistema
└──────────────────────────────────────────────┘
```

- **Sfondo bianco** = campo editabile (l'utente può digitare)
- **Sfondo azzurro + bordo blu sinistro** = campo calcolato/readonly (valore automatico)

## Motivazione della scelta del colore blu

- **Blu = informazione/sistema**: Il colore blu è universalmente associato a "informazione" e "dati di sistema"
- **Distinguibilità**: Nettamente diverso dallo sfondo bianco dei campi editabili
- **Professionalità**: Aspetto pulito e professionale, non invasivo
- **Dark mode**: Supporto completo per tema scuro con trasparenza
- **Accessibilità**: Contrasto sufficiente tra testo e sfondo in entrambi i temi
- **Precedente `bg-gray-100`**: Troppo sottile, quasi indistinguibile dallo sfondo della pagina

## Anti-pattern

```php
// ❌ ERRATO: sfondo troppo sottile, quasi invisibile
$item->extraInputAttributes(['class' => 'bg-gray-100']);

// ❌ ERRATO: nessuno stile visivo per readonly
$item->readOnly(); // Senza extraInputAttributes

// ❌ ERRATO: disabled invece di readOnly (impedisce l'invio del form)
$item->disabled();

// ❌ ERRATO: colore rosso per readonly (rosso = errore)
$item->extraInputAttributes(['class' => 'bg-red-50']);
```

## File coinvolti

- `CompilaIndennitaResponsabilita.php` - Versione principale (refactored)
- `CompilaIndennitaResponsabilita2.php` - Versione alternativa (aggiornata al pattern blue standard)

## Collegamenti

- [Compila Form Architecture](./compila-form-architecture.md)
- [Theme Zero - Readonly Field Styling](../../../Themes/Zero/docs/readonly-field-styling.md)
- [Theme One - Readonly Field Styling](../../../Themes/One/docs/readonly-field-styling.md)
- [Filament Best Practices](../../../docs/filament-best-practices.md)

---

*Ultimo aggiornamento: 2026-02-11*
