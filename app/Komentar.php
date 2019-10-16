<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'komentari';
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function restorani(){
        return $this->belongsTo('App\Restorani');
    }
}
