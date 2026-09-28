<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Livewire\Settings;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\SysAdmin\Models\Settings;

class Workspace extends Component
{
    use WithFileUploads;

    public string $activeSection = 'site';

    /** @var array<string, mixed> */
    public array $values = [];

    public $siteLogoUpload = null;

    public $footerLogoUpload = null;

    public $faviconUpload = null;

    public $ogImageUpload = null;

    /** @var array<int, array<string, mixed>> */
    public array $customSettings = [];

    public string $customKey = '';

    public string $customValue = '';

    public string $customType = 'custom';

    public function mount(): void
    {
        Gate::authorize('sysadmin.settings.view');
        $stored = Settings::query()->pluck('value', 'key')->all();
        foreach ($this->fieldDefinitions() as $fields) {
            foreach ($fields as $key => $definition) {
                $fallback = $definition['default'] ?? '';
                if ($key === 'site_name' && ! isset($stored[$key]) && isset($stored['title'])) {
                    $fallback = $stored['title'];
                }
                $value = ($definition['sensitive'] ?? false) ? '' : ($stored[$key] ?? $fallback);
                $this->values[$key] = ($definition['input'] ?? 'text') === 'toggle'
                    ? filter_var($value, FILTER_VALIDATE_BOOL)
                    : (string) $value;
            }
        }
        foreach ($this->assetDefinitions() as $key => $asset) {
            $this->values[$key] = (string) ($stored[$key] ?? '');
        }

        $this->loadCustomSettings();
    }

    public function selectSection(string $section): void
    {
        if (array_key_exists($section, $this->sections())) {
            $this->activeSection = $section;
            $this->resetValidation();
        }
    }

