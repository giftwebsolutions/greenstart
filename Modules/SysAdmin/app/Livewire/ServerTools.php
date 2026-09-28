<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Livewire;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Throwable;

class ServerTools extends Component
{
    public ?string $lastAction = null;

    public string $output = '';

    public string $result = '';

    public function mount(): void
    {
        Gate::authorize('sysadmin.server_tools.manage');
    }

    public function runCommand(string $action): void
    {
        Gate::authorize('sysadmin.server_tools.manage');
        $tool = $this->commands()[$action] ?? null;
        abort_unless($tool, 404);

        try {
            $exitCode = Artisan::call($tool['command']);
            $this->lastAction = $action;
            $this->output = trim(Artisan::output());
            $this->result = $exitCode === 0 ? 'success' : 'error';

            $message = $exitCode === 0
                ? $tool['success']
                : $tool['label'].' finished with exit code '.$exitCode.'.';
            $this->dispatch('toast', message: $message);
        } catch (Throwable $exception) {
            report($exception);
            $this->lastAction = $action;
            $this->output = $exception->getMessage();
            $this->result = 'error';
            $this->dispatch('toast', message: $tool['label'].' could not be completed.');
        }
    }

    public function prepareDirectories(): void
    {
        Gate::authorize('sysadmin.server_tools.manage');

        try {
            foreach (array_keys($this->directoryDefinitions()) as $path) {
                File::ensureDirectoryExists($path, 0775, true);
            }

            $this->lastAction = 'prepare-directories';
            $this->result = 'success';
            $this->output = 'Required application directories are available.';
            $this->dispatch('toast', message: 'Application directories prepared.');
        } catch (Throwable $exception) {
            report($exception);
            $this->lastAction = 'prepare-directories';
            $this->result = 'error';
            $this->output = $exception->getMessage();
            $this->dispatch('toast', message: 'One or more directories could not be prepared.');
        }
    }

    public function render()
    {
        Gate::authorize('sysadmin.server_tools.manage');

        return view('sysadmin::livewire.server-tools', [
            'commands' => $this->commands(),
            'directories' => collect($this->directoryDefinitions())->map(fn (string $label, string $path) => [
                'label' => $label,
                'path' => $path,
                'exists' => File::isDirectory($path),
                'writable' => File::isDirectory($path) && is_writable($path),
            ])->values(),
            'environment' => [
                ['label' => 'Laravel', 'value' => app()->version()],
                ['label' => 'PHP', 'value' => PHP_VERSION],
                ['label' => 'Environment', 'value' => app()->environment()],
                ['label' => 'Debug mode', 'value' => config('app.debug') ? 'Enabled' : 'Disabled'],
                ['label' => 'Cache store', 'value' => (string) config('cache.default')],
                ['label' => 'Queue', 'value' => (string) config('queue.default')],
            ],
        ]);
    }

    /** @return array<string, array{label: string, description: string, command: string, success: string, tone: string}> */
    private function commands(): array
    {
        return [
            'cache-clear' => [
                'label' => 'Clear application cache',
                'description' => 'Remove cached values created by the application.',
                'command' => 'cache:clear',
                'success' => 'Application cache cleared.',
                'tone' => 'primary',
            ],
            'optimize-clear' => [
                'label' => 'Clear all optimizations',
                'description' => 'Clear cached configuration, routes, events and compiled views.',
                'command' => 'optimize:clear',
                'success' => 'Application optimizations cleared.',
                'tone' => 'primary',
            ],
            'optimize' => [
                'label' => 'Optimize application',
                'description' => 'Cache framework metadata for production performance.',
                'command' => 'optimize',
                'success' => 'Application optimized.',
                'tone' => 'success',
            ],
            'config-clear' => [
                'label' => 'Clear configuration',
                'description' => 'Reload configuration values from their source files.',
                'command' => 'config:clear',
                'success' => 'Configuration cache cleared.',
                'tone' => 'neutral',
            ],
            'route-clear' => [
                'label' => 'Clear route cache',
                'description' => 'Discard cached route definitions.',
                'command' => 'route:clear',
                'success' => 'Route cache cleared.',
                'tone' => 'neutral',
            ],
            'view-clear' => [
                'label' => 'Clear compiled views',
                'description' => 'Recompile Blade views on their next request.',
                'command' => 'view:clear',
                'success' => 'Compiled views cleared.',
                'tone' => 'neutral',
            ],
            'event-clear' => [
                'label' => 'Clear event cache',
                'description' => 'Discard cached event and listener discovery.',
                'command' => 'event:clear',
                'success' => 'Event cache cleared.',
                'tone' => 'neutral',
            ],
        ];
    }

    /** @return array<string, string> */
    private function directoryDefinitions(): array
    {
        return [
            storage_path('framework/cache/data') => 'Framework cache',
            storage_path('framework/sessions') => 'Sessions',
            storage_path('framework/views') => 'Compiled views',
            storage_path('logs') => 'Application logs',
            base_path('bootstrap/cache') => 'Bootstrap cache',
            public_path('uploads') => 'Public uploads',
        ];
    }
}
