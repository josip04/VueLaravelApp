<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Narudzba extends Model
{
    protected $table = 'narudzbe';
    public function restorani(){
        return $this->belongsTo('App\Restorani');
    }
}
