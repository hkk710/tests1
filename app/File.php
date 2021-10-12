<?php

namespace App;

use Http;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'file_id', 'file_type', 'url', 'user_id', 'name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function setNameAttribute($name)
    {
        if ($name) return $this->attributes['name'] = $name;

        $key = config('app.google_api_key');
        $url = "https://www.googleapis.com/drive/v3/files/{$this->file_id}?key={$key}";
        $response = Http::get($url)->json();

        $this->attributes['name'] = $response['name'] ?? null;
    }

    public function getNameAttribute($name)
    {
        return $name ?? 'Private File';
    }
}
