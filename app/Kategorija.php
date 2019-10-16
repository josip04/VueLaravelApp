<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategorija extends Model
{
    protected $table = 'kategorije';
    public function restorani(){
        return $this->belongsTo('App\Restorani');
    }
    public function proizvodi(){
        return $this->hasMany('App\Proizvodi');
    }
}
