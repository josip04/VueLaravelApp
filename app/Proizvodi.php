<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proizvodi extends Model
{
    protected $table = 'proizvodi';
    public function kategorije(){
        return $this->belongsTo('App\Kategorija');
    }

    
}
