# User Wiki Log

## [2026-05-05] hardening | spatie permission team model on Laravel 13
- studiata documentazione ufficiale Spatie Permission v7 e codice vendor locale (`Config`, `PermissionRegistrar`, `HasRoles`).
- confermato lock locale: `spatie/laravel-permission 7.4.1`, compatibile con Laravel 13 e PHP 8.3.
- aggiunto hardening in `UserServiceProvider`: il modulo User riafferma `permission.models.permission`, `permission.models.role`, `permission.models.team` e riallinea `PermissionRegistrar`.
- nuova doc operativa: `../spatie-permission-teams-laravel-13.md`.
- aggiornato troubleshooting: `troubleshooting/spatie-permission-team-model-not-configured.md`.

## [2026-04-28] fix | spatie permission team model config missing su route admin
- errore runtime gestito: `Spatie\Permission\Exceptions\TeamModelNotConfigured` su `/admin`.
- root cause: `teams => true` senza `models.team` in `permission.php`.
- fix applicato in tutti i profili config (`config/permission.php` + varianti `config/*/permission.php`) con:
  `models.team => Modules\User\Models\Team::class`.
- verifica runtime eseguita con `php artisan tinker --execute="dump(config('permission.models.team'));"`.
- nuova pagina troubleshooting: `troubleshooting/spatie-permission-team-model-not-configured.md`.

## [2026-04-28] docs | hardening migrazioni MariaDB create/alter boundary
- aggiunta pagina `concepts/mariadb-create-table-after-rule.md`.
- formalizzata regola DRY+KISS: `after()` vietato in `tableCreate()`, ammesso solo in `tableUpdate()`.
- aggiunte sezioni operative: best practices, bad practices, false friends, checklist e link ufficiali verificati.
- aggiornato `index.md` con il nuovo concetto.
- ingest eseguito in QMD index `fixcity` (collection `wiki` aggiornata).

## [2026-04-28] bugfix | profiles create migration MariaDB `after()` syntax error
- errore osservato in migration `2026_04_28_120000_create_profiles_table`:
  SQL syntax error vicino a `after id` in `CREATE TABLE`.
- root cause: `->after('id')` usato nel blocco `tableCreate()` su colonna `uuid`.
- fix applicato: rimosso `after()` dal create; `after()` resta nel `tableUpdate()`
  idempotente (ALTER path).
- verifica:
  `php artisan migrate --path=Modules/User/database/migrations/2026_04_28_120000_create_profiles_table.php --realpath --force`
  eseguito con esito `DONE`.
- docs aggiornati: `concepts/profile-migration-uuid-contract.md`.

## [2026-04-27] governance | policy matrix adoption from Xot
- allineata la documentazione User alla matrice cross-modulo (`policy-module-matrix`).
- esplicitata raccomandazione: moduli business non identity-first -> default `XotBasePolicy`.
- mantenuto `UserBasePolicy` per dominio identity/access.

## [2026-04-27] governance | policy inheritance boundary User vs Xot
- documentata la regola decisionale su quando usare `UserBasePolicy` e quando preferire `XotBasePolicy`.
- chiarito che `UserBasePolicy` e' specializzazione dominio identity, non base universale per tutti i moduli.
- nuova pagina: `concepts/policy-inheritance-boundary.md`.

## [2026-04-27] governance | remove invalid additive migration on profiles
- rimosso `database/migrations/2026_04_27_000000_add_credits_to_profiles_table.php`
  per violazione regola "1 modello = 1 migrazione owner".
- chiarito boundary: il contratto `profiles` e' owner Fixcity; User non deve patchare schema `profiles`.
- nuova pagina: `concepts/profiles-ownership-boundary-rule.md`.

## [2026-04-20] bugfix | socialite provider page property type compatibility
- risolto fatal php su `SocialiteProviderSettingsPage` per incompatibilita tipi proprieta con classi base Filament/Xot.
- fix applicati:
  - `$view` da static a non-static
  - `$navigationGroup` tipizzato come `\UnitEnum|string|null`
  - `$navigationIcon` tipizzato come `\BackedEnum|string|null`
- validazione: il comando `php artisan make:filament-user` non va piu in fatal, ora richiede solo input obbligatori.

