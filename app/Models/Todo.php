<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    public function event()
    {
        return $this->morphOne(Event::class, 'event');
    }

    public function items()
    {
        return $this->hasMany(TodoList::class);
    }
}
