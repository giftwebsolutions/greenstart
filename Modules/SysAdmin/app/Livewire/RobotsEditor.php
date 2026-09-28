<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Livewire;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class RobotsEditor extends Component
{
    public string $content = '';

    public bool $exists = false;

    public ?string $modifiedAt = null;

    public int $bytes = 0;

    public function mount(): void
    {
        Gate::authorize('sysadmin.server_tools.manage');
        $this->loadFile();
    }

    public function save(): void
    {
        Gate::authorize('sysadmin.server_tools.manage');
        $validated = $this->validate([
            'content' => ['required', 'string', 'max:65535', function (string $attribute, mixed $value, $fail): void {
                if (str_contains((string) $value, "\0")) {
                    $fail('The robots.txt content contains an invalid null character.');
                }
            }],
        ]);

        $content = str_replace(["\r\n", "\r"], "\n", trim($validated['content']));
        File::replace($this->path(), $content."\n");
        $this->loadFile();
        $this->dispatch('toast', message: 'robots.txt saved.');
    }

    public function restoreDefault(): void
    {
        Gate::authorize('sysadmin.server_tools.manage');
        $this->content = $this->defaultContent();
        $this->resetValidation();
    }

    public function render()
    {
        Gate::authorize('sysadmin.server_tools.manage');

        return view('sysadmin::livewire.robots-editor', [
            'publicUrl' => url('/robots.txt'),
            'sitemapUrl' => url('/sitemap.xml'),
        ]);
    }

    private function loadFile(): void
    {
        $path = $this->path();
        $this->exists = File::exists($path);
        $this->content = $this->exists ? (string) File::get($path) : $this->defaultContent();
        $this->bytes = $this->exists ? (int) File::size($path) : 0;
        $this->modifiedAt = $this->exists ? date('d M Y, h:i A', File::lastModified($path)) : null;
    }

    private function defaultContent(): string
    {
        return "User-agent: *\nDisallow:\n\nSitemap: ".url('/sitemap.xml')."\n";
    }

    private function path(): string
    {
        return public_path('robots.txt');
    }
}
