<?php

declare(strict_types=1);

// ⚠️ CRITICAL RULE: NEVER use ->label(), ->placeholder(), ->helperText()
// Translations are handled automatically by LangServiceProvider via 5-level keys:
// user::socialite.settings.form.{field}.{type}
// See: .windsurf/rules/no-filament-labels.mdc

namespace Modules\User\Filament\Pages;

use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Modules\User\Models\SocialProvider;
use Modules\Xot\Filament\Pages\XotBasePage;

/**
 * Socialite OAuth Provider Settings Page.
 *
 * Allows administrators to configure OAuth providers (Google, GitHub, etc.)
 * via Filament backoffice UI without editing .env files.
 *
 * Configuration is stored in: storage/app/private/socialite-config.php
 * This file is loaded by SocialiteServiceProvider at boot time.
 *
 * @see https://developers.google.com/identity/protocols/oauth2/web-server
 * @see laravel/Modules/User/docs/wiki/concepts/socialite-admin-configuration.md
 */
class SocialiteProviderSettingsPage extends XotBasePage
{
    // Navigation properties are inherited from XotBasePage, no need to redeclare

    /**
     * Form data array for each provider.
     *
     * @var array<string, array<string, mixed>>
     */
    public array $google = [];

    /**
     * @var array<string, array<string, mixed>>
     */
    public array $github = [];

    /**
     * @var array<string, array<string, mixed>>
     */
    public array $microsoft = [];

    /**
     * Mount the page and load current configuration.
     */
    public function mount(): void
    {
        $this->loadProviderConfigs();
    }

    /**
     * Load current configuration for all providers.
     */
    private function loadProviderConfigs(): void
    {
        $this->google = [
            'enabled' => config('services.google.enabled', false),
            'client_id' => config('services.google.client_id', ''),
            'client_secret' => $this->maskSecret(config('services.google.client_secret')),
            'scopes' => config('services.google.scopes', ['openid', 'email', 'profile']),
        ];

        $this->github = [
            'enabled' => config('services.github.enabled', false),
            'client_id' => config('services.github.client_id', ''),
            'client_secret' => $this->maskSecret(config('services.github.client_secret')),
            'scopes' => config('services.github.scopes', ['read:user', 'user:email']),
        ];

        $this->microsoft = [
            'enabled' => config('services.microsoft.enabled', false),
            'client_id' => config('services.microsoft.client_id', ''),
            'client_secret' => $this->maskSecret(config('services.microsoft.client_secret')),
            'scopes' => config('services.microsoft.scopes', ['User.Read', 'openid', 'email']),
        ];
    }

