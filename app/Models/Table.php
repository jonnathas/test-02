<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model{

    protected $table = 'tables';

    protected $fillable = [
        'id',
        'number',
        'closed_at'
    ];

    public function products(){

        return $this->belongsToMany(Product::class, 'products_tables');
    }

    public function payments(){

        return $this->hasMany(Payment::class, 'table_id','id');
    }
}