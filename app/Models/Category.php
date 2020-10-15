<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'nicename'
    ];

    public $timestamps = false;

    public function event()
    {
        return $this->hasMany(Event::class);
    }
}
