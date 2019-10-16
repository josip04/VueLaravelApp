<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Restorani extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return[
            'id' => $this->id,
            'naziv' => $this->naziv,
            'opis' => $this->opis,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'cijenaDst' => $this->cijenaDst,
            'minNar' => $this->minNar,
            'adresa' => $this->adresa,
            'kontakt' => $this->kontakt,
            //'slika' => $this->slika,
            'user_id' => $this->user_id,
            'slika_url' => $this->slika_url
            /*'links' => [ //test
                'LaravelApp' => 'http://localhost:8000/aplikacija/public/',
            ],*/
        ];
    }
}
