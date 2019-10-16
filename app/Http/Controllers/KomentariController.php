<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Komentar;
use App\Http\Requests;
use App\Http\Requests\KomentarRequest;

class KomentariController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($restoran_id)
    {
        $komentari = Komentar::query()->where('restoran_id', $restoran_id)->with('user')->get();
        if(count($komentari)>0){
            return response()->json($komentari);
        }
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
    public function store(KomentarRequest $request)
    {
        $komentar = new Komentar;
        $komentar->komentar = $request->input('komentar');
        $komentar->ocijena = $request->input('ocijena');
        $komentar->restoran_id = $request->input('restoran_id');
        $komentar->user_id = $request->input('user_id');
        //$komentar->user_id = Auth::user()->id ; 

        if($komentar->save()){
            return response()->json($komentar);
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($restoran_id,$kom_id)
    {
        //ne treba za Vue
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KomentarRequest $request,$restoran_id,$kom_id)
    {
        $komentar = Komentar::find($kom_id);
        $komentar->komentar = $request->input('komentar');

        if($komentar->save()) {
            $komentari = Komentar::where('restoran_id',$restoran_id)->with('user')->get();
            return response()->json($komentari);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$restoran_id,$kom_id)
    {
        $komentar = Komentar::findOrFail($kom_id);
        if($komentar->delete()){
            $komentari = Komentar::where('restoran_id',$restoran_id)->get();
            return response()->json($komentari);
        };
    }
}
