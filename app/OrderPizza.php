<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPizza extends Model
{
    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function pizza() {
        return $this->belongsTo(Pizza::class);
    }
}
