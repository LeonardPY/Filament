<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'content',
        'is_publish'
    ];

    protected $casts = [
        'is_publish' => 'boolean'
    ];

    public function category(): belongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function tags(): belongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }
}
