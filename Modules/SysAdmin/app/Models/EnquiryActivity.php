<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnquiryActivity extends Model
{
    protected $table = 'enquiry_activities';

    protected $fillable = ['created_by', 'type', 'description', 'properties'];

    protected function casts(): array
    {
        return ['properties' => 'array'];
    }

    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
