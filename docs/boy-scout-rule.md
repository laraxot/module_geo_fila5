# Regola del Buon Boy Scout - Progetto <nome progetto>

## Principio Fondamentale
**"Lascia il campo più pulito di come l'hai trovato"**

## Significato e Importanza
Questa regola è **SACRA** e **IMMUTABILE** nel progetto <nome progetto>. Ogni modifica al codice deve migliorare la codebase, non peggiorarla. La qualità del codice è responsabilità di ogni sviluppatore.

## Applicazione Globale

### In Tutti i Moduli
- **<nome progetto>**: Factory, seeder, modelli e documentazione
- **User**: Autenticazione, autorizzazione e gestione utenti
- **UI**: Componenti, widget e interfacce
- **Xot**: Funzionalità base e convenzioni

### In Tutti i File
- **PHP**: Codice più pulito, tipizzato e documentato
- **Markdown**: Documentazione completa e aggiornata
- **Blade**: Template organizzati e riutilizzabili
- **Config**: Configurazioni chiare e documentate

## Esempi di Applicazione

### Factory e Seeder
```php
// PRIMA: Errori e colonne non esistenti
'birth_date' => now()->subYears(random_int(18, 80)), // ❌ Colonna inesistente

// DOPO: Factory corretta e tipizzata
'date_of_birth' => now()->subYears(random_int(18, 80)), // ✅ Colonna corretta
```

### Documentazione
```markdown
// PRIMA: Documentazione frammentaria
# Factory
- PatientFactory
- DoctorFactory

// DOPO: Documentazione completa
# Factory e Seeder
## PatientFactory
- Campi principali e specifici
- Stati personalizzati disponibili
- Esempi di utilizzo
- Best practices
```

## Checklist di Verifica Globale

### Prima di ogni modifica:
- [ ] Ho studiato la documentazione esistente?
- [ ] Ho compreso la struttura del progetto?
- [ ] Ho identificato le aree di miglioramento?

### Durante la modifica:
- [ ] Sto migliorando il codice esistente?
- [ ] Sto seguendo le convenzioni del progetto?
- [ ] Sto documentando le modifiche?

### Dopo la modifica:
- [ ] Il codice è più pulito di prima?
- [ ] La documentazione è stata aggiornata?
- [ ] I test passano e sono migliorati?
- [ ] La struttura è più organizzata?

## Responsabilità nel Progetto

### Sviluppatore:
- Applicare SEMPRE la regola del buon boy scout
- Migliorare il codice esistente
- Aggiornare sempre la documentazione

### Team Lead:
- Verificare il rispetto della regola
- Rifiutare modifiche che degradano la qualità
- Promuovere miglioramenti continui

### Code Review:
- Verificare sempre il rispetto della regola
- Richiedere miglioramenti se necessario
- Non approvare mai degradazioni del codice

## Anti-Pattern da Evitare

1. **"Fix later"**: Mai lasciare TODO o commenti di fix futuro
2. **"Works for me"**: Mai accettare codice che funziona ma è sporco
3. **"Quick fix"**: Mai fare modifiche rapide senza pulizia
4. **"Someone else will fix it"**: Mai delegare la pulizia ad altri
5. **"It's not my code"**: Mai ignorare problemi nel codice esistente

## Collegamenti

- [Regola Cursor](../../.cursor/rules/boy-scout-rule.mdc)
- [Regola <nome progetto>](../laravel/modules/<nome progetto>/docs/boy-scout-rule.md)
- [Convenzioni Laraxot](laraxot-conventions.md)
- [Best Practices](best-practices.md)

---

**⚠️ RICORDA SEMPRE: Questa regola è SACRA e non può essere violata. Ogni modifica deve migliorare la codebase.**
# Regola del Boy Scout nel Progetto <nome progetto>

## Introduzione
Questo documento documenta l'implementazione e l'applicazione della **Regola del Boy Scout** nel progetto <nome progetto> come principio fondamentale di sviluppo.
# Regola del Boy Scout nel Progetto <nome progetto>

