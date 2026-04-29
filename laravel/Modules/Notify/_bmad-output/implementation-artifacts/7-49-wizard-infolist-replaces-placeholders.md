# story 7-49: wizard infolist replaces placeholders

## stato

ready-for-dev

## richiesta

Valutare e applicare la sostituzione dei `Placeholder` nel wizard con componenti Infolists, mantenendo parity e stabilita' runtime.

## outcome

- eliminato l'ultimo `Placeholder` dal widget:
  - `privacy_notice` -> `TextEntry` con `->html()`
- il summary era gia' su `TextEntry`/`ImageEntry`
- import `Filament\Forms\Components\Placeholder` rimosso

## rationale

- Infolists rappresentano meglio il dominio read-only;
- riducono ambiguita' tra componenti form di input e componenti di visualizzazione;
- consolidano una regola unica, utile per prevenire regressioni architetturali.

## verifica

- `php -l Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` -> OK
- `curl -I --max-time 20 http://127.0.0.1:8000/it/tests/segnalazione-crea` -> `200`
- `curl -I --max-time 20 "...step=form.dati-della-segnalazione::data::wizard-step"` -> `200`

## file aggiornati

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Modules/Fixcity/docs/stories/wizard-infolist-replaces-placeholders.md`
- `laravel/Modules/Fixcity/docs/stories/index.md`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
