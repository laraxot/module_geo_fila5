# Filament v4 Migration Checklist - Modulo IndennitaResponsabilita
**Data**: 10 Dicembre 2025  
**Modulo**: IndennitaResponsabilita  
**Versione**: 4.0  
**Stato**: Ready for Implementation

## 🚨 CRITICAL CHANGES - VERIFICA OBBLIGATORIA

### 1. Grid/Section/Fieldset - columnSpanFull()

#### ✅ Files da Verificare
- [ ] `app/Filament/Resources/ImportiCategoriaResource.php`
- [ ] `app/Filament/Resources/IndennitaResponsabilitaResource.php`
- [ ] `app/Filament/Resources/LettFResource.php`
- [ ] `app/Filament/Resources/LettIResource.php`
- [ ] `app/Filament/Resources/MailTemplateResource.php`
- [ ] `app/Filament/Resources/MessageResource.php`
- [ ] `app/Filament/Resources/RatingResource.php`
- [ ] `app/Filament/Resources/StabiDirigenteResource.php`

#### 🔍 Pattern da Cercare
```bash
grep -r "Section::make\|Grid::make\|Fieldset::make" laravel/Modules/IndennitaResponsabilita/app/Filament/
```

#### ✅ Correzione Obbligatoria
```php
// Trovare e correggere
Section::make('Titolo')
    ->columnSpanFull() // AGGIUNGERE
    ->schema([...])

Grid::make(2)
    ->columnSpanFull() // AGGIUNGERE
    ->schema([...])

Fieldset::make('Gruppo')
    ->columnSpanFull() // AGGIUNGERE
    ->schema([...])
```

### 2. unique() Validation

#### ✅ Files da Verificare
- [ ] Tutti i Resource con validazioni unique
- [ ] Form con campi email, codice fiscale, matricola

#### 🔍 Pattern da Cercare
```bash
grep -r "->unique()" laravel/Modules/IndennitaResponsabilita/app/Filament/
```

#### ✅ Correzione Obbligatoria
```php
// Verificare comportamento
TextInput::make('email')
    ->unique(ignoreRecord: false) // Esplicitare se necessario

TextInput::make('matricola')
    ->unique(ignoreRecord: true) // Per form di edit
```

### 3. Table Filters

#### ✅ Files da Verificare
- [ ] Tutte le pagine List
- [ ] `ListImportiCategorias.php`
- [ ] `ListIndennitaResponsabilitas.php`
- [ ] `ListLettFs.php`
- [ ] `ListLettIs.php`
- [ ] `ListRatings.php`
- [ ] `ListStabiDirigentes.php`

#### ✅ Correzione Obbligatoria
```php
public function table(Table $table): Table
{
    return $table
        ->deferFilters(false) // Aggiungere per comportamento v3
        // ... resto configurazione
}
```

### 4. Radio Components

#### ✅ Files da Verificare
- [ ] Tutti i form con Radio::make()

#### 🔍 Pattern da Cercare
```bash
grep -r "Radio::make" laravel/Modules/IndennitaResponsabilita/app/Filament/
```

#### ✅ Correzione Obbligatoria
```php
Radio::make('tipo')
    ->inline()
    ->inlineLabel() // Aggiungere per comportamento v3
```

## 📋 VERIFICHE SPECIFICHE MODULO

### LettIResource - Già Corretto ✅
- [x] Metodo `form()` → `getFormSchema()` già corretto
- [x] Rimossi hardcoded labels
- [x] Conformità regole Laraxot

### Rating System
- [ ] Verificare form rating con componenti layout
- [ ] Controllare validazioni unique su campi rating
- [ ] Testare filtri tabelle rating

### Mail Templates
- [ ] Verificare form template con Section/Grid
- [ ] Controllare validazioni unique su template names
- [ ] Testare layout form composizione

### Message System
- [ ] Verificare form message con Fieldset
- [ ] Controllare validazioni unique su message types
- [ ] Testare layout form messaggi

## 🧪 TESTING PLAN

### 1. Form Testing
- [ ] Testare tutti i form per layout corretto
- [ ] Verificare validazioni unique
- [ ] Testare comportamento filtri
- [ ] Verificare componenti Radio

### 2. Table Testing
- [ ] Testare tutte le tabelle
- [ ] Verificare filtri funzionanti
- [ ] Testare ordinamento
- [ ] Verificare paginazione

### 3. Integration Testing
- [ ] Testare flussi completi
- [ ] Verificare relazioni tra modelli
- [ ] Testare azioni bulk
- [ ] Verificare esportazione dati

## 🔄 SCRIPT VERIFICA AUTOMATICA

```bash
#!/bin/bash
echo "=== VERIFICA FILAMENT V4 - IndennitaResponsabilita ==="

echo "1. Ricerca Grid/Section/Fieldset..."
find laravel/Modules/IndennitaResponsabilita/app/Filament -name "*.php" -exec grep -H "Section::make\|Grid::make\|Fieldset::make" {} \;

echo "2. Ricerca validazioni unique..."
find laravel/Modules/IndennitaResponsabilita/app/Filament -name "*.php" -exec grep -H "->unique()" {} \;

echo "3. Ricerca Radio components..."
find laravel/Modules/IndennitaResponsabilita/app/Filament -name "*.php" -exec grep -H "Radio::make" {} \;

echo "4. Ricerca Table Filters..."
find laravel/Modules/IndennitaResponsabilita/app/Filament -name "*.php" -exec grep -H "deferFilters\|getTableFilters" {} \;

echo "=== VERIFICA COMPLETATA ==="
```

## 📊 STATO IMPLEMENTAZIONE

| Componente | Files | Stato | Priorità |
|------------|-------|-------|----------|
| Forms Layout | 8+ | 🟡 Da Verificare | CRITICA |
| Validazioni | 5+ | 🟡 Da Verificare | ALTA |
| Table Filters | 6+ | 🟡 Da Verificare | MEDIA |
| Radio Components | 2+ | 🟡 Da Verificare | MEDIA |

## 🚨 RISCHI CRITICI

1. **Layout Forms Rotto**: Grid/Section senza columnSpanFull()
2. **Validazioni Errate**: unique() con comportamento inaspettato
3. **Filtri Non Funzionanti**: deferFilters() non configurato
4. **Componenti Radio**: Layout inline rotto

## 📋 CHECKLIST FINALE

### Pre-Deploy
- [ ] Tutti i form testati manualmente
- [ ] PHPStan Level 10 passed
- [ ] Test automatici passanti
- [ ] Documentazione aggiornata

### Post-Deploy
- [ ] Monitoraggio errori
- [ ] Feedback utenti
- [ ] Performance monitoring
- [ ] Regression testing

---

## 🎯 NEXT STEPS

1. **Eseguire script verifica** per identificare problemi
2. **Correggere Grid/Section/Fieldset** in tutti i form
3. **Testare validazioni unique** in ambiente staging
4. **Aggiornare documentazione** modulo
5. **Formazione team** sui nuovi pattern

---

**Versione**: 1.0  
**Stato**: Ready for Implementation  
**Deadline**: 17 Dicembre 2025  
**Owner**: Team IndennitaResponsabilita