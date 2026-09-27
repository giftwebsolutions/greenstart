<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AttributeGroup
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property int $status
 * @property Collection|Attribute[] $attributes
 * @property Collection|AttributeMapping[] $mappings
 */
class AttributeGroup extends Model
{
    protected $table = 'attribute_group';

    public $timestamps = false;

    /**
     * Available status options.
     */
    public array $statuses = [
        0 => 'Delete',
        1 => 'Published',
        2 => 'Draft',
    ];

    protected $casts = [
        'family_id' => 'int',
        'position' => 'int',
        'is_user_defined' => 'bool',
        'status' => 'int',
    ];

    protected $fillable = [
        'family_id',
        'name',
        'slug',
        'position',
        'is_user_defined',
        'status',
    ];

    public function family()
    {
        return $this->belongsTo(AttributeFamily::class, 'family_id');
    }

    /**
     * Many-to-many: Group ↔ Attributes via attribute_group_map
     * Includes optional pivot column: value
     */
    public function attributes()
    {
        return $this->belongsToMany(
            Attribute::class,
            'attribute_mapping',   // pivot table
            'group_id',              // FK on pivot pointing to this model
            'attribute_id'           // FK on pivot pointing to Attribute
        )->withPivot(['value', 'position'])
            ->orderByPivot('position')
            ->withTimestamps();        // remove if your pivot stores int timestamps
    }

    /**
     * Direct access to mapping rows (pivot as a model).
     */
    public function mappings()
    {
        return $this->hasMany(AttributeMapping::class, 'group_id', 'id');
    }

    /**
     * Scope: only Published (and optionally Draft) groups.
     */
    public function scopeActive($query, bool $includeDraft = false)
    {
        return $includeDraft
            ? $query->whereIn('status', [1, 2])
            : $query->where('status', 1);
    }

    /**
     * Helper to get status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->statuses[$this->status] ?? (string) $this->status;
    }
}
