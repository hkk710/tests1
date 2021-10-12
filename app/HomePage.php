<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'bg', 'main_link', 'sub_link', 'main_link_text', 'sub_link_text', 'active', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
