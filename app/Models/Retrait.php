<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retrait extends Model
{
    protected $fillable = [
        'user_id',
        'amounts',
        'currency',
        'number',
        'methods',
        'status',
        'description',
        'transaction_id',
        'country_code'
    ];
}
