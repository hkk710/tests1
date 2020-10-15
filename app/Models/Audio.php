<?php

namespace App;

use App\Events\AudioDeleting;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    protected $dispatchesEvents = [
        'deleting' => AudioDeleting::class,
    ];

    protected $fillable = [
        'note'
    ];

    public function event()
    {
        return $this->morphOne(Event::class, 'event');
    }

    public function file()
    {
        return $this->morphOne(File::class, 'event');
    }
}
