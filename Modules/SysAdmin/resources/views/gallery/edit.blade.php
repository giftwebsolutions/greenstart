@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>Edit Gallery</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Media</li>
    <li class="breadcrumb-item"><a href="{{ route('sysadmin.media.gallery.index') }}">Galleries</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="container-fluid">

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">

            {{-- Left: Edit form --}}
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header p-3"><h5>Gallery Details</h5></div>
                    <form id="edit-gallery" class="theme-form" method="POST" enctype="multipart/form-data"
                          action="{{ route('sysadmin.media.gallery.update', $gallery['id']) }}">
                        @method('PATCH')
                        @csrf

                        <div class="card-body p-3">

                            <div class="mb-3">
                                <label class="col-form-label">Gallery Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $gallery['name']) }}"
                                       class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="col-form-label">Description</label>
                                <textarea name="description" rows="3"
                                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $gallery['description']) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="col-form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="1" {{ $gallery['status'] == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $gallery['status'] == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="col-form-label">Thumbnail</label>
                                <input type="file" name="thumbnail" id="thumbnail"
                                       class="form-control @error('thumbnail') is-invalid @enderror"
                                       accept="image/jpg,image/jpeg,image/png">
                                @error('thumbnail')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                @if($gallery['thumbnail'])
                                    <div class="mt-2">
                                        <img id="thumbnailPreview"
                                             src="{{ asset('storage/' . $gallery['thumbnail']) }}"
                                             class="img-fluid rounded" style="max-height:120px;">
                                    </div>
                                @else
                                    <img id="thumbnailPreview" class="img-fluid rounded d-none mt-2" style="max-height:120px;">
                                @endif
                            </div>

                        </div>

                        <div class="card-footer text-end">
                            <a href="{{ route('sysadmin.media.gallery.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary mx-2">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Right: Image management --}}
            <div class="col-md-7">
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
                                <div class="col-6 col-sm-4" id="img-{{ $item['id'] }}">
                                    <div class="position-relative">
                                        <img src="{{ $item['url'] }}" class="img-fluid rounded"
                                             style="height:110px;width:100%;object-fit:cover;">
                                        <button type="button"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 remove-image"
                                                data-id="{{ $item['id'] }}" title="Remove">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12" id="no-images-msg">
                                    <p class="text-muted text-center py-4">No images yet.</p>
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
    {!! JsValidator::formRequest('Modules\SysAdmin\Requests\GalleryFormRequest', '#edit-gallery') !!}
    <script>
        const galleryId   = {{ $gallery['id'] }};
        const createdAt   = '{{ urlencode($gallery['created_at']) }}';
        const uploadUrl   = `/sysadmin/media/gallery/add-item/${galleryId}/${createdAt}`;
        const removeUrl   = '/sysadmin/media/gallery/remove-item/';
        const csrfToken   = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.getElementById('thumbnail').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById('thumbnailPreview');
                img.src = e.target.result;
                img.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        });

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
                        div.className = 'col-6 col-sm-4';
                        div.id = 'img-' + data.item.id;
                        div.innerHTML = `
                            <div class="position-relative">
                                <img src="${data.item.path}" class="img-fluid rounded"
                                     style="height:110px;width:100%;object-fit:cover;">
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

            const id = btn.dataset.id;
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
