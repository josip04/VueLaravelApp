<?php

namespace App\Http\Controllers;
use App\Kategorija;
use Illuminate\Http\Request;

class KategorijeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kategorija = new Kategorija;

        $kategorija->kategorija_naziv = $request->input('kategorija_naziv');
        $kategorija->restoran_id = $request->input('restoran_id');

        if($kategorija->save()){
            $kategorije = Kategorija::where('restoran_id',$kategorija->restoran_id)->get();
            return response()->json($kategorije);
        }else{
            response()->json([
                'Greška' => 'Nešto nije u redu!'
            ]);
        }
    }
    public function show($id)
    {
        $kategorije = Kategorija::where('restoran_id',$id)->get();
        return response()->json($kategorije);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $kategorija = new Kategorija;
        $kategorija = Kategorija::findOrFail($id);
        if($kategorija->delete()){
            $restoran_id = $request['restoran_id'];
            $kategorije = Kategorija::where('restoran_id',$restoran_id)->get();//kad se izbriše kategorija ili doda , mora se prosljedit id resotrana tako da se vrate samo one kategorije koje pripadaju tom restoranu
            //$kategorije = Kategorija::all();
            return response()->json($kategorije);
        }
    }
}
