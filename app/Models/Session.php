<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    //Relation to measurements for session
    public function measurements(){
        return $this->hasMany(Measurement::class);
    }
}
