<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Livewire\Testimonials;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Modules\SysAdmin\Helpers\ImageUploader;
use Modules\SysAdmin\Interfaces\TestimonialInterface;
use Modules\SysAdmin\Models\Testimonial;

class Workspace extends Component
{
    use WithFileUploads;
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    public int $perPage = 12;

    public bool $drawerOpen = false;

    public ?int $editingId = null;

    public ?int $confirmingDelete = null;

    public string $name = '';

    public string $content = '';

    public $image = null;

    public string $existingImageUrl = '';

    public bool $removeImage = false;

    public function mount(?int $testimonialId = null, bool $startCreating = false): void
    {
        Gate::authorize('content.testimonials.view');

        if ($testimonialId) {
            $this->edit($testimonialId);
        } elseif ($startCreating) {
            $this->create();
        }
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(int $value): void
    {
        if (! in_array($value, [12, 24, 48], true)) {
            $this->perPage = 12;
        }

        $this->resetPage();
    }

    public function create(): void
    {
        Gate::authorize('content.testimonials.create');
        $this->resetForm();
        $this->drawerOpen = true;
    }

    public function edit(int $testimonialId): void
    {
        Gate::authorize('content.testimonials.update');
        $testimonial = Testimonial::query()->findOrFail($testimonialId);

        $this->editingId = $testimonial->id;
        $this->name = $testimonial->name;
        $this->content = $testimonial->content;
        $this->existingImageUrl = $testimonial->image ? $testimonial->image_url : '';
        $this->image = null;
        $this->removeImage = false;
        $this->resetValidation();
        $this->drawerOpen = true;
    }

    public function save(TestimonialInterface $testimonials): void
    {
        Gate::authorize($this->editingId ? 'content.testimonials.update' : 'content.testimonials.create');

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'content' => ['required', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'removeImage' => ['boolean'],
        ], attributes: [
            'content' => 'testimonial',
            'removeImage' => 'remove image',
        ]);

        $testimonials->saveOrUpdate([
            'name' => trim($validated['name']),
            'content' => trim($validated['content']),
            'image' => $validated['image'] ?? null,
            'remove_image' => (bool) $validated['removeImage'],
        ], $this->editingId ?? 0);

        $message = $this->editingId ? 'Testimonial updated.' : 'Testimonial created.';
        $this->drawerOpen = false;
        $this->resetForm();
        $this->resetPage();
        $this->dispatch('toast', message: $message);
    }

    public function clearImage(): void
    {
        $this->image = null;
        $this->removeImage = true;
        $this->resetValidation('image');
    }

    public function confirmDelete(int $testimonialId): void
    {
        Gate::authorize('content.testimonials.delete');
        $this->confirmingDelete = Testimonial::query()->findOrFail($testimonialId)->id;
    }

    public function delete(TestimonialInterface $testimonials): void
    {
        Gate::authorize('content.testimonials.delete');

        if ($this->confirmingDelete) {
            $testimonial = Testimonial::query()->find($this->confirmingDelete);
            if ($testimonial) {
                if ($testimonial->image && $testimonial->created_at) {
                    ImageUploader::remove($testimonial->created_at->toDateTimeString(), $testimonial->image);
                }
                $testimonials->delete($testimonial->id);
                $this->dispatch('toast', message: 'Testimonial deleted.');
            }
        }

        $this->confirmingDelete = null;
        $this->resetPage();
    }

    public function closeDrawer(): void
    {
        $this->drawerOpen = false;
        $this->resetForm();
    }

    public function render()
    {
        Gate::authorize('content.testimonials.view');

        $testimonials = Testimonial::query()
            ->when(trim($this->search) !== '', function (Builder $query): void {
                $term = '%'.trim($this->search).'%';
                $query->where(fn (Builder $nested) => $nested
                    ->where('name', 'like', $term)
                    ->orWhere('content', 'like', $term));
            })
            ->latest('id')
            ->paginate($this->perPage);

        $stats = [
            'total' => Testimonial::query()->count(),
            'with_image' => Testimonial::query()->whereNotNull('image')->where('image', '!=', '')->count(),
            'updated_this_month' => Testimonial::query()->where('updated_at', '>=', now()->startOfMonth())->count(),
        ];

        return view('sysadmin::livewire.testimonials.workspace', compact('testimonials', 'stats'));
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'content', 'image', 'existingImageUrl', 'removeImage']);
        $this->resetValidation();
    }
}