## [2026-04-20] governance | no label no tooltip in filament
- corretto `SocialiteProviderSettingsPage`: rimossi tutti gli override `->label(...)` sui campi provider.
- corretto `SocialProviderResource`: sostituito `->label(...)` su placeholder con `->hiddenLabel()`.
- aggiunta regola persistente in `concepts/filament-langserviceprovider-governance.md`.

## [2026-04-20] i18n | login page strings moved to user module
- regola applicata: nessuna frase italiana hardcoded nel tema.
- spostate le frasi della pagina login in `User/lang/*/auth.php` sotto `login.page.*`.
- adottata struttura a 5 elementi (`label`, `tooltip`, `placeholder`, `helper_text`, `description`) per ogni nuova chiave.
- `Themes/Sixteen/resources/views/pages/auth/login.blade.php` ora usa solo chiavi `user::auth...`.

## [2026-04-20] socialite | env-first admin guidance
- confermata preferenza operativa: credenziali social in `.env`, non in colonne dedicate utenti.
- aggiornata `SocialProviderResource` con guida visibile in form (passi + comandi cache/config).
- resi non obbligatori in UI i campi `client_id` e `client_secret` per supportare flusso env-first.
- aggiornato tutorial `concepts/socialite-admin-tutorial.md` con `php artisan optimize:clear`.

## [2026-04-20] socialite | governance + setup
- Aggiunta pagina `concepts/socialite-provider-governance.md` con regola: no colonne `google_id/facebook_id` su `users`.
- Aggiunta pagina `concepts/socialite-backoffice-google-setup.md` con procedura backoffice Filament per Google OAuth.
- Collegati i nuovi contenuti all'indice wiki modulo User.

## [2026-04-15] init | wiki bootstrap
- Struttura wiki/log.md inizializzata.
- Layer raw: tutti i file in `docs/` (eccetto `wiki/`).
- Layer wiki: `docs/wiki/` — LLM-maintained, sintesi ad alto riuso.
- Schema: `docs/.schema/WIKI_SCHEMA.md`
- Adozione moduli: `docs/project/llm-wiki-module-adoption.md`

## [2026-04-20] bugfix | profiles.uuid nella migrazione canonica unica
- errore osservato: `table profiles has no column named uuid` durante insert su `Profile`.
- causa: `BaseProfile::booted()` genera `uuid`, ma una installazione aveva schema `profiles` senza colonna corrispondente.
- fix applicato:
  - confermata una sola migrazione autorevole `create_profiles_table`
  - migrazione rinominata a `2026_04_20_173500_create_profiles_table.php` per riesecuzione idempotente
  - regola documentata in `concepts/profile-migration-uuid-contract.md`

<<<<<<< HEAD
## [2026-04-27] discussion | Policy Inheritance Boundary
- Created: concepts/policy-inheritance-boundary.md (decisione architetturale)
- Updated: index.md (aggiunto cross-reference)
- Decision: Mantenere separazione UserBasePolicy vs XotBasePolicy
- Rationale: Dependency isolation, contract clarity, module boundaries, testing flexibility
- Best practices documentate: type-hint UserContract, permission dot notation, test con permessi reali
- Enhancements proposti: canAny(), canAll(), scope(), after() hooks
- Commit: docs: document policy inheritance boundary decision
=======
## [2026-04-29] update | local second brain operating loop
- Aggiornata `concepts/user-module-operating-focus.md` con loop locale second brain (retrieve -> distill -> index -> log).
- Allineato il comportamento documentale del modulo User al ciclo `/bmad-create-story` del progetto.

## [2026-04-29] update | user docs continuous checklist
- Aggiunta checklist operativa locale per enforce continuo pre-task/in-task/post-task.
- Rafforzata la regola di escalation verso root wiki solo per decisioni cross-module.

## [2026-04-29] update | super-admin icon state clarity
- Allineata la UI di `livewire/profile/super-admin.blade.php` a icone Heroicon outline distinte (stato super-admin vs negate-super-admin).
- Rimossa la dipendenza dal `rotate-180` sull'icon-button, sostituita con semantica visiva esplicita e micro-animazione hover.

## [2026-04-29] update | custom svg super-admin icons
- Creati `resources/svg/superadmin.svg` e `resources/svg/negate-superadmin.svg` nel modulo User.
- Aggiornate le view badge/profile per usare `user-superadmin` e `user-negate-superadmin` con micro-animazione hover.
>>>>>>> 063e390e9 (.)
