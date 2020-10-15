<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Weekly extends Model
{
    public $nicename = 'weekly';

    protected $fillable = [
        'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'start_date', 'end_date'
    ];

    public function reminder()
    {
        return $this->morphOne(Reminder::class, 'reminder');
    }

    public function getStartDateAttribute($date)
    {
        return Carbon::parse($date)->format('d-m-Y');
    }

    public function getEndDateAttribute($date)
    {
        return Carbon::parse($date)->format('d-m-Y');
    }

    public function calculateNotifyAt($time)
    {
        $date = Carbon::parse($this->attributes['start_date'])
            ->startOfDay()
            ->subtract($time->notification_unit, $time->notification_time);

        while ($date->lessThan(now()) || !$this->attributes[strtolower($date->format('l'))]) $date->addDay();

        if ($date->greaterThan(Carbon::parse($this->attributes['end_date']))) return null;

        return $date->format('Y-m-d H:i');
    }
}
