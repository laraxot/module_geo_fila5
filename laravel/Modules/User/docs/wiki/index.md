# User Module LLM Wiki

Indice operativo del wiki User.

## Struttura canonica (sacred)

- [concepts/](./concepts/): Pattern architetturali e metodologie user/auth.
- [entities/](./entities/): Modelli e componenti chiave.
- [sources/](./sources/): Dati di ricerca e link esterni.
- [comparisons/](./comparisons/): Implementazioni alternative.
- [decisions/](./decisions/): ADL (Architectural Decision Log).
- [troubleshooting/](./troubleshooting/): Problemi noti e soluzioni.
- [_archive/](./_archive/): Documentazione legacy.
- [_templates/](./_templates/): Template standard.

## Regole collegate

- [forbidden-folders-rule](../../../../docs/wiki/concepts/forbidden-folders.md): Vincoli strutturali strict.
- [llm-wiki-standard](../../../../docs/project/karpathy-llm-wiki-adoption.md): Mapping repository e ciclo di vita conoscenza.
- [laravel-socialite](../../../../docs/wiki/concepts/laravel-socialite.md): OAuth social authentication.
- [laravel-permission](../../../../docs/wiki/concepts/laravel-permission.md): RBAC Spatie Laravel Permission.

## On-Demand Entry Points

- [rules/INDEX](./rules/INDEX.md): regole operative ricorrenti su Filament, traduzioni e proprieta' navigazione.
- [skills/INDEX](./skills/INDEX.md): skill locali e condivise per audit traduzioni e creazione page Filament.

## Scopo User Module

Gestione utenti, profili, ruoli, permessi e autenticazione social (Socialite).

## Compiled Pages

| Pagina | Tipo | Argomento | Data |
|--------|------|-----------|------|
| [socialite-development](./concepts/socialite-development.md) | Concept | Socialite multi-provider | 2026-04-21 |
| [filament-langserviceprovider-governance](./concepts/filament-langserviceprovider-governance.md) | Concept | LangServiceProvider | 2026-04-21 |
| [login-page-design-comuni](./concepts/login-page-design-comuni.md) | Concept | Login Design Comuni | 2026-04-21 |
| [profile-migration-uid-contract](./concepts/profile-migration-uid-contract.md) | Concept | Profile UID | 2026-04-21 |
| [socialite-admin-configuration](./concepts/socialite-admin-configuration.md) | Concept | Socialite admin | 2026-04-21 |
| [socialite-admin-tutorial](./concepts/socialite-admin-tutorial.md) | Concept | Socialite tutorial | 2026-04-21 |
| [socialite-architecture-analysis](./concepts/socialite-architecture-analysis.md) | Concept | Socialite analysis | 2026-04-21 |
| [socialite-architecture](./concepts/socialite-architecture.md) | Concept | Socialite arch | 2026-04-21 |
| [socialite-backoffice-google-setup](./concepts/socialite-backoffice-google-setup.md) | Concept | Google setup | 2026-04-21 |
| [socialite-provider-governance](./concepts/socialite-provider-governance.md) | Concept | Provider governance | 2026-04-21 |
| [translation-5-level-structure](./concepts/translation-5-level-structure.md) | Concept | Translation 5-level | 2026-04-22 |
| [xotbasepage-inheritance-rules](./concepts/xotbasepage-inheritance-rules.md) | Concept | XotBasePage | 2026-04-21 |
| [xotbasepage-inheritance](./concepts/xotbasepage-inheritance.md) | Concept | XotBasePage | 2026-04-21 |
| [profiles-ownership-boundary-rule](./concepts/profiles-ownership-boundary-rule.md) | Concept | Profile ownership | 2026-04-27 |
| [policy-inheritance-boundary](./concepts/policy-inheritance-boundary.md) | Concept | Policy cross-module | 2026-04-27 |
| [profile-tenant-scoping](./concepts/profile-tenant-scoping.md) | Concept | Profile tenant | 2026-04-27 |
| [socialite-microsoft-tenant](./concepts/socialite-microsoft-tenant.md) | Concept | OAuth Microsoft | 2026-04-27 |
| [socialite-google-tenant](./concepts/socialite-google-tenant.md) | Concept | OAuth Google | 2026-04-27 |
| [socialite-github-tenant](./concepts/socialite-github-tenant.md) | Concept | OAuth GitHub | 2026-04-27 |
| [socialite-facebook-tenant](./concepts/socialite-facebook-tenant.md) | Concept | OAuth Facebook | 2026-04-27 |
| [socialite-linkedin-tenant](./concepts/socialite-linkedin-tenant.md) | Concept | OAuth LinkedIn | 2026-04-27 |
| [spatie-permission-teams-laravel-13](../spatie-permission-teams-laravel-13.md) | Guide | Spatie teams + Laravel 13 | 2026-05-05 |
| [no-filament-labels](./rules/no-filament-labels.md) | Rule | Filament senza label inline | 2026-05-12 |
| [filament-translation-audit](./skills/filament-translation-audit.md) | Skill | Audit traduzioni Filament User | 2026-05-12 |

## Best Practices

- Usare Spatie Laravel Permission per RBAC (vedi [laravel-permission](../../../../docs/wiki/concepts/laravel-permission.md))
- Implementare `casts()` method non `$casts` property (vedi [model-casts-phpstan](../../../../docs/wiki/concepts/model-casts-phpstan.md))
- Usare Socialite per OAuth (vedi [laravel-socialite](../../../../docs/wiki/concepts/laravel-socialite.md))
- Estendere XotBaseServiceProvider (vedi [laraxot-service-provider](../../../../docs/wiki/concepts/laraxot-service-provider.md))

## Bad Practices

- NON creare Service classes - usare Actions (vedi [actions-over-services-governance](https://github.com/laraxot/base_fixcity_fila5/blob/main/.opencode/skills/actions-over-services-governance/SKILL.md))
- NON usare `dehydrated(false)` nei trait - blocca salvataggio (vedi Geo CoordinatePicker fix)
- NON hardcodare password - usare `.env` (vedi [laravel-security-audit](../../../../docs/wiki/concepts/laravel-security-audit.md))

## False Friends

- `dehydrated(false)` sembra mantenere il campo nei dati ma blocca il salvataggio (vedi [coordinate-picker-filament5-save-pattern](../../Geo/docs/wiki/concepts/coordinate-picker-filament5-save-pattern.md))
- `live()` in Filament non rende il campo sempre live - serve `$applyStateBindingModifiers()` (vedi [coordinate-picker-state-binding-rule](../../Geo/docs/wiki/concepts/coordinate-picker-state-binding-rule.md))

## Troubleshooting

| Pagina | Tipo | Argomento |
|--------|------|-----------|
| [socialite-development](./concepts/socialite-development.md) | Concept | Socialite troubleshooting |
| [spatie-permission-team-model-not-configured](./troubleshooting/spatie-permission-team-model-not-configured.md) | Troubleshooting | Team model mancante in config permission |

## Raw Sources

Vedi [[../raw/index|Lista Sorgenti Grezzi]]

## Index Globale

Vedi [[../../../../docs/wiki/index|Index Globale Wiki]]

---

Ultimo aggiornamento: 2026-05-12
