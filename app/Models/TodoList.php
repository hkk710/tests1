<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    protected $fillable = [
        'start_date', 'end_date', 'task', 'description', 'status'
    ];

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }

    public function getStartDateAttribute($date)
    {
        return Carbon::parse($date)->format('d-m-Y');
    }

    public function getEndDateAttribute($date)
    {
        return Carbon::parse($date)->format('d-m-Y');
    }
}
