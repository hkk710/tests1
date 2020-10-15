<?php

namespace App;

use App\Collections\SettingCollection;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	protected $fillable = [
		'key', 'value', 'user_id'
	];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function newCollection(array $models = Array())
    {
        return new SettingCollection($models);
    }
}
