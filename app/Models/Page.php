<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Page
 * 
 * @property int $id
 * @property string $title
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 * @property string|null $content
 * @property string|null $keywords
 * @property string|null $description
 * @property int|null $author_id
 * @property int $status
 * @property string|null $featured_image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $banner
 * @property int $order_id
 * 
 * @property Page|null $page
 * @property Collection|Page[] $pages
 *
 * @package App\Models
 */
class Page extends Model
{
	protected $table = 'pages';

	protected $casts = [
		'parent_id' => 'int',
		'author_id' => 'int',
		'status' => 'int',
		'order_id' => 'int'
	];

	protected $fillable = [
		'title',
		'name',
		'slug',
		'parent_id',
		'content',
		'keywords',
		'description',
		'author_id',
		'status',
		'featured_image',
		'banner',
		'order_id'
	];

	public function page()
	{
		return $this->belongsTo(Page::class, 'parent_id');
	}

	public function pages()
	{
		return $this->hasMany(Page::class, 'parent_id');
	}
}
