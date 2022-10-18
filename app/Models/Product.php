<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{

    protected $fillable = [
        'id',
        'price'
    ];

    public function tables(){

        return $this->belongsToMany(Table::class,'products_tables');
    }
}