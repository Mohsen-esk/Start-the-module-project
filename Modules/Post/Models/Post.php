<?php

namespace Modules\Post\Models;

use Modules\Post\Models\Category;
use Modules\Post\Models\Comment;
use Modules\Auth\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Post extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'published'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(function (string $eventName) {
                $verb = match ($eventName) {
                    'created' => 'ایجاد کرد',
                    'updated' => 'بروزرسانی کرد',
                    'deleted' => 'حذف کرد',
                    default => $eventName,
                };
                return "پست \"{$this->title}\" را {$verb}";
            });
    }

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'content',
        'excerpt',
        'slug',
        'published',
        'published_at',
        'featured_image',
        'meta_title',
        'meta_description',
        'status',
        'views_count',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
    ];

    protected $attributes = [
        'views_count' => 0,
        'published' => true,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    // متد کمکی برای افزایش بازدید
    public function incrementViews()
    {
        $this->increment('views_count');
        return $this;
    }

    public function savers()
    {
        return $this->belongsToMany(User::class, 'saved_posts')->withTimestamps();
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_likes')->withTimestamps();
    }
}