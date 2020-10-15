<?php

namespace App;

use Auth;
use Storage;
use Carbon\Carbon;
use Hootlex\Friendships\Status;
use Illuminate\Notifications\Notifiable;
use Hootlex\Friendships\Models\Friendship;
use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image', 'gender', 'phone', 'birthday', 'country_id', 'user_name', 'api_token', 'timezone', 'google2fa_secret', 'driver', 'ref_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token', 'google2fa_secret'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone(Auth::user()->timezone);
    }

    public function getPendingFriendsCount($groupSlug = '')
    {
        return $this->getFriendRequests(Status::PENDING, $groupSlug)->count();
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    public function shared()
    {
        return $this->hasMany(Share::class, 'share_id');
    }

    public function hasShared($id)
    {
        return $this->shared()->whereIn('event_id', [$id])->count() > 0;
    }

    public function settings()
    {
        return $this->hasMany(Setting::class);
    }

    public function getGoogle2faSecretAttribute($value)
    {
        return decrypt($value);
    }

    public function setGoogle2faSecretAttribute($value)
    {
         $this->attributes['google2fa_secret'] = encrypt($value);
    }

    public function loadImage($filename)
    {
        if ($this->driver === 'local')
            return Storage::disk('local')->get($filename);

        return redirect(
            Storage::disk($this->driver)
                ->temporaryUrl($filename, now()->addMinutes(5))
        );
    }
}
