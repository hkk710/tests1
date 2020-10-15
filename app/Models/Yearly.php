<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Yearly extends Model
{
    public $nicename = 'yearly';

    protected $fillable = [
        'start_date', 'due_date', 'end_date'
    ];

    public function reminder()
    {
        return $this->morphOne(Reminder::class, 'reminder');
    }

    public function calculateNotifyAt($time)
    {
        $date = Carbon::parse("{$this->attributes['due_date']}-{$this->attributes['start_date']}")
            ->startOfDay()
            ->subtract($time->notification_unit, $time->notification_time);

        while ($date->lessThan(now())) $date->addYear();

        if ($date->greaterThan(Carbon::parse("{$this->attributes['due_date']}-{$this->attributes['end_date']}"))) return null;

        return $date->format('Y-m-d H:i');
    }

}
