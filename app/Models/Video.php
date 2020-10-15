<?php

namespace App;

use App\Events\VideoDeleting;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $dispatchesEvents = [
        'deleting' => VideoDeleting::class,
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
