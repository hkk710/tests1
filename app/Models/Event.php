<?php

namespace App;

use Auth;
use Carbon\Carbon;
use App\Events\EventDeleting;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $dispatchesEvents = [
        'deleting' => EventDeleting::class,
    ];

    protected $fillable = [
        'user_id', 'title', 'category_id', 'event_id', 'event_type',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->morphTo();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone(Auth::user()->timezone);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getCommentsCount()
    {
        return $this->comments()->count();
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    public function subscribers()
    {
        return $this->shares
            ->map->share
            ->push($this->user);
    }

    public function hasFiles()
    {
        return ($this->event->files && $this->event->files()->count()) || $this->event->file;
    }
}
