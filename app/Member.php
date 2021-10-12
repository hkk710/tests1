<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
          'image', 'name', 'position', 'qualification', 'our_organization_description', 'user_id', 'priority', 'type'
    ];
}
