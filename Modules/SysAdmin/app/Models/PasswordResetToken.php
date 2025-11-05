<?php

/**
 * Created by Prabhu.
 */

namespace Modules\SysAdmin\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordResetToken
 * 
 * @property string $email
 * @property string $token
 * @property Carbon|null $created_at
 *
 *  @package Modules\SysAdmin\Models
 */
class PasswordResetToken extends Model
{
	protected $table = 'password_reset_tokens';
	protected $primaryKey = 'email';
	public $incrementing = false;
	public $timestamps = false;

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'token'
	];
}
