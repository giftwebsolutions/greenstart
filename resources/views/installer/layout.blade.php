<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Install {{ config('app.name', 'Product Catalog') }}</title>
    <link rel="stylesheet" href="{{ asset('admin/css/vendors/bootstrap.css') }}">
    @livewireStyles
    <style>
        :root{--installer-primary:#635bdb;--installer-ink:#252a34;--installer-muted:#697386;--installer-bg:#f4f6fa}
        body{background:linear-gradient(145deg,#f9fafc 0%,#eef0fb 100%);color:var(--installer-ink);font-family:Inter,ui-sans-serif,system-ui,-apple-system,sans-serif;min-height:100vh}
        .install-shell{margin:0 auto;max-width:1060px;padding:4rem 1.25rem}
        .install-brand{align-items:center;display:flex;gap:.85rem;margin-bottom:2rem}.install-brand-mark{align-items:center;background:var(--installer-primary);border-radius:.8rem;color:#fff;display:flex;font-size:1.25rem;font-weight:800;height:2.8rem;justify-content:center;width:2.8rem}.install-brand strong{display:block}.install-brand small{color:var(--installer-muted)}
        .install-card{background:#fff;border:1px solid #e4e7ec;border-radius:1.25rem;box-shadow:0 1rem 3rem rgba(30,35,55,.08);overflow:hidden}.install-grid{display:grid;grid-template-columns:270px minmax(0,1fr)}
        .install-sidebar{background:#222735;color:#fff;padding:2rem}.install-sidebar h2{font-size:1.35rem}.install-sidebar p{color:#aeb5c5;font-size:.9rem}.install-steps{display:grid;gap:.55rem;margin-top:2rem}.install-step{align-items:center;border-radius:.7rem;color:#aeb5c5;display:flex;gap:.75rem;padding:.7rem}.install-step span{align-items:center;border:1px solid #555d70;border-radius:50%;display:flex;font-size:.75rem;font-weight:700;height:1.75rem;justify-content:center;width:1.75rem}.install-step.active{background:#343b4d;color:#fff}.install-step.active span,.install-step.complete span{background:var(--installer-primary);border-color:var(--installer-primary);color:#fff}
        .install-main{min-height:610px;padding:2.25rem}.install-main h1{font-size:1.65rem;margin-bottom:.4rem}.install-lead{color:var(--installer-muted);margin-bottom:2rem}.requirement-grid{display:grid;gap:.6rem;grid-template-columns:1fr 1fr}.requirement{align-items:center;border:1px solid #e5e7eb;border-radius:.7rem;display:flex;justify-content:space-between;padding:.75rem}.requirement small{color:var(--installer-muted)}.check{color:#198754;font-weight:800}.fail{color:#dc3545;font-weight:800}.install-actions{align-items:center;border-top:1px solid #eceef2;display:flex;justify-content:space-between;margin-top:2rem;padding-top:1.25rem}.form-label{font-size:.85rem;font-weight:650}.help{color:var(--installer-muted);font-size:.78rem}.review-box{background:#f7f8fb;border-radius:.8rem;display:grid;gap:.8rem;padding:1rem}.review-box div{display:flex;justify-content:space-between}.success-mark{align-items:center;background:#d3f9d8;border-radius:50%;color:#237a35;display:flex;font-size:2rem;height:5rem;justify-content:center;margin:1rem auto;width:5rem}
        @media(max-width:800px){.install-shell{padding:1.5rem .75rem}.install-grid{grid-template-columns:1fr}.install-sidebar{padding:1.25rem}.install-sidebar>p{display:none}.install-steps{grid-template-columns:repeat(4,1fr);margin-top:1rem}.install-step{justify-content:center;padding:.4rem}.install-step strong{display:none}.install-main{min-height:auto;padding:1.25rem}.requirement-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
    <main class="install-shell">
        <div class="install-brand"><div class="install-brand-mark">P</div><div><strong>Product Catalog</strong><small>Secure installation wizard</small></div></div>
        @yield('content')
    </main>
    @livewireScripts
</body>
</html>
