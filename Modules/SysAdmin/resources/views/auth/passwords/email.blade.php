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
        <h1 class="text-[22px] font-bold tracking-tight text-ink">Reset your password</h1>
        <p class="mt-1 text-[13px] text-ink-muted">We will email a secure reset link to your account.</p>

        @if (session('status'))
            <div class="mt-4 rounded-lg bg-emerald-50 px-3 py-2.5 text-[13px] text-emerald-700" role="status">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('sysadmin.forget-password.post') }}" class="mt-5 space-y-4">
            @csrf
            <x-sysadmin::input label="Email address" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus />
            <x-sysadmin::btn type="submit" variant="primary" class="w-full">Send password reset link</x-sysadmin::btn>
        </form>

        <a href="{{ route('sysadmin.login.form') }}" class="mt-4 block text-center text-[12.5px] font-semibold text-primary">Back to sign in</a>
    </section>
</div>
@endsection
