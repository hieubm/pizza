<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name', 'customer_address', 'customer_phone', 'note',
    ];

    public function orderPizzas() {
        return $this->hasMany(OrderPizza::class);
    }
}
