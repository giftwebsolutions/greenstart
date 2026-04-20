@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>{{ $gallery['name'] }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Media</li>
    <li class="breadcrumb-item"><a href="{{ route('sysadmin.media.gallery.index') }}">Galleries</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex gap-2">
                    <a href="{{ url()->previous() }}" class="btn btn-primary"><i class="bi bi-arrow-left"></i></a>
                    <a href="{{ route('sysadmin.media.gallery.edit', $gallery['id']) }}" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></a>
                    <a href="{{ route('sysadmin.media.gallery.index') }}" class="btn btn-primary"><i class="bi bi-list"></i></a>
                </div>
            </div>
        </div>

        {{-- Gallery info --}}
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header p-3"><h5>Gallery Info</h5></div>
                    <div class="card-body p-3">
                        <table class="table table-sm table-bordered">
                            <tr><th>Name</th><td>{{ $gallery['name'] }}</td></tr>
                            <tr><th>Slug</th><td>{{ $gallery['slug'] }}</td></tr>
                            <tr><th>Status</th><td>{{ $gallery['status'] == 1 ? 'Active' : 'Inactive' }}</td></tr>
                            @if($gallery['description'])
                            <tr><th>Description</th><td>{{ $gallery['description'] }}</td></tr>
                            @endif
                            <tr><th>Created</th><td>{{ date('d-m-Y H:i', strtotime($gallery['created_at'])) }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Image upload zone --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header p-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Images</h5>
                        <label for="imageUploadInput" class="btn btn-sm btn-primary mb-0">
                            <i class="bi bi-plus-lg"></i> Add Images
                        </label>
                    </div>
                    <div class="card-body p-3">
                        <input type="file" id="imageUploadInput" class="d-none" multiple accept="image/jpg,image/jpeg,image/png">

                        <div id="uploadProgress" class="mb-3 d-none">
                            <div class="progress">
                                <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                                     style="width:0%"></div>
                            </div>
                            <small id="uploadStatus" class="text-muted"></small>
                        </div>

                        <div id="imageGrid" class="row g-2">
                            @forelse ($items as $item)
                                <div class="col-6 col-md-3" id="img-{{ $item['id'] }}">
                                    <div class="position-relative">
                                        <img src="{{ $item['url'] }}" class="img-fluid rounded" style="height:120px;width:100%;object-fit:cover;">
                                        <button type="button"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 remove-image"
                                                data-id="{{ $item['id'] }}"
                                                title="Remove">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12" id="no-images-msg">
                                    <p class="text-muted text-center py-4">No images yet. Click "Add Images" to upload.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@pushOnce('scripts')
<script>
    const galleryId   = {{ $gallery['id'] }};
    const createdAt   = '{{ urlencode($gallery['created_at']) }}';
    const uploadUrl   = `/sysadmin/media/gallery/add-item/${galleryId}/${createdAt}`;
    const removeUrl   = '/sysadmin/media/gallery/remove-item/';
    const csrfToken   = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.getElementById('imageUploadInput').addEventListener('change', function () {
        const files = Array.from(this.files);
        if (!files.length) return;

        const progress    = document.getElementById('uploadProgress');
        const progressBar = document.getElementById('progressBar');
        const status      = document.getElementById('uploadStatus');
        progress.classList.remove('d-none');

        let completed = 0;

        files.forEach(file => {
            const formData = new FormData();
            formData.append('file', file);

            fetch(uploadUrl, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData,
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const noMsg = document.getElementById('no-images-msg');
                    if (noMsg) noMsg.remove();

                    const div = document.createElement('div');
                    div.className = 'col-6 col-md-3';
                    div.id = 'img-' + data.item.id;
                    div.innerHTML = `
                        <div class="position-relative">
                            <img src="${data.item.path}" class="img-fluid rounded" style="height:120px;width:100%;object-fit:cover;">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 remove-image"
                                    data-id="${data.item.id}" title="Remove">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>`;
                    document.getElementById('imageGrid').appendChild(div);
                }
            })
            .finally(() => {
                completed++;
                const pct = Math.round((completed / files.length) * 100);
                progressBar.style.width = pct + '%';
                status.textContent = `${completed} of ${files.length} uploaded`;
                if (completed === files.length) {
                    setTimeout(() => progress.classList.add('d-none'), 1500);
                }
            });
        });

        this.value = '';
    });

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-image');
        if (!btn) return;

        if (!confirm('Remove this image?')) return;

        const id  = btn.dataset.id;
        fetch(removeUrl + id, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        })
        .then(() => {
            const el = document.getElementById('img-' + id);
            if (el) el.remove();
        });
    });
</script>
@endPushOnce
