<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Blog
 * 
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int|null $category_id
 * @property string|null $content
 * @property string|null $keywords
 * @property string|null $description
 * @property int|null $author_id
 * @property string|null $featured_image
 * @property Carbon|null $published_at
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $post_type
 * @property string|null $video_url
 * @property int $type
 * @property int|null $sub_category
 * @property string $is_future
 * @property string|null $banner
 * 
 * @property BlogCategory|null $blog_category
 *
 * @package App\Models
 */
class Blog extends Model
{
	protected $table = 'blogs';

	protected $casts = [
		'category_id' => 'int',
		'author_id' => 'int',
		'published_at' => 'datetime',
		'status' => 'int',
		'post_type' => 'int',
		'type' => 'int',
		'sub_category' => 'int'
	];

	protected $fillable = [
		'title',
		'slug',
		'category_id',
		'content',
		'keywords',
		'description',
		'author_id',
		'featured_image',
		'published_at',
		'status',
		'post_type',
		'video_url',
		'type',
		'sub_category',
		'is_future',
		'banner'
	];

	public function blog_category()
	{
		return $this->belongsTo(BlogCategory::class, 'sub_category');
	}
}
