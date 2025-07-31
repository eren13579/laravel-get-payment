<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaysAfricain extends Model
{
    use HasFactory;

    protected $table = 'pays_africains';

    protected $appends = ['name', 'indicatif', 'devide_id'];

        public function currency()
    {
        return $this->belongsTo(DevisesAfricains::class, 'devise_id');
    }
}
