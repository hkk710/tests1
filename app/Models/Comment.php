<?php

namespace App;

use Auth;
use Carbon\Carbon;
use App\Notifications\YouWereMentioned;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'comment', 'commentable_id', 'commentable_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->morphTo('commentable');
    }

    public function replies()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function hasReplies()
    {
        return $this->getRepliesCount() > 0;
    }

    public function getRepliesCount()
    {
        return $this->replies()->count();
    }

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->setTimezone(Auth::user()->timezone);
    }

    public function getCommentAttribute($value)
    {
        return preg_replace_callback('/@([\w\-]+)/', function ($regex) {
            $user = $this->getEvent()->subscribers()->firstWhere('user_name', $regex[1]);

            if ($user) {
                $url = route('users.profile', $user->id);
                return "<a href=\"{$url}\" class=\"no-underline text-blue\">{$regex[0]}</a>";
            }

            return $regex[0];
        }, e($value));
    }

    protected function getEvent()
    {
        if ($this->isReply())
            return $this->event->event;

        return $this->event;
    }

    protected function isReply()
    {
        return $this->commentable_type === Comment::class;
    }

    public function notifyMentionedUsers($comment)
    {
        preg_match_all('/@([\w\-]+)/', $comment, $matches);

        foreach ($matches[1] as $user_name) {
            $user = $this->getEvent()
                ->subscribers()
                ->whereNotIn('id', [Auth::id()])
                ->firstWhere('user_name', $user_name);

            if ($user)
                $user->notify(new YouWereMentioned(Auth::user(), $this->getEvent()->id));
        }
    }
}
