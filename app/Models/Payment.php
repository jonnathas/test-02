<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model{

    protected $fillable = [
        'id',
        'subtotal',
        'quota',
        'method',
    ];

    public function tables(){

        return $this->belongsToMany(Table::class,'products_tables');
    }
}