    /**
     * Define the form schema for provider configuration.
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Google OAuth')
                    ->description('Configura il login con Google. Crea credenziali su Google Cloud Console.')
                    ->icon('ui-google')
                    ->collapsible()
                    ->schema([
                        Toggle::make('google.enabled'),

                        TextInput::make('google.client_id')
                            ->placeholder('xxx.apps.googleusercontent.com')
                            ->visible(fn ($get) => $get('google.enabled')),

                        TextInput::make('google.client_secret')
                            ->password()
                            ->revealable()
                            ->placeholder('GOCSPX-xxx')
                            ->dehydrateStateUsing(fn ($state) => $this->isMasked($state)
                                ? config('services.google.client_secret')
                                : $state)
                            ->visible(fn ($get) => $get('google.enabled')),

                        TagsInput::make('google.scopes')
                            ->placeholder('openid, email, profile')
                            ->visible(fn ($get) => $get('google.enabled')),

                        TextInput::make('google.redirect')
                            ->default(fn () => route('socialite.oauth.callback', 'google'))
                            ->disabled()
                            ->copyable()
                            ->visible(fn ($get) => $get('google.enabled')),
                    ]),

                Section::make('GitHub OAuth')
                    ->description('Configura il login con GitHub. Crea OAuth App su GitHub Settings.')
                    ->icon('fab-github')
                    ->collapsible()
                    ->schema([
                        Toggle::make('github.enabled'),

                        TextInput::make('github.client_id')
                            ->placeholder('Iv23lixxx')
                            ->visible(fn ($get) => $get('github.enabled')),

                        TextInput::make('github.client_secret')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn ($state) => $this->isMasked($state)
                                ? config('services.github.client_secret')
                                : $state)
                            ->visible(fn ($get) => $get('github.enabled')),

                        TagsInput::make('github.scopes')
                            ->placeholder('read:user, user:email')
                            ->visible(fn ($get) => $get('github.enabled')),

                        TextInput::make('github.redirect')
                            ->default(fn () => route('socialite.oauth.callback', 'github'))
                            ->disabled()
                            ->copyable()
                            ->visible(fn ($get) => $get('github.enabled')),
                    ]),

                Section::make('Microsoft OAuth')
                    ->description('Configura il login con Microsoft/Azure AD.')
                    ->icon('ui-brands.microsoft')
                    ->collapsible()
                    ->schema([
                        Toggle::make('microsoft.enabled'),

                        TextInput::make('microsoft.client_id')
                            ->placeholder('xxx-xxx-xxx-xxx')
                            ->visible(fn ($get) => $get('microsoft.enabled')),

                        TextInput::make('microsoft.client_secret')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn ($state) => $this->isMasked($state)
                                ? config('services.microsoft.client_secret')
                                : $state)
                            ->visible(fn ($get) => $get('microsoft.enabled')),

                        TagsInput::make('microsoft.scopes')
                            ->placeholder('User.Read, openid, email')
                            ->visible(fn ($get) => $get('microsoft.enabled')),

                        TextInput::make('microsoft.redirect')
                            ->default(fn () => route('socialite.oauth.callback', 'microsoft'))
                            ->disabled()
                            ->copyable()
                            ->visible(fn ($get) => $get('microsoft.enabled')),
                    ]),
            ])
            ->statePath('data');
    }

    /**
     * Save the configuration to secure file.
     */
    public function save(): void
    {
        /** @var array<string, array<string, mixed>> $data */
        $data = $this->form->getState();

        // Build config array for each provider
        $config = [];

        if (isset($data['google'])) {
            $config['google'] = [
                'enabled' => $data['google']['enabled'] ?? false,
                'client_id' => $data['google']['client_id'] ?? '',
                'client_secret' => $this->resolveSecret(
                    $data['google']['client_secret'] ?? '',
                    config('services.google.client_secret')
                ),
                'redirect' => route('socialite.oauth.callback', 'google'),
                'scopes' => $data['google']['scopes'] ?? ['openid', 'email', 'profile'],
            ];
        }

        if (isset($data['github'])) {
            $config['github'] = [
                'enabled' => $data['github']['enabled'] ?? false,
                'client_id' => $data['github']['client_id'] ?? '',
                'client_secret' => $this->resolveSecret(
                    $data['github']['client_secret'] ?? '',
                    config('services.github.client_secret')
                ),
                'redirect' => route('socialite.oauth.callback', 'github'),
                'scopes' => $data['github']['scopes'] ?? ['read:user', 'user:email'],
            ];
        }

        if (isset($data['microsoft'])) {
            $config['microsoft'] = [
                'enabled' => $data['microsoft']['enabled'] ?? false,
                'client_id' => $data['microsoft']['client_id'] ?? '',
                'client_secret' => $this->resolveSecret(
                    $data['microsoft']['client_secret'] ?? '',
                    config('services.microsoft.client_secret')
                ),
                'redirect' => route('socialite.oauth.callback', 'microsoft'),
                'scopes' => $data['microsoft']['scopes'] ?? ['User.Read', 'openid', 'email'],
            ];
        }

        // Write to secure config file
        $this->writeSocialiteConfig($config);

        // Clear config cache
        Artisan::call('config:clear');

        // Update SocialProvider Sushi model active states
        $this->updateSocialProviderActiveStates($config);

        // Show success notification
        $this->notify('success', __('user::socialite.messages.config_saved'));
    }

    /**
     * Write configuration to secure PHP file.
     *
     * @param array<string, array<string, mixed>> $config
     */
    private function writeSocialiteConfig(array $config): void
    {
        $path = storage_path('app/private/socialite-config.php');

        // Ensure directory exists with secure permissions
        $dir = dirname($path);
        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0750, true);
        }

        // Generate PHP file content
        $content = "<?php\n\ndeclare(strict_types=1);\n\nreturn ".var_export($config, true).";\n";

        // Write file
        File::put($path, $content);

        // Set secure permissions (owner read/write, group read, others none)
        chmod($path, 0640);
    }

    /**
     * Update SocialProvider model active states.
     *
     * @param array<string, array<string, mixed>> $config
     */
    private function updateSocialProviderActiveStates(array $config): void
    {
        foreach ($config as $provider => $settings) {
            $active = $settings['enabled'] ?? false;

            // Update or create SocialProvider record
            SocialProvider::query()
                ->updateOrInsert(
                    ['name' => $provider],
                    ['active' => $active]
                );
        }
    }

    /**
     * Mask secret for display (show only last 4 chars).
     */
    private function maskSecret(?string $secret): string
    {
        if (empty($secret)) {
            return '';
        }

        $length = strlen($secret);
        if ($length <= 4) {
            return str_repeat('•', $length);
        }

        return str_repeat('•', $length - 4).substr($secret, -4);
    }

    /**
     * Check if value contains masked characters.
     */
    private function isMasked(string $value): bool
    {
        return str_contains($value, '•') || str_contains($value, '*');
    }

    /**
     * Resolve secret value - use new value or keep existing if masked.
     */
    private function resolveSecret(string $newValue, ?string $existingValue): string
    {
        if ($this->isMasked($newValue) && ! empty($existingValue)) {
            return $existingValue;
        }

        return $newValue;
    }
}
