<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upcoming extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'status', 'event', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
