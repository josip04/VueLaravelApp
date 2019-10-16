<?php

namespace App\Http\Controllers;
use App\Narudzba;
use Illuminate\Http\Request;

class NarudzbeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $narudzba = new Narudzba;
        $narudzba->narudzba = $request->input('narudzba');
        $narudzba->iznos = $request->input('iznos');
        $narudzba->user_email = $request->input('user_email');
        $narudzba->adresa = $request->input('adresa');
        $narudzba->kontakt = $request->input('kontakt');
        $narudzba->status = $request->input('status');
        $narudzba->restoran_id = $request->input('restoran_id');

        if($narudzba->save()){
            return response()->json([
                'poruka' => 'Vaša je narudžba uspješno zaprimljena.'
            ]);
        }else{
            return response()->json([
                'poruka' => 'Ops , nismo mogli zaprimiti vašu narudžbu.'
            ]);
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
        $narudzbe = Narudzba::where('restoran_id',$id)->get();
        return response()->json($narudzbe);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $narudzba = Narudzba::find($id);
        $narudzba->status = $request->input('status');
        $restoran_id = $request->input('restoran_id');
        if($narudzba->save()){
            $narudzbe = Narudzba::where('restoran_id',$restoran_id)->get();
            return response()->json($narudzbe);
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
        //
    }
}
