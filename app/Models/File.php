<?php

namespace App;

use Storage;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'event_id', 'event_type', 'location', 'size', 'user_id', 'driver', 'original_name',
    ];

    public function event()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getExtension()
    {
        $name = explode('.', $this->location);

        return $name[count($name) - 1];
    }

    public function loadFile($filename, $time = 5)
    {
        if ($this->driver === 'local')
            return Storage::disk('local')->get($filename);

        return redirect(
            Storage::disk($this->driver)
                ->temporaryUrl($filename, now()->addMinutes($time))
        );
    }
}
