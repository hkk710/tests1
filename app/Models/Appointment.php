<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'name', 'event_date', 'event_time', 'phone', 'organization', 'address1', 'address2', 'city', 'state', 'code', 'country_id', 'email', 'website'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function event()
    {
        return $this->morphOne(Event::class, 'event');
    }

    public function notification()
    {
        return $this->morphOne(NotificationSetting::class, 'event');
    }

    public function getEventDateAttribute($date)
    {
        return Carbon::parse($date . ' ' . $this->attributes['event_time'])
            ->setTimezone(Auth::user()->timezone)
            ->format('d-m-Y');
    }

    public function getEventTimeAttribute($time)
    {
        return Carbon::parse($time)
                ->setTimezone(Auth::user()->timezone)
                ->format('h:i a');
    }

    public function setEventTimeAttribute($time)
    {
        $dateTime = Carbon::parse(
            $this->attributes['event_date'] . ' ' . $time, Auth::user()->timezone
        )->setTimezone('UTC');

        $this->attributes['event_time'] = $dateTime->format('H:i:s');
        $this->attributes['event_date'] = $dateTime->format('Y-m-d');
    }

    public function calculateNotifyAt($time)
    {
        return Carbon::parse("{$this->attributes['event_date']} {$this->attributes['event_time']}")
            ->subtract($time->notification_unit, $time->notification_time)
            ->format('Y-m-d H:i');
    }
}
