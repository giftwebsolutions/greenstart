<div class="install-card">
    <div class="install-grid">
        <aside class="install-sidebar">
            <h2>Let’s get started</h2>
            <p>This guided setup checks the server, connects your database and creates the first administrator.</p>
            <div class="install-steps">
                @foreach ([1 => 'Requirements', 2 => 'Database', 3 => 'Application', 4 => 'Install'] as $number => $label)
                    <div class="install-step {{ $step === $number ? 'active' : '' }} {{ $step > $number || $completed ? 'complete' : '' }}"><span>{{ $step > $number || $completed ? '✓' : $number }}</span><strong>{{ $label }}</strong></div>
                @endforeach
            </div>
        </aside>
        <section class="install-main">
            @if ($completed)
                <div class="text-center py-5">
                    <div class="success-mark">✓</div>
                    <h1>Installation complete</h1>
                    <p class="install-lead">Your catalog is ready. Sign in with the administrator account you just created.</p>
                    <a href="{{ route('sysadmin.login.form') }}" class="btn btn-primary px-4">Open SysAdmin</a>
                </div>
            @elseif ($step === 1)
                <h1>Server requirements</h1><p class="install-lead">Everything below must pass before files or database records are changed.</p>
                @error('requirements')<div class="alert alert-danger">{{ $message }}</div>@enderror
                <div class="requirement-grid">@foreach ($requirements as $requirement)<div class="requirement"><div><strong>{{ $requirement['label'] }}</strong><br><small>{{ $requirement['detail'] }}</small></div><span class="{{ $requirement['passed'] ? 'check' : 'fail' }}">{{ $requirement['passed'] ? '✓' : '×' }}</span></div>@endforeach</div>
                <div class="install-actions"><span></span><button wire:click="continueFromRequirements" class="btn btn-primary">Continue →</button></div>
            @elseif ($step === 2)
                <h1>Database connection</h1><p class="install-lead">Use an existing empty MySQL database. The installer will create all application tables.</p>
                @error('database')<div class="alert alert-danger">{{ $message }}</div>@enderror
                @if ($databaseVerified)<div class="alert alert-success">Database connection verified.</div>@endif
                <div class="row g-3">
                    <div class="col-md-8"><label class="form-label">Database host</label><input wire:model="dbHost" class="form-control @error('dbHost') is-invalid @enderror">@error('dbHost')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-4"><label class="form-label">Port</label><input wire:model="dbPort" class="form-control @error('dbPort') is-invalid @enderror">@error('dbPort')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-12"><label class="form-label">Database name</label><input wire:model="dbDatabase" class="form-control @error('dbDatabase') is-invalid @enderror" autocomplete="off">@error('dbDatabase')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label class="form-label">Username</label><input wire:model="dbUsername" class="form-control @error('dbUsername') is-invalid @enderror" autocomplete="username">@error('dbUsername')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label class="form-label">Password</label><input wire:model="dbPassword" type="password" class="form-control @error('dbPassword') is-invalid @enderror" autocomplete="new-password">@error('dbPassword')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                </div>
                <div class="install-actions"><button wire:click="previousStep" class="btn btn-outline-secondary">← Back</button><div class="d-flex gap-2"><button wire:click="testDatabase" class="btn btn-outline-primary">Test connection</button><button wire:click="continueFromDatabase" class="btn btn-primary">Continue →</button></div></div>
            @elseif ($step === 3)
                <h1>Application and administrator</h1><p class="install-lead">Set the public identity and create the first secure SysAdmin account.</p>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Application name</label><input wire:model="appName" class="form-control @error('appName') is-invalid @enderror">@error('appName')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label class="form-label">Application URL</label><input wire:model="appUrl" type="url" class="form-control @error('appUrl') is-invalid @enderror">@error('appUrl')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label class="form-label">Administrator name</label><input wire:model="adminName" class="form-control @error('adminName') is-invalid @enderror" autocomplete="name">@error('adminName')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label class="form-label">Administrator email</label><input wire:model="adminEmail" type="email" class="form-control @error('adminEmail') is-invalid @enderror" autocomplete="email">@error('adminEmail')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label class="form-label">Password</label><input wire:model="adminPassword" type="password" class="form-control @error('adminPassword') is-invalid @enderror" autocomplete="new-password"><div class="help mt-1">Use at least 10 characters.</div>@error('adminPassword')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label class="form-label">Confirm password</label><input wire:model="adminPasswordConfirmation" type="password" class="form-control @error('adminPasswordConfirmation') is-invalid @enderror" autocomplete="new-password">@error('adminPasswordConfirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                </div>
                <div class="install-actions"><button wire:click="previousStep" class="btn btn-outline-secondary">← Back</button><button wire:click="continueFromApplication" class="btn btn-primary">Review →</button></div>
            @else
                <h1>Ready to install</h1><p class="install-lead">The installer will write environment settings, migrate the schema and create your administrator.</p>
                @if ($failure)<div class="alert alert-danger">{{ $failure }}</div>@endif
                <div class="review-box"><div><span>Application</span><strong>{{ $appName }}</strong></div><div><span>URL</span><strong>{{ $appUrl }}</strong></div><div><span>Database</span><strong>{{ $dbDatabase }} on {{ $dbHost }}</strong></div><div><span>Administrator</span><strong>{{ $adminEmail }}</strong></div></div>
                <div class="alert alert-warning mt-3 mb-0"><strong>Before continuing:</strong> back up an existing database. Installation is intended for an empty database.</div>
                <div class="install-actions"><button wire:click="previousStep" class="btn btn-outline-secondary">← Back</button><button wire:click="install" wire:loading.attr="disabled" class="btn btn-primary px-4"><span wire:loading.remove wire:target="install">Install now</span><span wire:loading wire:target="install">Installing…</span></button></div>
            @endif
        </section>
    </div>
</div>
