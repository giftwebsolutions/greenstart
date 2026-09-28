<?php

namespace App\Livewire\Installer;

use App\Models\User;
use App\Support\InstallationState;
use App\Support\Installer\EnvironmentWriter;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Throwable;

class Wizard extends Component
{
    public int $step = 1;

    public string $dbHost = '127.0.0.1';

    public string $dbPort = '3306';

    public string $dbDatabase = '';

    public string $dbUsername = '';

    public string $dbPassword = '';

    public bool $databaseVerified = false;

    public string $appName = 'Product Catalog';

    public string $appUrl = 'http://localhost';

    public string $adminName = '';

    public string $adminEmail = '';

    public string $adminPassword = '';

    public string $adminPasswordConfirmation = '';

    public bool $completed = false;

    public string $failure = '';

    public function mount()
    {
        if (InstallationState::isInstalled()) {
            return $this->redirectRoute('sysadmin.login.form', navigate: false);
        }

        $this->dbHost = (string) config('database.connections.mysql.host', '127.0.0.1');
        $this->dbPort = (string) config('database.connections.mysql.port', '3306');
        $this->dbDatabase = (string) config('database.connections.mysql.database', '');
        $this->dbUsername = (string) config('database.connections.mysql.username', '');
        $this->appName = (string) config('app.name', 'Product Catalog');
        $this->appUrl = (string) config('app.url', url('/'));
    }

    public function continueFromRequirements(): void
    {
        if (! $this->requirementsPass()) {
            $this->addError('requirements', 'Resolve the failed server checks before continuing.');

            return;
        }

        $this->step = 2;
    }

    public function testDatabase(): void
    {
        $this->validate($this->databaseRules());
        $this->failure = '';
        $this->databaseVerified = false;

        try {
            $this->configureDatabase();
            DB::connection('mysql')->getPdo();
            $this->databaseVerified = true;
        } catch (Throwable $exception) {
            report($exception);
            $this->addError('database', 'Connection failed. Check the host, database name, username and password.');
        }
    }

    public function continueFromDatabase(): void
    {
        $this->testDatabase();
        if ($this->databaseVerified) {
            $this->step = 3;
        }
    }

    public function continueFromApplication(): void
    {
        $this->validate($this->applicationRules());
        $this->step = 4;
    }

    public function previousStep(): void
    {
        $this->step = max(1, $this->step - 1);
    }

    public function install(EnvironmentWriter $environment): void
    {
        $this->validate(array_merge($this->databaseRules(), $this->applicationRules()));
        $this->failure = '';

        try {
            $pending = json_encode([
                'started_at' => now()->toIso8601String(),
                'database' => trim($this->dbDatabase),
            ], JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);

            if (file_put_contents(InstallationState::pendingPath(), $pending, LOCK_EX) === false) {
                throw new \RuntimeException('Unable to write the installation progress file.');
            }

            $environment->write([
                'APP_NAME' => trim($this->appName),
                'APP_URL' => rtrim(trim($this->appUrl), '/'),
                'APP_ENV' => 'production',
                'APP_DEBUG' => 'false',
                'DB_CONNECTION' => 'mysql',
                'DB_HOST' => trim($this->dbHost),
                'DB_PORT' => trim($this->dbPort),
                'DB_DATABASE' => trim($this->dbDatabase),
                'DB_USERNAME' => trim($this->dbUsername),
                'DB_PASSWORD' => $this->dbPassword,
                'SESSION_DRIVER' => 'database',
                'CACHE_STORE' => 'database',
                'QUEUE_CONNECTION' => 'database',
            ]);

            if (! config('app.key')) {
                Artisan::call('key:generate', ['--force' => true]);
            }

            $this->configureDatabase();
            Artisan::call('migrate', ['--force' => true]);

            if (! is_link(public_path('storage'))) {
                if (file_exists(public_path('storage'))) {
                    throw new \RuntimeException('public/storage exists but is not a symbolic link.');
                }

                if (Artisan::call('storage:link') !== 0 || ! is_link(public_path('storage'))) {
                    throw new \RuntimeException('Unable to create the public storage link.');
                }
            }

            if (! Schema::hasTable('users')) {
                throw new \RuntimeException('The users table was not created.');
            }

            $admin = User::query()->updateOrCreate(
                ['email' => mb_strtolower(trim($this->adminEmail))],
                [
                    'name' => trim($this->adminName),
                    'password' => Hash::make($this->adminPassword),
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]
            );
            $admin->syncRoles(['super-admin']);

            $lock = json_encode([
                'installed_at' => now()->toIso8601String(),
                'app_url' => rtrim(trim($this->appUrl), '/'),
                'laravel' => app()->version(),
            ], JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);

            if (file_put_contents(InstallationState::lockPath(), $lock, LOCK_EX) === false) {
                throw new \RuntimeException('Unable to write the installation lock file.');
            }

            if (is_file(InstallationState::pendingPath())) {
                unlink(InstallationState::pendingPath());
            }

            Artisan::call('optimize:clear');
            $this->adminPassword = '';
            $this->adminPasswordConfirmation = '';
            $this->completed = true;
        } catch (Throwable $exception) {
            report($exception);
            $this->failure = 'Installation could not finish. Review storage/logs/laravel.log for the technical detail, then retry.';
        }
    }

