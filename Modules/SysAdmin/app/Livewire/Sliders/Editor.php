<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Livewire\Sliders;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\SysAdmin\Helpers\ImageUploader;
use Modules\SysAdmin\Models\Slider;
use Modules\SysAdmin\Models\SliderItem;

class Editor extends Component
{
    use WithFileUploads;

    public ?int $sliderId = null;

    public string $name = '';

    public string $slug = '';

    public string $description = '';

    public int $status = 1;

    public ?string $thumbnail = null;

    public bool $removeThumbnail = false;

    public $newThumbnail = null;

    /** @var array<int, array<string, mixed>> */
    public array $items = [];

    /** @var array<int, mixed> */
    public array $itemUploads = [];

    public bool $itemsDirty = false;

    public bool $showAddItem = false;

    public string $newItemTitle = '';

    public string $newItemPath = '';

    public string $newItemTarget = '_self';

    public string $newItemDescription = '';

    public $newItemFile = null;

    public function mount(?int $id = null): void
    {
        if (! $id) {
            return;
        }

        $slider = Slider::query()->findOrFail($id);
        $this->sliderId = $slider->id;
        $this->name = $slider->name;
        $this->slug = $slider->slug;
        $this->description = (string) $slider->description;
        $this->status = (int) $slider->status;
        $this->thumbnail = $slider->thumbnail;
        $this->loadItems();
    }

    public function updatedName(string $value): void
    {
        if (! $this->sliderId || $this->slug === '') {
            $this->slug = Str::slug($value);
        }
    }

    public function saveDetails(): void
    {
        $data = $this->validate([
            'name' => ['required', 'string', 'max:120', Rule::unique('sliders', 'name')->ignore($this->sliderId)],
            'slug' => ['required', 'alpha_dash:ascii', 'max:160', Rule::unique('sliders', 'slug')->ignore($this->sliderId)],
            'description' => ['nullable', 'string', 'max:65535'],
            'status' => ['required', Rule::in([0, 1])],
            'newThumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'removeThumbnail' => ['boolean'],
        ]);

        $creating = $this->sliderId === null;
        $slider = $creating ? new Slider : Slider::query()->findOrFail($this->sliderId);
        $oldThumbnail = $slider->thumbnail;
        $slider->fill([
            'name' => trim($data['name']),
            'slug' => Str::slug($data['slug']),
            'description' => trim($data['description']) ?: null,
            'status' => $data['status'],
        ])->save();

        if ($this->newThumbnail) {
            $slider->thumbnail = ImageUploader::upload($this->newThumbnail, (string) $slider->created_at);
            $slider->save();
        } elseif ($this->removeThumbnail) {
            $slider->thumbnail = null;
            $slider->save();
        }

        if ($oldThumbnail && $oldThumbnail !== $slider->thumbnail) {
            ImageUploader::remove((string) $slider->created_at, $oldThumbnail);
        }

        $this->sliderId = $slider->id;
        $this->thumbnail = $slider->thumbnail;
        $this->newThumbnail = null;
        $this->removeThumbnail = false;
        $this->dispatch('toast', message: $creating ? 'Slider created. Add slides below.' : 'Slider details saved.');
    }

    public function addItem(): void
    {
        $this->ensureSliderExists();
        $data = $this->validate([
            'newItemTitle' => ['required', 'string', 'max:120'],
            'newItemPath' => ['required', 'string', 'max:255'],
            'newItemTarget' => ['required', Rule::in(['_self', '_blank'])],
            'newItemDescription' => ['nullable', 'string', 'max:65535'],
            'newItemFile' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], attributes: [
            'newItemTitle' => 'slide title',
            'newItemPath' => 'slide link',
            'newItemTarget' => 'link target',
            'newItemDescription' => 'slide description',
            'newItemFile' => 'slide image',
        ]);

        $slider = Slider::query()->findOrFail($this->sliderId);
        SliderItem::query()->create([
            'slider_id' => $slider->id,
            'title' => trim($data['newItemTitle']),
            'path' => trim($data['newItemPath']),
            'target' => $data['newItemTarget'],
            'description' => trim($data['newItemDescription']) ?: null,
            'file' => ImageUploader::upload($this->newItemFile),
            'sort_order' => SliderItem::query()->where('slider_id', $slider->id)->max('sort_order') + 1,
        ]);

        $this->reset('newItemTitle', 'newItemPath', 'newItemDescription', 'newItemFile', 'showAddItem');
        $this->newItemTarget = '_self';
        $this->loadItems();
        $this->dispatch('toast', message: 'Slide added.');
    }

