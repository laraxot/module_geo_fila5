# Modulo PTV - Documentazione

## 📚 Overview

Il modulo **PTV (Provincia di Treviso)** gestisce le schede di valutazione, generazione PDF e invio email automatizzato per il sistema di valutazione del personale.

---

## 🎯 Funzionalità Principali

### 1. **Gestione Schede Valutazione**
- CRUD completo schede valutazione
- Workflow approvazione multi-livello
- Storicizzazione modifiche

### 2. **Generazione PDF Dinamica**
- PDF generati al volo da template Blade
- Layout personalizzato per ogni tipo scheda
- Supporto immagini, tabelle, firme digitali

### 3. **Sistema Invio Email**
- Invio automatico schede via email
- Allegati PDF dinamici
- Template email personalizzabili
- Bulk actions per invii massivi
- **Activity Log** - Tracciamento completo ogni invio con dati valutazione

### 4. **Export e Reporting**
- Export schede in PDF
- Creazione archivi ZIP multipli
- Generazione report aggregati

---

## 📖 Documentazione Disponibile

### Guide Complete
- **[PDF Email Attachments - Guida Completa](./pdf-email-attachments-complete-guide.md)**  
  Guida completa al sistema di generazione PDF e allegati email

### Guide Tecniche
- **[Email Sending Activity Log](./email-sending-activity-log.md)**  
  Tracciamento completo invii email con Spatie Activity Log e QueueableActions

- **[PrepareEvaluationDataAction](./prepare-evaluation-data-action.md)**  
  Action per estrarre dati valutazione da record scheda

- **[LogEmailSentAction](./log-email-sent-action.md)**  
  Action per registrare activity log di invii email riusciti

- **[LogEmailErrorAction](./log-email-error-action.md)**  
  Action per registrare activity log di errori invio email

- **[Filament Resources](./filament-resources.md)**  
  Configurazione risorse Filament per schede

- **[Filament 4 Migration Bugfix](./filament4-migration-bugfix.md)**  
  Fix post-migrazione Filament 4

- **[Message Resource Type Field](./message-resource-type-field-improvement.md)**  
  Miglioramenti campo tipo messaggio

### Documentazione Modelli
- **[Models Documentation](./models/)**  
  Documentazione dei modelli dati

### Documentazione Performance
- **[Performance Documentation](./performance/)**  
  Ottimizzazioni e performance

### Aggiornamento 19/11/2025
- Traduzioni di navigazione aggiornate per `StabiDirigente` e `CriteriOption` con etichette in italiano, gruppo coerente **Organizzazione/Performance** e icone Heroicon per eliminare i placeholder `.navigation`.

---

## 🏗️ Architettura

### Struttura Directory

```
Modules/Ptv/
├── app/
│   ├── Actions/              # Azioni business logic
│   │   ├── Scheda/
│   │   │   ├── SendMailByRecord.php          ⭐ Invio email con PDF
│   │   │   ├── SendMailByRecords.php         ⭐ Invio email massivo
│   │   │   ├── GetFilenameBySchedaAction.php ⭐ Generazione nome file PDF
│   │   │   ├── PrepareEvaluationDataAction.php ⭐ Estrazione dati valutazione
│   │   │   ├── LogEmailSentAction.php        ⭐ Logging invii riusciti
│   │   │   └── LogEmailErrorAction.php        ⭐ Logging errori invio
│   │   └── Pdf/
│   │       └── MakePdfByRecord.php
│   │  
│   ├── Filament/            # Risorse e componenti Filament
│   │   ├── Resources/
│   │   ├── Actions/
│   │   │   └── Bulk/
│   │   │       ├── SendSchedeBulkAction.php
│   │   │       └── ZipSchedeBulkAction.php
│   │   └── Widgets/
│   │  
│   ├── Models/              # Modelli Eloquent
│   │   ├── Scheda.php
│   │   └── Contracts/
│   │       └── SchedaContract.php
│   │  
│   ├── Mail/                # Mail generiche
│   │   └── SchedaMail.php
│   │  
│   └── Notifications/       # Notifiche custom
│       └── SendSchedeNotification.php
│  
├── resources/
│   └── views/
│       ├── scheda/
│       │   └── show/
│       │       └── pdf.blade.php        ⭐ Template PDF schede
│       └── emails/
│           └── scheda.blade.php
│  
└── docs/                    # Documentazione modulo
    ├── README.md            ⭐ QUESTO FILE
    └── pdf-email-attachments-complete-guide.md
```

---

## 🚀 Quick Start

### Invio Email Singola con PDF

```php
use Modules\Ptv\Actions\Scheda\SendMailByRecord;

$scheda = Scheda::find(123);
$result = app(SendMailByRecord::class)->execute($scheda, 'schede');

if ($result) {
    // Email inviata con successo con PDF allegato
}
```

### Generazione PDF Standalone

