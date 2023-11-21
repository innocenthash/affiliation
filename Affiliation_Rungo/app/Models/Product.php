<?php

namespace App\Models;

use App\Models\LienOffre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    public function lien_offres(){
        return $this->hasMany(LienOffre::class);
    }
}
