<?php

namespace Modules\SysAdmin\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GalleryItem
 * 
 * @property int $id
 * @property int $gallery_id
 * @property string $path
 * @property string|null $title
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Gallery $gallery
 *
 * @package App\Models
 */
class GalleryItem extends Model
{
	protected $table = 'gallery_items';

	protected $casts = [
		'gallery_id' => 'int'
	];

	protected $fillable = [
		'gallery_id',
		'path',
		'title',
		'description',
		'timestamp'
	];

	public function gallery()
	{
		return $this->belongsTo(Gallery::class);
	}
}
