<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;
use Modules\Post\Models\Post;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'role'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(function (string $eventName) {
                $verb = match ($eventName) {
                    'created' => 'ایجاد کرد',
                    'updated' => 'بروزرسانی کرد',
                    'deleted' => 'حذف کرد',
                    default => $eventName,
                };
                return "کاربر \"{$this->name}\" را {$verb}";
            });
    }

    protected $fillable = [
        'name',
        'nickname',
        'email',
        'password',
        'phone',
        'work_field',
        'avatar',
        'email_verified_at',
        'last_login_at',
        'status',
        'role',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => 'string',
    ];

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function getAvatarAttribute($value)
    {
        if ($value) {
            return asset('storage/avatars/' . $value);
        }

        $initials = collect(explode(' ', $this->name))
            ->map(fn($word) => mb_substr($word, 0, 1))
            ->take(2)
            ->join('');

        return 'https://ui-avatars.com/api/?name=' . urlencode($initials) . '&background=6366f1&color=ffffff&size=200';
    }

    public function getMembershipDaysAttribute()
    {
        return $this->created_at->diffInDays(now());
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function savedPosts()
    {
        return $this->belongsToMany(Post::class, 'saved_posts')->withTimestamps();
    }
}
