# story 7-46: segnalazione-crea loop recurrence import and summary guard

## stato

ready-for-dev

## contesto

Su `http://127.0.0.1:8000/it/tests/segnalazione-crea` si e' ripresentato il problema percepito come loop:

- prima timeout lato endpoint;
- poi `500` con `Class "Modules\Fixcity\Filament\Widgets\TextEntry" not found`.

## root cause

1. regressione import su Infolists (`TextEntry`/`ImageEntry`);
2. assenza di guard statico su import + naming summary;
3. server dev single-thread bloccato che amplifica la percezione di loop.

## fix applicata

- ripristinati gli import Infolists nel widget;
- mantenute chiavi summary `review_*` anti-collisione;
- rinforzato `laravel/bashscripts/quality/check-fixcity-wizard-guards.sh` con:
  - check import obbligatori,
  - check naming anti-ricorsione,
  - `php -l` obbligatorio.

## verifica

- `composer run-script guard:fixcity-wizard` -> OK
- `curl -I --max-time 20 http://127.0.0.1:8000/it/tests/segnalazione-crea` -> `200`

## file toccati

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/bashscripts/quality/check-fixcity-wizard-guards.sh`
- `laravel/Modules/Fixcity/docs/rules/filament-wizard-rules.md`
- `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md`
- `laravel/Modules/Fixcity/docs/stories/wizard-timeout-recurrence-import-and-infolist-guard.md`

