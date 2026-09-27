<div class="grid gap-5">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <p class="text-xs font-bold uppercase tracking-[.12em] text-primary">Configuration</p>
            <h1 class="mt-1 text-[22px] font-bold tracking-tight text-ink">Site settings</h1>
            <p class="mt-1 text-[13px] text-ink-muted">Manage storefront identity, contact details, social profiles, theme, SEO and catalog behavior.</p>
        </div>
        <a href="{{ url('/') }}" target="_blank" rel="noopener" class="btn">{!! \Modules\SysAdmin\Support\Icon::get('eye', 'h-4 w-4') !!} Preview storefront</a>
    </div>

    <div class="grid items-start gap-5 lg:grid-cols-[280px_minmax(0,1fr)]">
        <aside class="overflow-hidden rounded-xl border border-hairline bg-white shadow-sm lg:sticky lg:top-24">
            <div class="border-b border-hairline p-4"><h2 class="text-[13px] font-bold text-ink">Settings groups</h2><p class="mt-1 text-[11px] text-ink-muted">Changes save one group at a time.</p></div>
            <nav class="grid gap-1 p-2" aria-label="Settings sections">
                @foreach($sections as $sectionKey => $section)
                    <button type="button" wire:click="selectSection('{{ $sectionKey }}')" class="flex items-center gap-3 rounded-lg px-3 py-3 text-left transition {{ $activeSection === $sectionKey ? 'bg-primary-50 text-primary-600' : 'text-ink-soft hover:bg-[#fafbfc] hover:text-ink' }}">
                        <span class="grid size-8 shrink-0 place-items-center rounded-lg {{ $activeSection === $sectionKey ? 'bg-white text-primary shadow-sm' : 'bg-slate-100 text-ink-muted' }}">{!! \Modules\SysAdmin\Support\Icon::get($section['icon'], 'h-4 w-4') !!}</span>
                        <span class="min-w-0"><strong class="block text-[12.5px]">{{ $section['label'] }}</strong><small class="mt-0.5 block truncate text-[10px] font-normal text-ink-muted">{{ $section['help'] }}</small></span>
                    </button>
                @endforeach
            </nav>
        </aside>

        <main class="min-w-0">
            @if($activeSection === 'advanced')
                <div class="grid gap-5">
                    <x-sysadmin::card>
                        <div class="border-b border-hairline px-5 py-4"><h2 class="text-base font-bold text-ink">Add custom setting</h2><p class="mt-1 text-xs text-ink-muted">Use custom keys for integrations or application-specific configuration.</p></div>
                        <form wire:submit="addCustomSetting" class="grid gap-4 p-5 md:grid-cols-12 md:items-end">
                            <x-sysadmin::input label="Key" name="customKey" wire:model="customKey" placeholder="integration_api_url" required class="font-mono md:col-span-4" />
                            <x-sysadmin::input label="Value" name="customValue" wire:model="customValue" class="md:col-span-5" />
                            <x-sysadmin::input label="Group" name="customType" wire:model="customType" class="font-mono md:col-span-2" />
                            <x-sysadmin::btn type="submit" variant="primary" class="md:col-span-1">Add</x-sysadmin::btn>
                        </form>
                    </x-sysadmin::card>

                    <x-sysadmin::card>
                        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-hairline px-5 py-4"><div><h2 class="text-base font-bold text-ink">Custom settings</h2><p class="mt-1 text-xs text-ink-muted">Core settings are protected and managed in their dedicated sections.</p></div><span class="rounded-full bg-slate-100 px-3 py-1 text-[11px] font-semibold text-ink-muted">{{ count($customSettings) }} custom</span></div>
                        @if($customSettings === [])
                            <div class="px-5 py-12 text-center"><p class="text-[13px] font-semibold text-ink">No custom settings</p><p class="mt-1 text-xs text-ink-muted">Add a key above when an integration needs extra configuration.</p></div>
                        @else
                            <form wire:submit="saveCustomSettings">
                                <div class="divide-y divide-hairline">
                                    @foreach($customSettings as $index => $setting)
                                        <div wire:key="custom-setting-{{ $setting['id'] }}" class="grid gap-3 px-5 py-4 md:grid-cols-[220px_minmax(0,1fr)_160px_auto] md:items-end">
                                            <div><label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wide text-ink-muted">Key</label><code class="block min-h-11 rounded-xl bg-slate-100 px-3 py-3 text-[12px] text-ink">{{ $setting['key'] }}</code></div>
                                            <x-sysadmin::input label="Value" name="customSettings.{{ $index }}.value" wire:model="customSettings.{{ $index }}.value" />
                                            <x-sysadmin::input label="Group" name="customSettings.{{ $index }}.type" wire:model="customSettings.{{ $index }}.type" class="font-mono" />
                                            <button type="button" wire:click="deleteCustomSetting({{ $setting['id'] }})" wire:confirm="Delete this custom setting?" class="grid size-11 place-items-center rounded-xl border border-red-100 text-red-600 hover:bg-red-50" aria-label="Delete setting">{!! \Modules\SysAdmin\Support\Icon::get('trash', 'h-4 w-4') !!}</button>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="flex justify-end border-t border-hairline bg-[#fafbfc] px-5 py-4"><x-sysadmin::btn type="submit" variant="primary">Save custom settings</x-sysadmin::btn></div>
                            </form>
                        @endif
                    </x-sysadmin::card>
                </div>
            @else
                <x-sysadmin::card>
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-hairline px-5 py-4">
                        <div><h2 class="text-base font-bold text-ink">{{ $sections[$activeSection]['label'] }}</h2><p class="mt-1 text-xs text-ink-muted">{{ $sections[$activeSection]['help'] }}</p></div>
                        <span class="rounded-full bg-primary-50 px-3 py-1.5 text-[10.5px] font-bold uppercase tracking-wide text-primary">{{ $activeSection }}</span>
                    </div>

                    @if($activeSection === 'branding')
                        <div class="grid gap-4 p-5 md:grid-cols-2">
                            @foreach($assets as $assetKey => $asset)
                                <div class="rounded-xl border border-hairline p-4">
                                    <div class="flex items-start justify-between gap-3"><div><label class="text-[12.5px] font-bold text-ink">{{ $asset['label'] }}</label><p class="mt-1 text-[10.5px] text-ink-muted">{{ $asset['help'] }}</p></div>@if($this->assetPreview($assetKey))<button type="button" wire:click="removeAsset('{{ $assetKey }}')" wire:confirm="Remove {{ Str::lower($asset['label']) }}?" class="text-[10.5px] font-semibold text-red-600">Remove</button>@endif</div>
                                    <div class="mt-3 grid aspect-[3/1] place-items-center overflow-hidden rounded-lg border border-dashed border-hairline-strong bg-[#fafbfc]">@if($this->assetPreview($assetKey))<img src="{{ $this->assetPreview($assetKey) }}" class="max-h-full max-w-full object-contain p-3" alt="{{ $asset['label'] }} preview">@else<span class="text-xs text-ink-muted">No image uploaded</span>@endif</div>
                                    <input type="file" wire:model="{{ $asset['property'] }}" accept="image/jpeg,image/png,image/webp" class="mt-3 block w-full rounded-xl border border-hairline-strong bg-white text-xs file:mr-3 file:border-0 file:bg-primary-50 file:px-3 file:py-3 file:font-semibold file:text-primary">
                                    @error($asset['property'])<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>
                            @endforeach
                        </div>
                    @else
                        <form wire:submit="saveSection('{{ $activeSection }}')">
                            @if($activeSection === 'analytics')
                                <div class="mx-5 mt-5 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-[12px] text-amber-900"><strong class="block">Only add code from services you trust.</strong><span class="mt-0.5 block text-amber-800">Custom code runs on every storefront page. Prefer the validated ID fields when Google or Meta tracking is all you need.</span></div>
                            @endif
                            <div class="grid gap-5 p-5 md:grid-cols-2">
                                @foreach($fields as $key => $field)
                                    @php
                                        $errorKey = 'values.'.$key;
                                    @endphp
                                    @if($field['input'] === 'toggle')
                                        <label class="flex cursor-pointer items-center justify-between gap-4 rounded-xl border border-hairline p-4"><span><strong class="block text-[13px] text-ink">{{ $field['label'] }}</strong>@if($field['help'] ?? null)<small class="mt-0.5 block text-[11px] text-ink-muted">{{ $field['help'] }}</small>@endif</span><input type="checkbox" wire:model="values.{{ $key }}" class="peer sr-only"><span class="relative h-6 w-11 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:size-4 after:rounded-full after:bg-white after:transition peer-checked:after:translate-x-5"></span></label>
                                    @elseif($field['input'] === 'select')
                                        <x-sysadmin::select :label="$field['label']" :name="$errorKey" wire:model="values.{{ $key }}" :required="$field['required'] ?? false">@foreach($field['options'] as $optionValue => $optionLabel)<option value="{{ $optionValue }}">{{ $optionLabel }}</option>@endforeach</x-sysadmin::select>
                                    @elseif(in_array($field['input'], ['textarea', 'code'], true))
                                        <div class="md:col-span-2"><label class="mb-1.5 block text-[12.5px] font-bold text-ink">{{ $field['label'] }}</label><textarea wire:model="values.{{ $key }}" rows="{{ $field['input'] === 'code' ? 7 : 4 }}" spellcheck="{{ $field['input'] === 'code' ? 'false' : 'true' }}" class="w-full rounded-xl border px-3 py-2.5 text-[13px] focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-50 {{ $field['input'] === 'code' ? 'font-mono leading-5' : '' }} {{ $errors->has($errorKey) ? 'border-red-500' : 'border-hairline-strong' }}"></textarea>@if($field['help'] ?? null)<p class="mt-1 text-[11px] text-ink-muted">{{ $field['help'] }}</p>@endif @error($errorKey)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
                                    @elseif($field['input'] === 'color')
                                        <div><label class="mb-1.5 block text-[12.5px] font-bold text-ink">{{ $field['label'] }}</label><div class="flex min-h-11 items-center gap-3 rounded-xl border border-hairline-strong bg-white px-3"><input type="color" wire:model.live="values.{{ $key }}" class="size-7 cursor-pointer rounded border-0 bg-transparent p-0"><code class="text-xs text-ink-soft">{{ $values[$key] }}</code></div>@error($errorKey)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
                                    @else
                                        <x-sysadmin::input :label="$field['label']" :name="$errorKey" :type="$field['input']" wire:model="values.{{ $key }}" :required="$field['required'] ?? false" :hint="$field['help'] ?? null" />
                                    @endif
                                @endforeach

                                @if($activeSection === 'seo')
                                    @foreach($assets as $assetKey => $asset)
                                        <div class="md:col-span-2 rounded-xl border border-hairline p-4"><div class="flex items-start justify-between"><div><label class="text-[12.5px] font-bold">{{ $asset['label'] }}</label><p class="mt-1 text-[10.5px] text-ink-muted">{{ $asset['help'] }}</p></div>@if($this->assetPreview($assetKey))<button type="button" wire:click="removeAsset('{{ $assetKey }}')" class="text-xs font-semibold text-red-600">Remove</button>@endif</div>@if($this->assetPreview($assetKey))<img src="{{ $this->assetPreview($assetKey) }}" class="mt-3 aspect-[1200/630] w-56 rounded-lg border border-hairline object-cover" alt="">@endif<input type="file" wire:model="{{ $asset['property'] }}" accept="image/jpeg,image/png,image/webp" class="mt-3 block w-full rounded-xl border border-hairline-strong text-xs file:mr-3 file:border-0 file:bg-primary-50 file:px-3 file:py-3 file:font-semibold file:text-primary"></div>
                                    @endforeach
                                @endif

                                @if($activeSection === 'theme')
                                    @php
                                        $primary = preg_match('/^#[0-9a-fA-F]{6}$/', $values['theme_primary_color'] ?? '') ? $values['theme_primary_color'] : '#05a9a6';
                                        $accent = preg_match('/^#[0-9a-fA-F]{6}$/', $values['theme_accent_color'] ?? '') ? $values['theme_accent_color'] : '#36a852';
                                        $radius = in_array($values['theme_radius'] ?? '', ['4px','8px','12px','16px'], true) ? $values['theme_radius'] : '8px';
                                    @endphp
                                    <div class="md:col-span-2 rounded-xl border border-hairline bg-[#fafbfc] p-4"><p class="text-[11px] font-bold uppercase tracking-wide text-ink-muted">Live palette preview</p><div class="mt-3 overflow-hidden border border-hairline bg-white shadow-sm" style="border-radius: {{ $radius }}"><div class="flex items-center justify-between px-4 py-3 text-white" style="background: {{ $primary }}"><strong>{{ $values['site_name'] ?? config('app.name') }}</strong><span class="text-xs">Catalog · Contact</span></div><div class="grid gap-3 p-4 sm:grid-cols-[1fr_auto]"><div><div class="h-2 w-28 rounded bg-slate-200"></div><div class="mt-2 h-2 w-44 rounded bg-slate-100"></div></div><button type="button" class="px-4 py-2 text-xs font-bold text-white" style="border-radius: {{ $radius }}; background: {{ $accent }}">Primary action</button></div></div></div>
                                @endif
                            </div>
                            <div class="flex items-center justify-between border-t border-hairline bg-[#fafbfc] px-5 py-4"><p class="text-xs text-ink-muted">Changes become available to the storefront immediately after saving.</p><x-sysadmin::btn type="submit" variant="primary" wire:loading.attr="disabled"><span wire:loading.remove wire:target="saveSection">Save {{ Str::lower($sections[$activeSection]['label']) }}</span><span wire:loading wire:target="saveSection">Saving…</span></x-sysadmin::btn></div>
                        </form>
                    @endif

                    @if($activeSection === 'branding')
                        <div class="flex justify-end border-t border-hairline bg-[#fafbfc] px-5 py-4"><x-sysadmin::btn variant="primary" wire:click="saveSection('branding')" wire:loading.attr="disabled">Save branding</x-sysadmin::btn></div>
                    @endif
                </x-sysadmin::card>
            @endif
        </main>
    </div>
</div>
