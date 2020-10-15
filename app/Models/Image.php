<?php

namespace App;

use App\Events\ImageDeleting;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $dispatchesEvents = [
        'deleting' => ImageDeleting::class,
    ];

    protected $fillable = [
        'note'
    ];

    public function event()
    {
        return $this->morphOne(Event::class, 'event');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'event');
    }
}
