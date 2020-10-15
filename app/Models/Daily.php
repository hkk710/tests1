<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    public $nicename = 'daily';

    protected $fillable = [
        'start_date', 'due_time', 'end_date'
    ];

    public function reminder()
    {
        return $this->morphOne(Reminder::class, 'reminder');
    }

    public function getDueTimeAttribute($time)
    {
        return Carbon::parse($time)
                ->setTimezone(Auth::user()->timezone ?? 'UTC')
                ->format('h:i a');
    }

    public function setDueTimeAttribute($time)
    {
        $this->attributes['due_time'] = Carbon::parse(
            $time, Auth::user()->timezone
        )->setTimezone('UTC')->format('H:i:s');
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
        $date = Carbon::parse("{$this->attributes['start_date']} {$this->attributes['due_time']}")
            ->subtract($time->notification_unit, $time->notification_time);

        while ($date->lessThan(now())) $date->addDay();

        if ($date->greaterThan(Carbon::parse("{$this->attributes['end_date']} {$this->attributes['due_time']}"))) return null;

        return $date->format('Y-m-d H:i');
    }

}
