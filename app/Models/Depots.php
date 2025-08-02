<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Depots extends Model
{
    protected $fillable = [
        'user_id',
        'amounts',
        'currency',
        'number',
        'country',
        'verify',
        'status',
        'description',
        'transaction_id',
        'country_code'
    ];

    public function users() : BelongsTo {
        return $this->belongsto(User::class, 'user_id', 'id');
    }

}