    public function saveSection(string $section): void
    {
        Gate::authorize('sysadmin.settings.update');
        abort_unless(isset($this->fieldDefinitions()[$section]), 404);
        $definitions = $this->fieldDefinitions()[$section];
        $rules = [];

        foreach ($definitions as $key => $definition) {
            $rules['values.'.$key] = $this->rulesFor($definition);
        }

        foreach ($this->assetDefinitions() as $key => $asset) {
            if ($asset['section'] === $section) {
                $rules[$asset['property']] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'];
            }
        }

        $this->validate($rules, attributes: collect($definitions)->mapWithKeys(
            fn (array $definition, string $key) => ['values.'.$key => Str::lower($definition['label'])]
        )->all());

        foreach ($definitions as $key => $definition) {
            $value = $this->values[$key] ?? '';

            if (($definition['sensitive'] ?? false) && blank($value) && Settings::query()->where('key', $key)->exists()) {
                continue;
            }

            Settings::query()->updateOrCreate(['key' => $key], [
                'value' => ($definition['sensitive'] ?? false)
                    ? Crypt::encryptString((string) $value)
                    : (($definition['input'] ?? 'text') === 'toggle' ? ((bool) $value ? '1' : '0') : trim((string) $value)),
                'type' => $definition['group'],
            ]);
        }

        if ($section === 'site') {
            Settings::query()->updateOrCreate(['key' => 'title'], [
                'value' => trim((string) ($this->values['site_name'] ?? '')),
                'type' => 'core',
            ]);
        }

        foreach ($this->assetDefinitions() as $key => $asset) {
            if ($asset['section'] !== $section || ! $this->{$asset['property']}) {
                continue;
            }

            $oldPath = (string) Settings::query()->where('key', $key)->value('value');
            $extension = Str::lower($this->{$asset['property']}->getClientOriginalExtension());
            $path = $this->{$asset['property']}->storePubliclyAs(
                'settings',
                Str::slug($key).'-'.Str::lower(Str::random(10)).'.'.$extension,
                'public',
            );
            Settings::query()->updateOrCreate(['key' => $key], ['value' => $path, 'type' => 'theme']);
            $this->values[$key] = $path;
            $this->{$asset['property']} = null;

            if (Str::startsWith($oldPath, 'settings/')) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $this->flushSettingsCache();
        $this->dispatch('toast', message: $this->sections()[$section]['label'].' saved.');
    }

    public function removeAsset(string $key): void
    {
        Gate::authorize('sysadmin.settings.update');
        $asset = $this->assetDefinitions()[$key] ?? null;
        abort_unless($asset, 404);

        $path = (string) Settings::query()->where('key', $key)->value('value');
        if (Str::startsWith($path, 'settings/')) {
            Storage::disk('public')->delete($path);
        }
        Settings::query()->where('key', $key)->delete();
        $this->values[$key] = '';
        $this->{$asset['property']} = null;
        $this->flushSettingsCache();
        $this->dispatch('toast', message: $asset['label'].' removed.');
    }

    public function assetPreview(string $key): ?string
    {
        $asset = $this->assetDefinitions()[$key] ?? null;
        if (! $asset) {
            return null;
        }

        $upload = $this->{$asset['property']};
        if ($upload) {
            return $upload->temporaryUrl();
        }

        $path = (string) ($this->values[$key] ?? '');
        if ($path === '') {
            return null;
        }

        return Str::startsWith($path, ['http://', 'https://'])
            ? $path
            : Storage::disk('public')->url($path);
    }

    public function addCustomSetting(): void
    {
        Gate::authorize('sysadmin.settings.update');
        $data = $this->validate([
            'customKey' => ['required', 'alpha_dash:ascii', 'max:100', Rule::unique('settings', 'key')],
            'customValue' => ['nullable', 'string', 'max:65535'],
            'customType' => ['required', 'alpha_dash:ascii', 'max:100'],
        ], attributes: [
            'customKey' => 'setting key',
            'customValue' => 'setting value',
            'customType' => 'setting group',
        ]);

        Settings::query()->create([
            'key' => Str::lower($data['customKey']),
            'value' => $data['customValue'],
            'type' => Str::lower($data['customType']),
        ]);

        $this->reset('customKey', 'customValue');
        $this->customType = 'custom';
        $this->loadCustomSettings();
        $this->flushSettingsCache();
        $this->dispatch('toast', message: 'Custom setting added.');
    }

    public function saveCustomSettings(): void
    {
        Gate::authorize('sysadmin.settings.update');
        $this->validate([
            'customSettings' => ['array'],
            'customSettings.*.value' => ['nullable', 'string', 'max:65535'],
            'customSettings.*.type' => ['required', 'alpha_dash:ascii', 'max:100'],
        ]);

        foreach ($this->customSettings as $setting) {
            Settings::query()->whereKey((int) $setting['id'])->update([
                'value' => (string) ($setting['value'] ?? ''),
                'type' => Str::lower((string) $setting['type']),
            ]);
        }

        $this->flushSettingsCache();
        $this->dispatch('toast', message: 'Custom settings saved.');
    }

    public function deleteCustomSetting(int $id): void
    {
        Gate::authorize('sysadmin.settings.update');
        Settings::query()->whereKey($id)->whereNotIn('key', $this->knownKeys())->delete();
        $this->loadCustomSettings();
        $this->flushSettingsCache();
        $this->dispatch('toast', message: 'Custom setting removed.');
    }

    public function render()
    {
        Gate::authorize('sysadmin.settings.view');

        return view('sysadmin::livewire.settings.workspace', [
            'sections' => $this->sections(),
            'fields' => $this->fieldDefinitions()[$this->activeSection] ?? [],
            'assets' => collect($this->assetDefinitions())->where('section', $this->activeSection),
        ]);
    }

    /** @return array<string, array<string, mixed>> */
    private function sections(): array
    {
        return [
            'site' => ['label' => 'Site details', 'help' => 'Brand identity and business contact details.', 'icon' => 'home'],
            'branding' => ['label' => 'Branding', 'help' => 'Logos, favicon and visual assets.', 'icon' => 'image'],
            'social' => ['label' => 'Social media', 'help' => 'Public social profile destinations.', 'icon' => 'users'],
            'theme' => ['label' => 'Theme', 'help' => 'Storefront colors, radius and presentation.', 'icon' => 'layers'],
            'seo' => ['label' => 'SEO & sharing', 'help' => 'Search defaults, robots and social cards.', 'icon' => 'search'],
            'analytics' => ['label' => 'Analytics & code', 'help' => 'Tracking IDs, verification tags and injected code.', 'icon' => 'code'],
            'catalog' => ['label' => 'Catalog', 'help' => 'Product listing and customer action defaults.', 'icon' => 'box'],
            'email' => ['label' => 'Email', 'help' => 'Public sender and SMTP connection.', 'icon' => 'message'],
            'advanced' => ['label' => 'Advanced', 'help' => 'Custom key/value settings for integrations.', 'icon' => 'settings'],
        ];
    }

    /** @return array<string, array<string, array<string, mixed>>> */
    private function fieldDefinitions(): array
    {
        return [
            'site' => [
                'site_name' => ['label' => 'Site name', 'input' => 'text', 'required' => true, 'group' => 'core', 'default' => config('app.name', 'Products'), 'help' => 'Used in page titles, header alt text and structured data.'],
                'tagline' => ['label' => 'Tagline', 'input' => 'text', 'group' => 'core', 'default' => '', 'help' => 'Short promise displayed alongside the brand.'],
                'email' => ['label' => 'Public email', 'input' => 'email', 'group' => 'system', 'default' => ''],
                'mobile' => ['label' => 'Primary phone', 'input' => 'tel', 'group' => 'system', 'default' => ''],
                'mobile-1' => ['label' => 'Secondary phone', 'input' => 'tel', 'group' => 'system', 'default' => ''],
                'whatsapp' => ['label' => 'WhatsApp number', 'input' => 'tel', 'group' => 'system', 'default' => '', 'help' => 'Include country code; formatting characters are allowed.'],
                'address' => ['label' => 'Business address', 'input' => 'textarea', 'group' => 'system', 'default' => ''],
                'business_hours' => ['label' => 'Business hours', 'input' => 'text', 'group' => 'system', 'default' => 'Mon–Sat, 9:00 AM–6:00 PM'],
            ],
            'branding' => [],
            'social' => [
                'facebook' => ['label' => 'Facebook URL', 'input' => 'url', 'group' => 'social-media', 'default' => ''],
                'instagram' => ['label' => 'Instagram URL', 'input' => 'url', 'group' => 'social-media', 'default' => ''],
                'youtube' => ['label' => 'YouTube URL', 'input' => 'url', 'group' => 'social-media', 'default' => ''],
                'x_twitter' => ['label' => 'X / Twitter URL', 'input' => 'url', 'group' => 'social-media', 'default' => ''],
                'linkedin' => ['label' => 'LinkedIn URL', 'input' => 'url', 'group' => 'social-media', 'default' => ''],
                'pinterest' => ['label' => 'Pinterest URL', 'input' => 'url', 'group' => 'social-media', 'default' => ''],
            ],
            'theme' => [
                'theme_primary_color' => ['label' => 'Primary color', 'input' => 'color', 'group' => 'theme', 'default' => '#05a9a6'],
                'theme_primary_dark' => ['label' => 'Primary dark', 'input' => 'color', 'group' => 'theme', 'default' => '#087f82'],
                'theme_accent_color' => ['label' => 'Accent color', 'input' => 'color', 'group' => 'theme', 'default' => '#36a852'],
                'theme_text_color' => ['label' => 'Text color', 'input' => 'color', 'group' => 'theme', 'default' => '#11252d'],
                'theme_radius' => ['label' => 'Corner radius', 'input' => 'select', 'group' => 'theme', 'default' => '8px', 'options' => ['4px' => 'Compact · 4px', '8px' => 'Balanced · 8px', '12px' => 'Soft · 12px', '16px' => 'Rounded · 16px']],
            ],
            'seo' => [
                'meta_title' => ['label' => 'Default meta title', 'input' => 'text', 'group' => 'seo', 'default' => '', 'help' => 'Leave empty to use the site name.'],
                'meta_description' => ['label' => 'Default meta description', 'input' => 'textarea', 'group' => 'seo', 'default' => ''],
                'meta_keywords' => ['label' => 'Default keywords', 'input' => 'textarea', 'group' => 'seo', 'default' => ''],
                'meta_author' => ['label' => 'Content author', 'input' => 'text', 'group' => 'seo', 'default' => ''],
                'robots' => ['label' => 'Robots directive', 'input' => 'select', 'group' => 'seo', 'default' => 'index,follow', 'options' => ['index,follow' => 'Index and follow', 'noindex,follow' => 'Do not index, follow links', 'noindex,nofollow' => 'Private: no index or follow']],
            ],
            'analytics' => [
                'google_analytics_id' => ['label' => 'Google Analytics / Ads ID', 'input' => 'text', 'group' => 'analytics', 'default' => '', 'help' => 'Examples: G-XXXXXXXXXX, AW-123456789 or UA-123456-1.', 'rules' => ['regex:/^(G-[A-Z0-9]+|AW-[0-9]+|UA-[0-9]+-[0-9]+)$/i']],
                'google_tag_manager_id' => ['label' => 'Google Tag Manager ID', 'input' => 'text', 'group' => 'analytics', 'default' => '', 'help' => 'Example: GTM-XXXXXXX.', 'rules' => ['regex:/^GTM-[A-Z0-9]+$/i']],
                'meta_pixel_id' => ['label' => 'Meta Pixel ID', 'input' => 'text', 'group' => 'analytics', 'default' => '', 'help' => 'The numeric Pixel ID from Meta Events Manager.', 'rules' => ['regex:/^[0-9]{5,30}$/']],
                'facebook_app_id' => ['label' => 'Facebook App ID', 'input' => 'text', 'group' => 'analytics', 'default' => '', 'help' => 'Adds the fb:app_id Open Graph meta tag.', 'rules' => ['regex:/^[0-9]{5,30}$/']],
                'custom_head_code' => ['label' => 'Custom header code', 'input' => 'code', 'group' => 'analytics', 'default' => '', 'help' => 'Rendered before </head>. Use for verification meta tags or trusted third-party scripts.'],
                'custom_body_start_code' => ['label' => 'Code after opening body', 'input' => 'code', 'group' => 'analytics', 'default' => '', 'help' => 'Rendered immediately after <body>, commonly used by tag managers.'],
                'custom_body_end_code' => ['label' => 'Code before closing body', 'input' => 'code', 'group' => 'analytics', 'default' => '', 'help' => 'Rendered before </body> for trusted widgets or tracking scripts.'],
            ],
            'catalog' => [
                'products_per_page' => ['label' => 'Products per page', 'input' => 'number', 'group' => 'catalog', 'default' => '12'],
                'currency_code' => ['label' => 'Currency code', 'input' => 'text', 'group' => 'catalog', 'default' => 'INR'],
                'currency_symbol' => ['label' => 'Currency symbol', 'input' => 'text', 'group' => 'catalog', 'default' => '₹'],
                'show_product_prices' => ['label' => 'Show product prices', 'input' => 'toggle', 'group' => 'catalog', 'default' => true],
                'enable_enquiries' => ['label' => 'Enable enquiry actions', 'input' => 'toggle', 'group' => 'catalog', 'default' => true],
                'enable_whatsapp' => ['label' => 'Enable WhatsApp actions', 'input' => 'toggle', 'group' => 'catalog', 'default' => true],
            ],
            'email' => [
                'mail_from_name' => ['label' => 'Sender name', 'input' => 'text', 'group' => 'smtp', 'default' => ''],
                'mail_from_address' => ['label' => 'Sender email', 'input' => 'email', 'group' => 'smtp', 'default' => ''],
                'mail_mailer' => ['label' => 'Mailer', 'input' => 'select', 'group' => 'smtp', 'default' => 'smtp', 'options' => ['smtp' => 'SMTP', 'sendmail' => 'Sendmail', 'log' => 'Log only']],
                'mail_host' => ['label' => 'SMTP host', 'input' => 'text', 'group' => 'smtp', 'default' => ''],
                'mail_port' => ['label' => 'SMTP port', 'input' => 'number', 'group' => 'smtp', 'default' => '587'],
                'mail_username' => ['label' => 'SMTP username', 'input' => 'text', 'group' => 'smtp', 'default' => ''],
                'mail_password' => ['label' => 'SMTP password', 'input' => 'password', 'group' => 'smtp', 'default' => '', 'sensitive' => true, 'help' => 'Encrypted at rest. Leave blank to keep the saved password.'],
                'mail_encryption' => ['label' => 'Encryption', 'input' => 'select', 'group' => 'smtp', 'default' => 'tls', 'options' => ['tls' => 'TLS', 'ssl' => 'SSL', 'none' => 'None']],
            ],
            'advanced' => [],
        ];
    }

    /** @return array<string, array<string, string>> */
    private function assetDefinitions(): array
    {
        return [
            'site_logo' => ['label' => 'Header logo', 'section' => 'branding', 'property' => 'siteLogoUpload', 'help' => 'Recommended transparent PNG or WebP.'],
            'footer_logo' => ['label' => 'Footer logo', 'section' => 'branding', 'property' => 'footerLogoUpload', 'help' => 'Falls back to the header logo.'],
            'favicon' => ['label' => 'Favicon', 'section' => 'branding', 'property' => 'faviconUpload', 'help' => 'Square image, at least 64×64.'],
            'og_image' => ['label' => 'Social sharing image', 'section' => 'seo', 'property' => 'ogImageUpload', 'help' => 'Recommended 1200×630 image.'],
        ];
    }

    private function rulesFor(array $definition): array
    {
        $rules = [$definition['required'] ?? false ? 'required' : 'nullable'];
        $input = $definition['input'] ?? 'text';

        $rules = match ($input) {
            'email' => [...$rules, 'email:rfc', 'max:255'],
            'url' => [...$rules, 'url:http,https', 'max:2048'],
            'number' => [...$rules, 'integer', 'min:0', 'max:65535'],
            'toggle' => ['boolean'],
            'color' => [...$rules, 'regex:/^#[0-9a-fA-F]{6}$/'],
            'select' => [...$rules, Rule::in(array_keys($definition['options']))],
            'textarea', 'code' => [...$rules, 'string', 'max:65535'],
            default => [...$rules, 'string', 'max:255'],
        };

        return [...$rules, ...($definition['rules'] ?? [])];
    }

    private function loadCustomSettings(): void
    {
        $this->customSettings = Settings::query()
            ->whereNotIn('key', $this->knownKeys())
            ->orderBy('type')->orderBy('key')
            ->get(['id', 'key', 'value', 'type'])
            ->map(fn (Settings $setting): array => [
                'id' => $setting->id,
                'key' => $setting->key,
                'value' => (string) $setting->value,
                'type' => (string) $setting->type,
            ])->all();
    }

    /** @return array<int, string> */
    private function knownKeys(): array
    {
        return collect($this->fieldDefinitions())->flatMap(fn ($fields) => array_keys($fields))
            ->merge(array_keys($this->assetDefinitions()))
            ->push('title')
            ->unique()->values()->all();
    }

    private function flushSettingsCache(): void
    {
        Cache::forget(Settings::$cache_key);
    }
}
