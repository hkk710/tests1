<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    protected $fillable = [
        'brand', 'size', 'quantity', 'item', 'store',
    ];

    public function shopping()
    {
        return $this->belongsTo(Shopping::class);
    }
}
