<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Once extends Model
{
    public $nicename = 'once';

    protected $fillable = [
        'due_date', 'due_time',
    ];

    public function reminder()
    {
        return $this->morphOne(Reminder::class, 'reminder');
    }

    public function getDueDateAttribute($date)
    {
        return Carbon::parse($date . ' ' . $this->attributes['due_time'])
            ->setTimezone(Auth::user()->timezone)
            ->format('d-m-Y');
    }

    public function getDueTimeAttribute($time)
    {
        return Carbon::parse($time)
                ->setTimezone(Auth::user()->timezone ?? 'UTC')
                ->format('h:i a');
    }

    public function setDueTimeAttribute($time)
    {
        $dateTime = Carbon::parse(
            $this->attributes['due_date'] . ' ' . $time, Auth::user()->timezone
        )->setTimezone('UTC');

        $this->attributes['due_time'] = $dateTime->format('H:i:s');
        $this->attributes['due_date'] = $dateTime->format('Y-m-d');
    }

    public function calculateNotifyAt($time)
    {
        return Carbon::parse("{$this->attributes['due_date']} {$this->attributes['due_time']}")
            ->subtract($time->notification_unit, $time->notification_time)
            ->format('Y-m-d H:i');
    }
}
