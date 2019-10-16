<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restoran extends Model
{
    protected $table = 'restorani';
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function komentari(){
        return $this->hasMany('App\Komentar');
    }
    public function kategorije(){
        return $this->hasMany('App\Kategorija');
    }
    public function narudzbe(){
        return $this->hasMany('App\Narudzba');
    }
}
