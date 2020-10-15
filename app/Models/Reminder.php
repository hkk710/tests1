<?php

namespace App;

use App\Events\ReminderDeleting;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $dispatchesEvents = [
        'deleting' => ReminderDeleting::class,
    ];

    protected $fillable = [
        'note', 'reminder_id', 'reminder_type', 'type'
    ];

    public function event()
    {
        return $this->morphOne(Event::class, 'event');
    }

    public function reminder()
    {
        return $this->morphTo();
    }

    public function notification()
    {
        return $this->morphOne(NotificationSetting::class, 'event');
    }

    public function calculateNotifyAt($time)
    {
        return $this->reminder->calculateNotifyAt($time);
    }

}
