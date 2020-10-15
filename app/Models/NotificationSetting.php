<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $fillable = [
        'event_id', 'event_type', 'time', 'unit', 'priority', 'notify_at', 'repeating', 'enabled', 'notification_class'
    ];

    public function event()
    {
        return $this->morphTo();
    }

    // aliasing notification_unit to unit
    public function getNotificationUnitAttribute()
    {
        return $this->unit;
    }

    // aliasing notification_time to time
    public function getNotificationTimeAttribute()
    {
        return $this->time;
    }

}
