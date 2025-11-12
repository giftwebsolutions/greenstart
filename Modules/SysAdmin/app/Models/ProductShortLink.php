<?php

namespace Modules\SysAdmin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductShortLink
 * 
 * @property int $id
 * @property int $product_id
 * @property string|null $label
 * @property string $url
 * @property int $created_at
 * @property int $updated_at
 *
 * @package App\Models
 */
class ProductShortLink extends Model
{
	protected $table = 'product_short_link';

	protected $casts = [
		'product_id' => 'int'
	];

	protected $fillable = [
		'product_id',
		'label',
		'url'
	];
}
