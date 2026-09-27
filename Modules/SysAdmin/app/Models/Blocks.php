<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blocks extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'blocks';

    protected $fillable = [
        'key',
        'value',
        'title',
        'thumbnail',
        'icon'
    ];
}
