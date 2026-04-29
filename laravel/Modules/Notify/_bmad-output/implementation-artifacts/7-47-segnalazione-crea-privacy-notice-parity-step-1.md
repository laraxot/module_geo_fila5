# story 7-47: segnalazione-crea privacy notice parity step 1

## stato

ready-for-dev

## problema

Nello step privacy del wizard unificato mancava il testo legale GDPR presente nel reference Design Comuni.
L'utente vedeva sostanzialmente solo il checkbox, con perdita di parity informativa.

## soluzione

Nel metodo `getPrivacySchema()` e' stato aggiunto un blocco read-only `privacy_notice` (Filament `Placeholder`) che mostra:

- intro GDPR (`fixcity::segnalazione.privacy.intro.text`)
- prefisso dettaglio (`fixcity::segnalazione.privacy.detail_prefix.text`)
- link informativa (`fixcity::segnalazione.privacy.link.label`) con URL da `blockData['privacy_link']`

Il checkbox `privacyAccepted` resta il controllo di consenso finale.

## perche'

- parity con `segnalazione-01-privacy.html`;
- separazione corretta tra informazione legale e azione di consenso;
- multilingua via traduzioni modulo, senza hardcode runtime.

## verifica

- `php -l Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` -> OK
- GET su step privacy con query `step=...privacy...` -> pagina renderizzata
- presenza testo "Il Comune di Firenze gestisce i dati personali..." -> confermata

## file aggiornati

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Modules/Fixcity/docs/stories/wizard-privacy-notice-parity-step-1.md`
- `laravel/Modules/Fixcity/docs/stories/index.md`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
