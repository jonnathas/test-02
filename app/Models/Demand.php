<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demand extends Model{

    protected $fillable = [
        'id',
        'table_id',
    ];
}