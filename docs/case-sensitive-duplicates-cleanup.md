# File Duplicati Case-Sensitive - Rapporto di Pulizia

**Data**: 2026-02-24  
**Autore**: AI Agent  
**Tipo**: Manutenzione archivio

## Problema

Su filesystem case-sensitive (Linux) non possono esistere file con nomi che differiscono solo per il case (es. `File.php` e `file.php`). Su macOS/Windows (case-insensitive) questi file possono coesistere causando problemi quando il codice viene spostato su server Linux.

## Regola

**Tutti i file di test devono usare PascalCase seguendo lo standard PSR-4:**

- ✅ `GenerateDbDocumentationCommandTest.pest.php`
- ❌ `generatedbdocumentationcommandtest.pest.php` (vietato - lowercase)

## File Duplicati Trovati e Cancellati

| File Cancellato (lowercase) | File Mantenuto (PascalCase) | Percorso |
|----------------------------|------------------------------|----------|
| `generatedbdocumentationcommandtest.pest.php` | `GenerateDbDocumentationCommandTest.pest.php` | `laravel/Modules/Xot/tests/Unit/Console/Commands/` |
| `fixstructuretest.pest.php` | `FixStructureTest.pest.php` | `laravel/Modules/Xot/tests/Feature/` |
| `emailtemplatestest.php` | `EmailTemplatesTest.php` | `laravel/Modules/Notify/tests/Feature/` |
| `jsoncomponentstest.php` | `JsonComponentsTest.php` | `laravel/Modules/Notify/tests/Feature/` |
| `domaintest.php` | *(da rinominare a `DomainTest.php`)* | `laravel/Modules/Tenant/Tests/Unit/` |

## Comando di Verifica

Per trovare file duplicati case-sensitive in futuro:

```bash
# Cerca file duplicati (case-insensitive) nei test
find ./laravel -type f -name "*.php" | grep -v vendor | awk '{print tolower($0) " " $0}' | sort | uniq -d -f1

# Lista tutti i file di test
find ./laravel -type f -name "*test*.php" -o -name "*Test*.php" | grep -v vendor | sort
```

## Riferimenti

- [AGENTS.md](../AGENTS.md) - Naming Conventions
- [PSR-4 Autoloading Standard](https://www.php-fig.org/psr/psr-4/)

---

**Stato**: Completato ✅  
**File rimossi**: 5
