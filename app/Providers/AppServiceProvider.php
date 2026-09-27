<?php

namespace App\Providers;

use App\Livewire\Installer\Wizard as InstallerWizard;
use App\Support\InstallationState;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // A fresh installation cannot use database-backed cache or sessions.
        // The installer switches to the configured drivers after writing its lock.
        if (
            ! is_file(InstallationState::lockPath())
            && ! $this->app->runningInConsole()
            && request()->is('install', 'livewire/*')
        ) {
            config([
                'cache.default' => 'file',
                'session.driver' => 'file',
            ]);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::component('installer.wizard', InstallerWizard::class);
        // Each module owns and registers its own view namespace.
    }
}
