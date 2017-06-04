<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    protected $fillable = [
        'name', 'price', 'description',
    ];

    public function orderPizzas() {
        return $this->hasMany(OrderPizza::class);
    }
}