    private function configureDatabase(): void
    {
        config([
            'database.default' => 'mysql',
            'database.connections.mysql.host' => trim($this->dbHost),
            'database.connections.mysql.port' => trim($this->dbPort),
            'database.connections.mysql.database' => trim($this->dbDatabase),
            'database.connections.mysql.username' => trim($this->dbUsername),
            'database.connections.mysql.password' => $this->dbPassword,
        ]);

        DB::purge('mysql');
        DB::reconnect('mysql');
    }

    private function databaseRules(): array
    {
        return [
            'dbHost' => ['required', 'string', 'max:255'],
            'dbPort' => ['required', 'integer', 'between:1,65535'],
            'dbDatabase' => ['required', 'string', 'max:64', 'regex:/^[A-Za-z0-9_$-]+$/'],
            'dbUsername' => ['required', 'string', 'max:128'],
            'dbPassword' => ['nullable', 'string', 'max:255'],
        ];
    }

    private function applicationRules(): array
    {
        return [
            'appName' => ['required', 'string', 'max:80'],
            'appUrl' => ['required', 'url:http,https', 'max:255'],
            'adminName' => ['required', 'string', 'max:100'],
            'adminEmail' => ['required', 'email:rfc', 'max:255'],
            'adminPassword' => ['required', 'string', 'min:10', 'same:adminPasswordConfirmation'],
            'adminPasswordConfirmation' => ['required', 'string'],
        ];
    }

    private function requirementsPass(): bool
    {
        return collect($this->requirements())->every(fn (array $requirement) => $requirement['passed']);
    }

    public function requirements(): array
    {
        $extensions = ['ctype', 'fileinfo', 'json', 'mbstring', 'openssl', 'pdo', 'tokenizer', 'xml'];
        $checks = [[
            'label' => 'PHP 8.3 or newer',
            'detail' => PHP_VERSION,
            'passed' => version_compare(PHP_VERSION, '8.3.0', '>='),
        ]];

        foreach ($extensions as $extension) {
            $checks[] = [
                'label' => "PHP {$extension} extension",
                'detail' => extension_loaded($extension) ? 'Available' : 'Missing',
                'passed' => extension_loaded($extension),
            ];
        }

        foreach ([storage_path() => 'Storage directory', base_path('bootstrap/cache') => 'Bootstrap cache', public_path() => 'Public directory', base_path() => 'Project directory (.env)'] as $path => $label) {
            $checks[] = [
                'label' => $label,
                'detail' => is_writable($path) ? 'Writable' : 'Not writable',
                'passed' => is_writable($path),
            ];
        }

        return $checks;
    }

    public function render()
    {
        return view('livewire.installer.wizard', ['requirements' => $this->requirements()]);
    }
}
