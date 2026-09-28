<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnquiryAppointment extends Model
{
    public static array $statuses = [
        'scheduled' => 'Scheduled',
        'confirmed' => 'Confirmed',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        'no_show' => 'No show',
    ];

    public static array $meetingTypes = [
        'in_person' => 'In person',
        'phone' => 'Phone call',
        'video' => 'Video meeting',
        'site_visit' => 'Site visit',
    ];

    protected $table = 'enquiry_appointments';

    protected $fillable = [
        'enquiry_id', 'assigned_to', 'created_by', 'title', 'customer_name', 'mobile', 'email',
        'starts_at', 'ends_at', 'meeting_type', 'location', 'status', 'notes',
    ];

    protected function casts(): array
    {
        return ['starts_at' => 'datetime', 'ends_at' => 'datetime'];
    }

    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
