<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Enquiry extends Model
{
    public const STATUS_ARCHIVED = 0;

    public const STATUS_NEW = 1;

    public const STATUS_CONFIRMED = 2;

    public const STATUS_CANCELLED = 3;

    public const STATUS_CONTACTED = 4;

    public const STATUS_FOLLOW_UP = 5;

    public const STATUS_QUALIFIED = 6;

    public const STATUS_QUOTED = 7;

    public const STATUS_WON = 8;

    public const STATUS_LOST = 9;

    public static array $statuses = [
        self::STATUS_NEW => 'New',
        self::STATUS_CONTACTED => 'Contacted',
        self::STATUS_FOLLOW_UP => 'Follow up',
        self::STATUS_QUALIFIED => 'Qualified',
        self::STATUS_QUOTED => 'Quoted',
        self::STATUS_CONFIRMED => 'Confirmed',
        self::STATUS_WON => 'Won',
        self::STATUS_LOST => 'Lost',
        self::STATUS_CANCELLED => 'Cancelled',
        self::STATUS_ARCHIVED => 'Archived',
    ];

    public static array $priorities = [
        'low' => 'Low',
        'normal' => 'Normal',
        'high' => 'High',
        'urgent' => 'Urgent',
    ];

    protected $table = 'enquiries';

    protected $fillable = [
        'name', 'email', 'mobile', 'city', 'state', 'subject', 'message', 'internal_notes',
        'category_id', 'product_id', 'qty', 'price', 'req_price', 'status', 'priority',
        'assigned_to', 'enquiry_type', 'next_follow_up_at', 'last_contacted_at', 'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'category_id' => 'integer',
            'product_id' => 'integer',
            'qty' => 'decimal:2',
            'price' => 'decimal:2',
            'req_price' => 'decimal:2',
            'status' => 'integer',
            'assigned_to' => 'integer',
            'next_follow_up_at' => 'datetime',
            'last_contacted_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    public static function isClosedStatus(int $status): bool
    {
        return in_array($status, [self::STATUS_WON, self::STATUS_LOST, self::STATUS_CANCELLED, self::STATUS_ARCHIVED], true);
    }

    public static function statusClasses(int $status): string
    {
        return match ($status) {
            self::STATUS_NEW => 'bg-blue-50 text-blue-700',
            self::STATUS_CONTACTED, self::STATUS_FOLLOW_UP => 'bg-amber-50 text-amber-700',
            self::STATUS_QUALIFIED, self::STATUS_QUOTED => 'bg-violet-50 text-violet-700',
            self::STATUS_CONFIRMED, self::STATUS_WON => 'bg-emerald-50 text-emerald-700',
            self::STATUS_LOST, self::STATUS_CANCELLED => 'bg-red-50 text-red-700',
            default => 'bg-slate-100 text-slate-600',
        };
    }

    public function setCategoryIdAttribute($value): void
    {
        $this->attributes['category_id'] = filled($value) ? (int) $value : 0;
    }

    public function setProductIdAttribute($value): void
    {
        $this->attributes['product_id'] = filled($value) ? (int) $value : 0;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(EnquiryFollowUp::class)->latest('scheduled_at');
    }

    public function pendingFollowUps(): HasMany
    {
        return $this->hasMany(EnquiryFollowUp::class)->pending()->orderBy('scheduled_at');
    }

    public function latestPendingFollowUp(): HasOne
    {
        return $this->hasOne(EnquiryFollowUp::class)->ofMany(
            ['scheduled_at' => 'MIN', 'id' => 'MIN'],
            fn (Builder $query) => $query->where('status', EnquiryFollowUp::STATUS_PENDING),
        );
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(EnquiryAppointment::class)->latest('starts_at');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(EnquiryActivity::class)->latest();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotIn('status', [self::STATUS_ARCHIVED, self::STATUS_CANCELLED, self::STATUS_LOST]);
    }
}
