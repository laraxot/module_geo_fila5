# Report Conformità Progetto PTVX

> **Generato**: 2025-12-17  
> **Scopo**: Verifica conformità a regole, convenzioni e best practices

## 📊 Stato Conformità Generale

### ✅ Conformi

- **PHPStan Level 10**: 32 moduli su 34 senza errori
- **Struttura Moduli**: Tutti i moduli seguono architettura Laraxot
- **Namespace**: Conformi alle convenzioni modulari
- **Script CI/CD**: Organizzati in `bashscripts/ci-cd/`

### ⚠️ Da Migrare

- **Model Casting**: 20+ modelli ancora usano `protected $casts`
- **PHPStan Errori**: 2 moduli con errori (Incentivi: 42, UI: 32)
- **Script Fuori Posto**: Script in `docs/` da spostare in `bashscripts/`

## 🎯 Regole Critiche e Conformità

### 1. Estensione Classi Filament

**REGOLA**: MAI estendere classi Filament direttamente. SEMPRE usare XotBase.

**Stato**: ✅ Conforme (con eccezioni documentate)

**Eccezioni Giustificate**:
- `Modules\User\Filament\Pages\Auth\Login` → `Filament\Auth\Pages\Login`
- `Modules\User\Filament\Pages\Auth\Register` → `Filament\Auth\Pages\Register`
- `Modules\User\Filament\Pages\Auth\EditProfile` → `Filament\Auth\Pages\EditProfile`
- `Modules\User\Filament\Pages\Auth\PasswordExpired` → `Filament\Pages\Page`

**Documentazione**: [Filament Auth Pages Exceptions](../../laravel/Modules/User/docs/filament-auth-pages-exceptions.md)

### 2. Model Casting

**REGOLA**: MAI usare `protected $casts`. SEMPRE usare `protected function casts(): array`.

**Stato**: ⚠️ 20+ modelli da migrare

**Modelli con `protected $casts`**:
- `Modules/Badge/app/Models/BaseModel.php`
- `Modules/DbForge/app/Models/DbForgeBackup.php`
- `Modules/DbForge/app/Models/DbForgeMigration.php`
- `Modules/Incentivi/app/Models/Phase.php`
- `Modules/Incentivi/app/Models/Project.php`
- `Modules/IndennitaCondizioniLavoro/app/Models/BaseModel.php`
- `Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoroAdm.php`
- `Modules/IndennitaCondizioniLavoro/app/Models/Opzioni.php`
- `Modules/MobilitaVolontaria/app/Models/BaseModel.php`
- `Modules/Notify/app/Models/NotificationLog.php`
- `Modules/Performance/app/Models/MyLog.php`
- `Modules/Performance/app/Models/Performance.php`
- `Modules/Performance/app/Models/PerformanceComportamenti.php`
- `Modules/Performance/app/Models/PerformanceFondo.php`
- `Modules/Performance/app/Models/PerformanceObiettivi.php`
- `Modules/Performance/app/Models/Valutatore.php`
- `Modules/Progressioni/app/Models/Progressioni.php`
- `Modules/Ptv/app/Models/Valutatore.php`
- `Modules/Setting/app/Models/DatabaseConnection.php`
- `Modules/Sigma/app/Models/WebService.php`
- `Modules/Sigma/tests/TestModels/TestWebService.php`

**Azione Richiesta**: Migrare tutti a `casts()` method per conformità Laravel 11/12.

### 3. Traduzioni

**REGOLA**: MAI usare `->label()`, `->placeholder()`, `->helperText()` direttamente.

**Stato**: ✅ Conforme (gestito automaticamente da LangServiceProvider)

### 4. Actions vs Services

**REGOLA**: Preferire Spatie QueueableAction invece di servizi tradizionali.

**Stato**: ✅ Conforme

## 📁 Conformità File e Struttura

### File Markdown (.md)

**REGOLA**: 
- Nomi in minuscolo (eccetto `README.md` e `CHANGELOG.md`)
- Nessuna data nel nome
- Solo in cartelle `docs/` esistenti

**Stato**: ✅ Conforme

