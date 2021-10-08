<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
    ];

    public function files()
    {
        return $this->belongsToMany(File::class);
    }
}
