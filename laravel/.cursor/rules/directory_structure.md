# Regole di Struttura Directory

## Principi di Organizzazione Modulare

L'organizzazione modulare del progetto PTVX segue una serie di principi architetturali che garantiscono coerenza, scalabilità e facilità di manutenzione. Ogni modulo è strutturato come una mini-applicazione con specifiche convenzioni di posizionamento file e convenzioni di namespace.

### Dualismo Strutturale: Filesystem vs. Namespace

Esiste una distinzione intenzionale tra la struttura delle directory e l'organizzazione dei namespace. Questo approccio consente di mantenere una struttura file coerente con l'ecosistema Laravel, facilitando al contempo l'analisi statica del codice.

## Posizionamento Strategico dei File

Il posizionamento dei file nel filesystem segue regole specifiche che ottimizzano l'organizzazione del codice:

### 1. Codice PHP Applicativo

Tutto il codice PHP dell'applicazione risiede nella directory `app/` del modulo:

```
Modules/Rating/app/         <-- Codice PHP qui
```

### 2. Risorse di Localizzazione

Le traduzioni sono posizionate direttamente nella directory principale del modulo:

```
Modules/Rating/lang/        <-- Traduzioni qui (NON in app/ o resources/)
```

### 3. Altri Asset e Risorse

```
Modules/Rating/config/      <-- Configurazioni
Modules/Rating/routes/      <-- Definizioni rotte
Modules/Rating/resources/   <-- Asset frontend
Modules/Rating/database/    <-- Migrazioni e seeder
```

## Convenzioni di Namespace

Il namespace di una classe riflette la sua posizione logica, indipendentemente dalla posizione fisica nel filesystem:

```php
// Il file è fisicamente in: Modules/Rating/app/Models/Rating.php
// Ma il namespace è semplicemente:
namespace Modules\Rating\Models;
```

## Eccezioni e Casi Particolari

### Directory di Localizzazione

A differenza del codice PHP, le traduzioni NON vanno nella directory `app/` ma direttamente nella radice del modulo:

- ✅ CORRETTO: `Modules/Rating/lang/it/messages.php`
- ❌ ERRATO: `Modules/Rating/app/lang/it/messages.php`
- ❌ ERRATO: `Modules/Rating/resources/lang/it/messages.php`

### Errori Comuni

1. **Posizionamento errato di file PHP**
   - Errato: Posizionare file PHP direttamente nella radice del modulo
   - Corretto: Posizionarli nella sottodirectory `app/` appropriata

2. **Errori di namespace**
   - Errato: Includere il segmento 'app' nel namespace 
   - Corretto: Omettere 'app' dal namespace

3. **Posizionamento errato delle traduzioni**
   - Errato: Metterle in `app/lang/` o `resources/lang/`
   - Corretto: Posizionarle direttamente in `lang/`

## Compatibilità con Strumenti di Analisi

Questo approccio migliora la compatibilità con PHPStan e altri strumenti di analisi statica, permettendo una verifica di tipo più accurata a livello 9 (massima rigidità).

## RelationManager custom: regola di estensione

Tutti i RelationManager custom dei moduli devono estendere **sempre**

```php
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class MyRelationManager extends XotBaseRelationManager
{
    // ...
}
```

Mai estendere direttamente `Filament\Resources\RelationManagers\RelationManager`.

**Motivazione:**
- Centralizza la logica tabellare e di form custom
- Garantisce coerenza, DRY, aggiornabilità e riduce errori/duplicazioni
- Permette override solo per personalizzazioni reali

**Pattern corretto:**
- Usa solo `getFormSchema()` per i form custom
- Personalizza solo ciò che serve davvero
- Non ridefinire metodi già gestiti dalla base

**Anti-pattern:**
- Estendere direttamente la classe Filament
- Duplicare metodi standard già gestiti dalla base
- Usare `form()` invece di `getFormSchema()`

**Checklist:**
- [x] Tutti i RelationManager custom estendono XotBaseRelationManager
- [x] Nessun override inutile di metodi base
- [x] Solo personalizzazioni reali
- [x] Documentazione aggiornata

**Backlink:**
- [Best practices Xot](../../Modules/Xot/docs/filament-best-practices.md)
- [Root FILAMENT-BEST-PRACTICES.md](../../docs/FILAMENT-BEST-PRACTICES.md)
