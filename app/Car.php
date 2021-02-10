<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public function type(){
        return $this->belongsTo(TypeCar::class);
    }
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function owner(){
        return $this->belongsTo(Owner::class);
    }
}
