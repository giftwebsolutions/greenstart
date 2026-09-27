<div class="w-full max-w-md">
    <a href="{{ route('frontend.home') }}" class="mb-6 flex items-center gap-3"><span class="grid size-14 place-items-center overflow-hidden rounded-xl bg-white shadow-sm"><img src="{{ \Modules\SysAdmin\Models\Settings::assetUrl(config('site-settings.site_logo'), 'admin/images/logo/logo-icon.png') }}" alt="{{ config('app.name') }} logo" class="size-11 object-contain"></span><span><span class="block text-xl font-bold tracking-tight text-ink">{{ config('app.name', 'Products') }}</span><span class="block text-xs font-medium text-ink-muted">Commerce admin panel</span></span></a>
    <section class="rounded-xl border border-hairline bg-white p-6 shadow-sm">
        <div class="mb-5"><h1 class="text-[22px] font-bold tracking-tight text-ink">Welcome back</h1><p class="mt-1 text-[13px] text-ink-muted">Sign in to manage products, attributes and content.</p></div>
        @if(session('success'))<div class="mb-4 rounded-lg bg-emerald-50 px-3 py-2.5 text-[13px] text-emerald-700">{{ session('success') }}</div>@endif
        <form wire:submit="login" class="space-y-4">
            <x-sysadmin::input label="Email address" name="email" type="email" wire:model="email" autocomplete="email" required autofocus />
            <x-sysadmin::input label="Password" name="password" type="password" wire:model="password" autocomplete="current-password" required />
            <div class="flex items-center justify-between"><label class="inline-flex items-center gap-2 text-[12.5px] font-medium text-ink-soft"><input type="checkbox" wire:model="remember" class="size-4 rounded border-hairline-strong text-primary">Remember me</label><a href="{{ route('sysadmin.forget-password') }}" class="text-[12.5px] font-semibold text-primary">Forgot password?</a></div>
            <x-sysadmin::btn type="submit" variant="primary" class="w-full" wire:loading.attr="disabled" wire:target="login"><span wire:loading.remove wire:target="login">Sign in</span><span wire:loading wire:target="login">Signing in…</span></x-sysadmin::btn>
        </form>
    </section>
    <p class="mt-5 text-center text-xs text-ink-muted">Secure administration · {{ config('app.name', 'Products') }}</p>
</div>