```php
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;

$scheda = Scheda::find(123);
$pdfBinary = app(GetPdfContentByRecordAction::class)->execute($scheda);

// Salva su filesystem
Storage::disk('public')->put('schede/scheda_123.pdf', $pdfBinary);

// Oppure download diretto
return response($pdfBinary)
    ->header('Content-Type', 'application/pdf')
    ->header('Content-Disposition', 'attachment; filename="scheda.pdf"');
```

### Bulk Action Invio Email

```php
// In Filament Resource
Tables\Actions\BulkAction::make('send_emails')
    ->label('Invia Email')
    ->action(function ($records) {
        foreach ($records as $record) {
            app(SendMailByRecord::class)->execute($record);
        }
        Notification::success('Email inviate!');
    });
```

---

## 🔗 Collegamenti Esterni

### Moduli Correlati

#### Xot (Core Framework)
- **[GetPdfContentByRecordAction](../../Xot/docs/actions/pdf-content-generation-technical.md)**  
  Action core per generazione PDF binario

#### Notify (Sistema Email/Notifiche)
- **[Email Attachments Usage](../../Notify/docs/email-sending/attachments_usage.md)**  
  Come gestire allegati nelle email
  
- **[RecordNotification](../../Notify/docs/notifications/record-notification.md)**  
  Sistema notifiche con allegati
  
- **[SpatieEmail](../../Notify/app/Emails/SpatieEmail.php)**  
  Classe email con supporto allegati binari

---

## 🧪 Testing

### Test Unitari

```php
use Tests\TestCase;
use Modules\Ptv\Actions\Scheda\SendMailByRecord;

class SendMailByRecordTest extends TestCase
{
    /** @test */
    public function it_sends_email_with_pdf_attachment(): void
    {
        $user = User::factory()->create();
        $scheda = Scheda::factory()->create();
        
        $this->actingAs($user);
        
        $result = app(SendMailByRecord::class)->execute($scheda);
        
        $this->assertTrue($result);
        Mail::assertSent(/* ... */);
    }
}
```

### Test Feature

```bash
php artisan test --filter=SendMailByRecord
```

---

## 🛠️ Troubleshooting

### Problema: PDF non generato

**Causa:**  Vista PDF non trovata o errori HTML

**Soluzione:**
```bash
# Verifica esistenza vista
php artisan view:list | grep "scheda.show.pdf"

# Debug vista PDF
php artisan tinker
>>> $scheda = \Modules\Ptv\Models\Scheda::first();
>>> $html = view('ptv::scheda.show.pdf', ['row' => $scheda])->render();
>>> dd($html);
```

### Problema: Email non arriva

**Causa:** Configurazione SMTP errata o allegato corrotto

**Soluzione:**
```bash
# Test configurazione email
php artisan tinker
>>> Mail::raw('Test', function($msg) { $msg->to('test@example.com'); });

# Verifica log
tail -f storage/logs/laravel.log
```

### Problema: PHPStan Errors

**Soluzione:**
```bash
cd laravel
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Ptv --level=10
```

---

## 📊 Performance

### Ottimizzazioni Applicate

1. **Eager Loading** - Relazioni pre-caricate per evitare N+1
2. **PDF In-Memory** - Generazione PDF completamente in memoria (no file temporanei)
3. **Queue Support** - Spatie QueueableAction per invii massivi
4. **Binary Attachments** - Allegati binari diretti (no scrittura disco)

### Benchmark Tipici

| Operazione | Tempo Medio |
|------------|-------------|
| Genera PDF singolo | 100-300ms |
| Invia email con PDF | 500ms-1s |
| Bulk 100 schede | 30-60s |

---

## 🔐 Sicurezza

### Controlli Implementati

- ✅ **Authorization Gates** - Controllo permessi `can('sendMail', $record)`
- ✅ **Input Validation** - Validazione record con Webmozart Assert
- ✅ **SQL Injection** - Eloquent ORM (no raw queries)
- ✅ **XSS Protection** - Template Blade con escaping automatico
- ✅ **Rate Limiting** - Throttle su azioni massively

---

## 📝 Changelog

### v1.0.0 (2025-01-22)
- ✨ Sistema generazione PDF completo
- ✨ Invio email con allegati binari
- ✨ Bulk actions Filament
- ✨ Documentazione completa
- ✅ PHPStan Level 10 compliant

---

## 👥 Contributori

- **Team Laraxot** - Architettura e implementazione core
- **Provincia di Treviso** - Specifiche business e testing

---

## 📄 Licenza

Proprietario - Provincia di Treviso

---

**Ultimo aggiornamento:** 19 Novembre 2025  
**Versione:** 1.0.0  
**Stato:** ✅ Production Ready

## 🚀 Release su GitHub
Le release sono basate su tag Git e possono includere release notes generate automaticamente.
Workflow locale: `.github/workflows/release.yml`.
