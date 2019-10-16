<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restoran;
use App\Http\Requests;
use App\Http\Resources\Restorani as RestoraniResource; 
use App\Http\Requests\RestoranRequest;
use Validator;
use File;
use Illuminate\Support\Facades\Storage;

class RestoranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restorani = Restoran::all();
        return response()->json((RestoraniResource::collection($restorani)));
        /*
        https://laravel.com/docs/5.8/eloquent-resources
        return view('layouts.app');
        return  view('restorani.index')->with('restorani',$restorani);
        */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RestoranRequest $request)
    {
       
        $restoran = new Restoran;

        /*
        $slikaBase64 = $request->slikaBase64; 
        $slika_naziv = $request->slika;
        Storage::disk('public')->put($slika_naziv, base64_decode($slikaBase64));
        $slika_url = Storage::url($slika_naziv);
        */


        /* radi i ovako bez odvajanja u Requests file , radi "cleaner code"
        $validator = Validator::make($request->all(), [
            'naziv' => 'required|unique:restorani,naziv|max:45'
        ])->validate();*/
        
        $restoran->naziv = $request->input('naziv');
        $restoran->opis = $request->input('opis');
        $restoran->cijenaDst = $request->input('cijenaDst');
        $restoran->minNar = $request->input('minNar');
        $restoran->kontakt = $request->input('kontakt');
        $restoran->adresa = $request->input('adresa');
        //$restoran->slika_url = $request->input('slika_url');
        $restoran->user_id = $request->input('user_id');
       // Storage::disk('public')->put($request->input('naziv'), base64_decode($request->slika));

        $exploded = explode(',',$request->slika);
        $decoded = base64_decode($exploded[1]);

        if(str_contains($exploded[0],'jpeg')){
            $extension = 'jpeg';
        }else{
            $extension = 'png';
        }

        $slika_naziv = str_random().'.'.$extension;
        $path = public_path() . '/' . $slika_naziv;
        file_put_contents($path,$decoded);
        $restoran->slika_url = $slika_naziv;
        

        /*if($request->hasFile('slika')){
            $slika = $request->file('slika');
            $slika_naziv = rand() . '.' . $slika->getClientOriginalExtension();
            //$request->file('slika')->move(public_path("/slike"), $slika_naziv);
            Storage::disk('public')->put($slika_naziv,  File::get($slika));
            $restoran->slika_url = $slika_naziv;
        }*/
        
        if($restoran->save()){
            return response()->json($restoran);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $restoran = Restoran::findOrFail($id);

        return response()->json($restoran);
        /*return [ // ne mogu primjenit RestoraniResource za vraćanje json podataka jer ovdje baza vraća jedan zapis a ne cijeli array , javlja grešku ako pokušam
            "naziv" => $restoran->naziv,
            "opis" => $restoran->opis,
            "cijenaDst" => $restoran->cijenaDst,
            "minNar" =>  $restoran->minNar

        ];*/ // ili vratiti sve podatke o restoranu sa return $restoran
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RestoranRequest $request, $id)
    {
        $restoran = Restoran::find($id);
        

        $restoran->naziv = $request->input('naziv');
        $restoran->opis = $request->input('opis');
        $restoran->cijenaDst = $request->input('cijenaDst');
        $restoran->minNar = $request->input('minNar');
        $restoran->kontakt = $request->input('kontakt');
        $restoran->adresa = $request->input('adresa');


        $exploded = explode(',',$request->slika);
        $decoded = base64_decode($exploded[1]);

        $path = public_path() . '/' . $restoran->slika_url;//slika_url = naziv slike
        if(file_exists($path)){
            File::delete($path);
        }
        $extension = $this->getExtension($exploded[0]);
        

        $slika_naziv = str_random().'.'.$extension;
        $path = public_path() . '/' . $slika_naziv;
        file_put_contents($path,$decoded);
        $restoran->slika_url = $slika_naziv;


        if($restoran->save()){
            return response()->json($restoran);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $restoran = Restoran::findOrFail($id);
        
        if($restoran->delete()) {
            $path = public_path() . '/' . $restoran->slika_url;//slika_url = naziv slike
            if(file_exists($path)){
                File::delete($path);
            }
            return response()->json($restoran);
        }
    }

    public function getExtension($string){
        if(str_contains($string,'jpeg')){
            $string = 'jpeg';
        }else{
            $string = 'png';
        }
        return $string;
    }
}