**File Speciali** (mantenere maiuscole):
- `docs/CLAUDE.md` - File speciale per configurazione AI
- `docs/GEMINI.md` - File speciale per configurazione AI

### Script Bash/Python

**REGOLA**: Tutti gli script in `bashscripts/{categoria}/`

**Stato**: ⚠️ Script fuori posto identificati

**Script da Spostare**:
- `docs/webmin/webmin-setup-repo.sh` → `bashscripts/webmin/webmin-setup-repo.sh`
- `docs/tools/phpstan_analyze.sh` → `bashscripts/quality-assurance/phpstan_analyze.sh`
- `docs/tools/copy_to_mono.sh` → `bashscripts/utilities/copy_to_mono.sh`
- `docs/composer/*.sh` → `bashscripts/composer/`
- `docs/backup/*.sh` → `bashscripts/backup/`
- `docs/git/*.sh` → `bashscripts/git/`

**Azione Richiesta**: Spostare script in categorie appropriate e aggiornare riferimenti.

## 🔍 Analisi Moduli PHPStan

### Moduli con Errori

| Modulo | Errori | Priorità |
|--------|--------|----------|
| Incentivi | 42 | Alta |
| UI | 32 | Alta |

### Moduli Conformi (0 errori)

- Activity, Badge, CertFisc, ContoAnnuale, DbForge, Europa, Gdpr, Inail, IndennitaCondizioniLavoro, IndennitaResponsabilita, Job, Lang, Legge104, Legge109, Media, Mensa, MobilitaVolontaria, Notify, Pdnd, Performance, Prenotazioni, PresenzeAssenze, Progressioni, Ptv, Questionari, Rating, Setting, Sigma, Tenant, User, Xot

## 📝 Documentazione Moduli

### Struttura Documentazione

Ogni modulo deve avere:
- `docs/README.md` - Panoramica
- `docs/{feature}.md` - Feature specifiche
- Collegamenti bidirezionali con root docs

**Stato**: ✅ Struttura presente in tutti i moduli

## 🎯 Piano di Azione

### Priorità Alta

1. **Risolvere errori PHPStan**:
   - [ ] Incentivi (42 errori)
   - [ ] UI (32 errori)

2. **Migrare `protected $casts`**:
   - [ ] Identificare tutti i modelli (20+ file)
   - [ ] Migrare a `casts()` method
   - [ ] Verificare PHPStan dopo migrazione

### Priorità Media

3. **Spostare script fuori posto**:
   - [ ] Identificare tutti gli script in `docs/`
   - [ ] Categorizzare e spostare in `bashscripts/`
   - [ ] Aggiornare riferimenti e documentazione

4. **Verificare conformità file .md**:
   - [ ] Verificare nomi file nei moduli
   - [ ] Rinominare se necessario
   - [ ] Consolidare documentazione duplicata

### Priorità Bassa

5. **Ottimizzare documentazione**:
   - [ ] Consolidare file duplicati
   - [ ] Aggiornare collegamenti bidirezionali
   - [ ] Verificare coerenza tra moduli

## 📚 Documentazione Creata

1. **`docs/project-structure-analysis.md`** - Analisi completa struttura progetto
2. **`docs/compliance-report.md`** - Questo report
3. **`laravel/Modules/User/docs/filament-auth-pages-exceptions.md`** - Eccezioni regola XotBase
4. **`bashscripts/ci-cd/analyze-all-modules.sh`** - Script analisi completa
5. **`bashscripts/ci-cd/analyze-phpstan-only.sh`** - Script analisi PHPStan veloce
6. **`bashscripts/ci-cd/README.md`** - Documentazione script CI/CD

## 🔗 Collegamenti

- [Analisi Struttura](./project-structure-analysis.md)
- [Filosofia Progetto](./philosophy-guide.md)
- [Regole XotBase](../../bashscripts/docs/xotbase_critical_rules.md)
- [Regole Scripts](./rules/scripts-location.md)
- [Regole Model Casting](../../laravel/Modules/Xot/docs/model-casting-rules.md)
- [Eccezioni Auth Pages](../../laravel/Modules/User/docs/filament-auth-pages-exceptions.md)

---

**Ultimo aggiornamento**: 2025-12-17


