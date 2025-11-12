<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlogCategory
 * 
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 * @property string|null $content
 * @property string|null $keywords
 * @property string|null $description
 * @property int $status
 * @property string|null $featured_image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property BlogCategory|null $blog_category
 * @property Collection|BlogCategory[] $blog_categories
 * @property Collection|Blog[] $blogs
 *
 * @package App\Models
 */
class BlogCategory extends Model
{
	protected $table = 'blog_categories';

	protected $casts = [
		'parent_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'slug',
		'parent_id',
		'content',
		'keywords',
		'description',
		'status',
		'featured_image'
	];

	public function blog_category()
	{
		return $this->belongsTo(BlogCategory::class, 'parent_id');
	}

	public function blog_categories()
	{
		return $this->hasMany(BlogCategory::class, 'parent_id');
	}

	public function blogs()
	{
		return $this->hasMany(Blog::class, 'sub_category');
	}
}
