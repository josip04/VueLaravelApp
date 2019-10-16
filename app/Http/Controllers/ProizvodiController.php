<?php

namespace App\Http\Controllers;
use App\Proizvodi;
use Illuminate\Http\Request;

class ProizvodiController extends Controller
{
    public function index(Request $request){
        $proizvodi = Proizvodi::all();
        return response()->json($proizvodi);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proizvod = new Proizvodi;
        $proizvod->proizvod_naziv = $request->input('proizvod_naziv');
        $proizvod->cijena = $request->input('cijena');
        $proizvod->kategorija_id = $request->input('kategorija_id');
        $proizvod->restoran_id = $request->input('restoran_id');

        if($proizvod->save()){
            $proizvodi = Proizvodi::where('kategorija_id',$proizvod->kategorija_id)->get();
            return response()->json($proizvodi);
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
        $proizvodi = Proizvodi::where('kategorija_id',$id)->get();
        return response()->json($proizvodi);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proizvod = Proizvodi::findOrFail($id);
        $kategorija_id = $proizvod->kategorija_id;
        if($proizvod->delete()){
            $proizvodi = Proizvodi::where('kategorija_id',$kategorija_id)->get();
            return response()->json($proizvodi);
        }
    }
}
