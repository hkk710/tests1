<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $fillable = [
        'thumbnail', 'description', 'uploaded_on', 'page', 'url'
    ];

    protected $casts = [
        'uploaded_on' => 'date'
    ];
}
