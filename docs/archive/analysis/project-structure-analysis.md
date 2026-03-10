# Analisi Struttura Progetto - Report Completo

> **Generato**: 2025-12-17  
> **Scopo**: Analisi completa della struttura, regole, eccezioni e conformità del progetto PTVX

## 📊 Panoramica

Questo documento analizza la struttura del progetto, identifica le regole fondamentali, documenta le eccezioni giustificate e verifica la conformità alle convenzioni stabilite.

## 🎯 Filosofia del Progetto

### Principi Fondamentali (DRY + KISS)

1. **DRY (Don't Repeat Yourself)**
   - Nessuna duplicazione tollerabile
   - Estrazione in trait/classe base quando necessario
   - Centralizzazione della logica comune

2. **KISS (Keep It Simple, Stupid)**
   - Semplicità batte complessità
   - Soluzioni dirette ai problemi
   - Evitare over-engineering

3. **Business Logic First**
   - La business logic detta la tecnologia
   - Il dominio è la verità
   - I requisiti di business sopravvivono ai framework

## 🏗️ Architettura Modulare

### Struttura Moduli

- **35 moduli indipendenti** in `laravel/Modules/`
- Ogni modulo ha struttura completa: Models, Views, Controllers, Filament Resources
- Comunicazione tra moduli tramite contratti ben definiti
- Moduli possono essere abilitati/disabilitati indipendentemente

### Componenti Chiave

1. **Xot**: Framework base con classi astratte e servizi comuni
2. **Filament 4**: Admin panel moderno
3. **Laraxot**: Architettura modulare personalizzata
4. **Spatie Packages**: Tool di qualità (permissions, activity log, etc.)

## 📋 Regole Critiche Laraxot

### 1. Estensione Classi Filament

**REGOLA**: MAI estendere classi Filament direttamente. SEMPRE usare classi XotBase.

#### ✅ Pattern Corretto

```php
// ✅ CORRETTO
class Dashboard extends Modules\Xot\Filament\Pages\XotBaseDashboard
class MyResource extends Modules\Xot\Filament\Resources\XotBaseResource
class MyWidget extends Modules\Xot\Filament\Widgets\XotBaseWidget
class MyPage extends Modules\Xot\Filament\Pages\XotBasePage
```

#### ⚠️ Eccezioni Documentate

**Pagine di Autenticazione Filament**:

Le seguenti pagine estendono direttamente le classi Filament perché sono pagine di autenticazione standard che non necessitano delle funzionalità aggiuntive di XotBase:

```php
// ✅ ECCEZIONE GIUSTIFICATA
namespace Modules\User\Filament\Pages\Auth;

// Pagine di autenticazione standard Filament
class Login extends \Filament\Auth\Pages\Login
class Register extends \Filament\Auth\Pages\Register

// Pagina password scaduta (non in navigazione)
class PasswordExpired extends \Filament\Pages\Page implements HasForms
{
    use NavigationPageLabelTrait; // Usa solo il trait per traduzioni
    protected static bool $shouldRegisterNavigation = false;
}
```

**Motivazione Eccezioni**:
- `Login` e `Register`: Pagine di autenticazione standard Filament che non necessitano customizzazioni XotBase
- `PasswordExpired`: Pagina speciale di autenticazione che non deve apparire nella navigazione, usa solo `NavigationPageLabelTrait` per traduzioni

### 2. Model Casting

**REGOLA**: MAI usare `protected $casts`. SEMPRE usare `protected function casts(): array`.

#### ✅ Pattern Corretto

```php
/**
 * Get the attributes that should be cast.
 *
 * @return array<string, string>
 */
protected function casts(): array
{
    return [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
```

#### ⚠️ Stato Attuale

Alcuni modelli ancora usano `protected $casts`. Questi devono essere migrati a `casts()` per conformità Laravel 11/12.

### 3. Traduzioni

**REGOLA**: MAI usare `->label()`, `->placeholder()`, `->helperText()` direttamente.

Le traduzioni sono gestite automaticamente dal `LangServiceProvider` tramite file di traduzione strutturati.

### 4. Actions vs Services

**REGOLA**: Preferire Spatie QueueableAction invece di servizi tradizionali.

## 📁 Struttura File e Convenzioni

### File Markdown (.md)

**REGOLA**: 
- Nomi in minuscolo (eccetto `README.md` e `CHANGELOG.md`)
- Nessuna data nel nome del file
- Solo in cartelle `docs/` esistenti
- Verificare duplicati prima di creare

**File Non Conformi Identificati**:
- `docs/documentation-audit-report.md` (contenuto da verificare)
- Altri file con maiuscole o date nel nome

### Script Bash/Python

**REGOLA**: Tutti gli script devono essere in `bashscripts/{categoria}/`

**Categorie Standard**:
- `analysis/` - Analisi codice
- `ci-cd/` - CI/CD e qualità codice
- `git/` - Operazioni Git
- `database/` - Database e migrazioni
- `maintenance/` - Manutenzione
- `quality-assurance/` - QA e testing
- `utilities/` - Utilità generiche

## 🔍 Analisi Moduli

### Moduli con Errori PHPStan

1. **Incentivi**: 42 errori
2. **UI**: 32 errori
3. **Altri moduli**: 0 errori

### Moduli Conformi

- **Sigma**: 0 errori (risolti con fix UserContract/ProfileContract)
- **Xot**: 0 errori (risolti con fix generics)
- **Job**: 0 errori (risolti in sessione precedente)
- **User**: 0 errori

## 📝 Documentazione Moduli

### Struttura Documentazione

Ogni modulo deve avere:
- `docs/README.md` - Panoramica del modulo
- `docs/{feature}.md` - Documentazione feature specifiche
- Collegamenti bidirezionali con documentazione root

### File da Verificare

Molti file `.md` nei moduli potrebbero avere nomi non conformi. Verificare:
- Nomi in minuscolo
- Nessuna data nel nome
- Nessun duplicato

## 🎯 Prossimi Passi

1. **Risolvere errori PHPStan**:
   - Incentivi (42 errori)
   - UI (32 errori)

2. **Migrare `protected $casts`**:
   - Identificare tutti i modelli con `protected $casts`
   - Migrare a `casts()` method

3. **Verificare conformità file .md**:
   - Rinominare file con maiuscole/datte
   - Verificare duplicati
   - Consolidare documentazione

4. **Categorizzare script**:
   - Verificare script fuori posto
   - Spostare in categorie appropriate
   - Documentare utilizzo

## 🔗 Collegamenti

- [Filosofia Progetto](./philosophy-guide.md)
- [Architettura Filosofia](./architettura_filosofia_religione_politica_zen.md)
- [Regole XotBase](../../bashscripts/docs/xotbase_critical_rules.md)
- [Regole Scripts](./rules/scripts-location.md)
- [Regole Model Casting](../../laravel/Modules/Xot/docs/model-casting-rules.md)

---

**Ultimo aggiornamento**: 2025-12-17


