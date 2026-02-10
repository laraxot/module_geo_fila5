<?php

declare(strict_types=1);

namespace Modules\User\Providers;

<<<<<<< HEAD
// use SocialiteProviders\Manager\ServiceProvider as BaseSocialiteServiceProvider;
use Illuminate\Support\ServiceProvider;

class SocialiteServiceProvider extends ServiceProvider
{
    // Temporarily disabled until SocialiteProviders package is installed

    /**
     * Check if provider is deferred.
     */
    public function isDeferred(): bool
    {
        return false;
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        // Register services when SocialiteProviders package is available
    }
=======
use SocialiteProviders\Manager\ServiceProvider as BaseSocialiteServiceProvider;

class SocialiteServiceProvider extends BaseSocialiteServiceProvider
{
>>>>>>> ac0ea089 (.)
}
