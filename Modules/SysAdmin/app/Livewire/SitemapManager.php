<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Livewire;

use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\SysAdmin\Services\SitemapService;
use Throwable;

class SitemapManager extends Component
{
    public string $result = '';

    public string $message = '';

    public function mount(): void
    {
        Gate::authorize('sysadmin.server_tools.manage');
    }

    public function generate(SitemapService $sitemaps): void
    {
        Gate::authorize('sysadmin.server_tools.manage');

        try {
            $result = $sitemaps->generate();
            $this->result = 'success';
            $this->message = number_format($result['url_count']).' URLs written to sitemap.xml.';
            $this->dispatch('toast', message: 'Sitemap generated successfully.');
        } catch (Throwable $exception) {
            report($exception);
            $this->result = 'error';
            $this->message = 'The sitemap could not be generated. Check the application log and directory health, then try again.';
            $this->dispatch('toast', message: 'Sitemap generation failed.');
        }
    }

    public function render(SitemapService $sitemaps)
    {
        Gate::authorize('sysadmin.server_tools.manage');

        return view('sysadmin::livewire.sitemap-manager', [
            'status' => $sitemaps->status(),
        ]);
    }
}
