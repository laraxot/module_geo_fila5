# Conflict Resolution — Module User

## Summary
- **Files resolved**: 48
- **Strategy**: Keep HEAD/local (ours) side
- **Root cause**: Nested stash-on-merge conflicts

## PHP Files Resolved
- Listeners/AssignFreeCreditsListener.php
- app/Actions/CreateUserAction.php
- app/Filament/Clusters/Passport/Pages/PassportDashboard.php
- app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource.php
- app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource/Pages/ListOauthAccessTokens.php
- app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource/Pages/ViewOauthAccessToken.php
- app/Filament/Clusters/Passport/Resources/OauthAuthCodeResource.php
- app/Filament/Clusters/Passport/Resources/OauthClientResource.php
- app/Filament/Clusters/Passport/Resources/OauthRefreshTokenResource.php
- app/Filament/Clusters/Passport/Resources/OauthRefreshTokenResource/Pages/ViewOauthRefreshToken.php
- app/Filament/Resources/OauthRefreshTokenResource/Pages/ViewOauthRefreshToken.php
- app/Filament/Resources/PersonalAccessTokenResource.php
- app/Filament/Widgets/Auth/BaseAuthWidget.php
- app/Filament/Widgets/EditUserWidget.php
- app/Filament/Widgets/LoginWidget.php
- app/Models/BaseUser.php
- app/Models/OauthAccessToken.php
- app/Models/OauthClient.php
- app/Models/OauthDeviceCode.php
- app/Models/OauthToken.php
- app/Providers/SocialiteServiceProvider.php
- app/Providers/Traits/HasPassportConfiguration.php
- database/factories/OauthAccessTokenFactory.php
- database/factories/OauthRefreshTokenFactory.php
- database/migrations/2020_01_01_000003_create_oauth_refresh_tokens_table.php
- lang/en/passport.php
- lang/en/passport_dashboard.php
- lang/it/oauth_access_token.php
- lang/it/oauth_auth_code.php
- lang/it/oauth_personal_access_client.php
- lang/it/oauth_refresh_token.php
- lang/it/passport.php
- lang/it/passport_dashboard.php
- lang/it/password.php
- lang/it/recent_logins.php
- tests/Feature/Actions/Socialite/LoginUserActionTest.php
- tests/Feature/Database/Migrations/UserMigrationSyntaxTest.php
- tests/Unit/Database/OauthFactoriesDefinitionTest.php
- tests/Unit/Models/AdditionalModelsTest.php
- tests/Unit/Models/PassportModelWrappersTest.php
- tests/Unit/Models/Policies/PoliciesTest.php

## Documentation Files Resolved
- docs/best-practices/nestedset-migration-best-practices.md
- docs/fixes/base-classes-corrections.md
- docs/nestedset-migration-best-practices.md
- docs/passport-integration.md
- docs/translation-city-field-refactor.md
- pest-test-report.md

## Config Files Resolved
- composer.json

## Translation Files Resolved
- lang/en/passport.php
- lang/en/passport_dashboard.php
- lang/it/oauth_access_token.php
- lang/it/oauth_auth_code.php
- lang/it/oauth_personal_access_client.php
- lang/it/oauth_refresh_token.php
- lang/it/passport.php
- lang/it/passport_dashboard.php
- lang/it/password.php
- lang/it/recent_logins.php

## Backlinks
- [Root conflict resolution report](../../../../docs/conflict-resolution-report.md)