    public function moveItem(int $index, string $direction): void
    {
        $target = $direction === 'up' ? $index - 1 : $index + 1;
        if (! isset($this->items[$index], $this->items[$target])) {
            return;
        }

        [$this->items[$index], $this->items[$target]] = [$this->items[$target], $this->items[$index]];
        $this->itemsDirty = true;
    }

    public function saveItems(): void
    {
        $this->ensureSliderExists();
        $rules = ['items' => ['array', 'max:100']];
        foreach ($this->items as $index => $item) {
            $rules["items.$index.title"] = ['required', 'string', 'max:120'];
            $rules["items.$index.path"] = ['required', 'string', 'max:255'];
            $rules["items.$index.target"] = ['required', Rule::in(['_self', '_blank'])];
            $rules["items.$index.description"] = ['nullable', 'string', 'max:65535'];
            $rules["itemUploads.$index"] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'];
        }
        $this->validate($rules);

        $slider = Slider::query()->findOrFail($this->sliderId);
        foreach ($this->items as $position => $row) {
            $item = SliderItem::query()->where('slider_id', $slider->id)->findOrFail((int) $row['id']);
            $oldFile = $item->file;
            $file = isset($this->itemUploads[$position])
                ? ImageUploader::upload($this->itemUploads[$position], (string) $item->created_at)
                : $oldFile;

            $item->update([
                'title' => trim((string) $row['title']),
                'path' => trim((string) $row['path']),
                'target' => $row['target'],
                'description' => trim((string) $row['description']) ?: null,
                'file' => $file,
                'sort_order' => $position,
            ]);

            if ($oldFile !== $file) {
                ImageUploader::remove((string) $item->created_at, $oldFile);
            }
        }

        $this->loadItems();
        $this->dispatch('toast', message: 'Slides and ordering saved.');
    }

    public function deleteItem(int $itemId): void
    {
        $this->ensureSliderExists();
        $slider = Slider::query()->findOrFail($this->sliderId);
        $item = SliderItem::query()->where('slider_id', $slider->id)->findOrFail($itemId);
        ImageUploader::remove((string) $item->created_at, $item->file);
        $item->delete();
        $this->loadItems();
        $this->dispatch('toast', message: 'Slide removed.');
    }

    public function render()
    {
        $slider = $this->sliderId ? Slider::query()->findOrFail($this->sliderId) : null;

        return view('sysadmin::livewire.sliders.editor', compact('slider'));
    }

    private function loadItems(): void
    {
        $this->items = SliderItem::query()
            ->where('slider_id', $this->sliderId)
            ->orderBy('sort_order')->orderBy('id')
            ->get()
            ->map(fn (SliderItem $item): array => [
                'id' => $item->id,
                'title' => (string) $item->title,
                'path' => (string) $item->path,
                'target' => $item->target ?: '_self',
                'description' => (string) $item->description,
                'file' => $item->file,
                'created_at' => (string) $item->created_at,
            ])->all();
        $this->itemUploads = [];
        $this->itemsDirty = false;
        $this->resetValidation();
    }

    private function ensureSliderExists(): void
    {
        abort_unless($this->sliderId && Slider::query()->whereKey($this->sliderId)->exists(), 404);
    }
}
