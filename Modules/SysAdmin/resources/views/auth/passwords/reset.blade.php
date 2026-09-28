@extends('sysadmin::layouts.auth')

@section('content')
    <div class="w-full max-w-md">
        <a href="{{ route('sysadmin.login.form') }}" class="mb-6 flex items-center gap-3">
            <span class="grid size-14 place-items-center overflow-hidden rounded-xl bg-white shadow-sm">
                <img src="{{ \Modules\SysAdmin\Models\Settings::assetUrl(config('site-settings.site_logo'), 'admin/images/logo/logo-icon.png') }}" alt="{{ config('app.name') }} logo" class="size-11 object-contain">
            </span>
            <span>
                <span class="block text-xl font-bold tracking-tight text-ink">{{ config('app.name', 'Products') }}</span>
                <span class="block text-xs font-medium text-ink-muted">Commerce admin panel</span>
            </span>
        </a>

        <section class="rounded-xl border border-hairline bg-white p-6 shadow-sm">
            <h1 class="text-[22px] font-bold tracking-tight text-ink">Choose a new password</h1>
            <p class="mt-1 text-[13px] text-ink-muted">Use at least eight characters and keep it unique.</p>

            <form method="POST" action="{{ route('sysadmin.reset-password.post') }}" class="mt-5 space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <x-sysadmin::input label="Email address" name="email" type="email" value="{{ $email ?? old('email') }}" autocomplete="email" required autofocus />
                <x-sysadmin::input label="New password" name="password" type="password" autocomplete="new-password" required />
                <x-sysadmin::input label="Confirm password" name="password_confirmation" type="password" autocomplete="new-password" required />
                <x-sysadmin::btn type="submit" variant="primary" class="w-full">Reset password</x-sysadmin::btn>
            </form>
        </section>
    </div>
@endsection
