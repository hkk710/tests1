<?php

namespace App;

use App\Events\NoteDeleting;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $dispatchesEvents = [
        'deleting' => NoteDeleting::class,
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