## Introduzione
Questo documento documenta l'implementazione e l'applicazione della **Regola del Boy Scout** nel progetto <nome progetto> come principio fondamentale di sviluppo.

## Definizione Ufficiale
> **"Lascia sempre il campeggio più pulito di come l'hai trovato"**

**Applicazione nella programmazione**: Quando si lavora sul codice (sia che lo si scriva da zero, sia che si modifichi del codice esistente), si deve **sempre migliorarlo** in qualche modo, lasciandolo **più pulito, più leggibile e più manutenibile** di quanto non fosse prima.

## Applicazioni Documentate

### Miglioramento Trait SushiToJson
**File**: `Modules/Tenant/app/Models/Traits/SushiToJson.php`
**Documentazione**: [Modules/Tenant/docs/traits/sushi-to-jsons.md](../Modules/Tenant/docs/traits/sushi-to-jsons.md)

**Miglioramenti applicati:**
- ✅ Rimosso codice commentato e debug statements
- ✅ Aggiunta tipizzazione completa e PHPDoc
- ✅ Implementata gestione errori robusta
- ✅ Aggiunto logging appropriato per debugging
- ✅ Implementato pattern observer pulito
- ✅ Aggiornata documentazione con esempi pratici

### Factory <nome progetto> (In Progress)
**Files**: `Modules/<nome progetto>/database/factories/`
### Factory <nome progetto> (In Progress)
**Files**: `Modules/<nome progetto>/database/factories/`
**Obiettivo**: Migliorare i factory per creare 100 pazienti e 100 dottori con dati realistici

## Checklist Generale
Ogni intervento deve seguire questa checklist:

1. **Pre-Analysis**
   - [ ] Studio documentazione modulo più vicino
   - [ ] Analisi struttura esistente
   - [ ] Identificazione aree di miglioramento

2. **Implementation**
   - [ ] Rifattorizzazione codice correlato
   - [ ] Miglioramento tipizzazione e PHPDoc
   - [ ] Rimozione codice morto e pattern obsoleti
   - [ ] Applicazione best practices

3. **Documentation**
   - [ ] Aggiornamento documentazione modulo
   - [ ] Aggiornamento documentazione root
   - [ ] Creazione collegamenti bidirezionali

4. **Quality Assurance**
   - [ ] Conformità PHPStan livello 9+
   - [ ] Rispetto naming conventions
   - [ ] Verifica standard Laraxot

## Impact Tracking

### Debt Tecnico Ridotto
- Trait SushiToJson: Rimosso ~40 righe di codice commentato
- Migliorata leggibilità e manutenibilità del codice
- Implementata gestione errori robusta

### Qualità Documentazione
- Documentazione trait completamente aggiornata
- Esempi pratici e strutture dati documentate
- Collegamenti bidirezionali tra moduli

### Standard Applicati
- PSR-12 compliance
- PHPDoc completo con tipizzazione
- Error handling robusto
- Logging pattern appropriato

## Prossimi Obiettivi
1. Applicare Boy Scout Rule ai factory <nome progetto>
1. Applicare Boy Scout Rule ai factory <nome progetto>
2. Migliorare documentazione factory e seeder
3. Creare esempi pratici per sviluppatori
4. Standardizzare pattern across tutti i moduli

## Link e Riferimenti

### Regole
- [.cursor/rules/boy-scout-rule.md](../.cursor/rules/boy-scout-rule.md)
- [.windsurf/rules/boy-scout-rule.mdc](../.windsurf/rules/boy-scout-rule.mdc)

### Implementazioni
- [Modules/Tenant/docs/traits/sushi-to-jsons.md](../Modules/Tenant/docs/traits/sushi-to-jsons.md)
- [Modules/<nome progetto>/docs/](../Modules/<nome progetto>/docs/) (in progress)
- [Modules/<nome progetto>/docs/](../Modules/<nome progetto>/docs/) (in progress)

### Root Documentation
- [README.md](./README.md)
- [laraxot-conventions.md](./laraxot-conventions.md)

---
*Ultimo aggiornamento: 2025-01-07*
*Versione: 1.0*
*Status: Implementazione in corso*