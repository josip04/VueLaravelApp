<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRegRequest;
use App\Http\Requests\AuthLoginRequest;
use App\User;
use Validator;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registracija(AuthRegRequest $request){
        $korisnik = new User;
        $http = new Client;

        $korisnik->name=$request->name;
        $korisnik->password=bcrypt($request->password);
        $korisnik->email=$request->email;
        if($korisnik->save()){
            $response = $http->post('http://localhost:8000/aplikacija/public/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => '2',
                    'client_secret' => '0HncwIHlkRzyYggYCc2zF7Z0aXCaWoQbdRVVZkEl',
                    'username' => $request->email,
                    'password' => $request->password,
                    'scope' => '',
                    ],
        ]);
            return response(json_decode((string) $response->getBody(), true));
        }
    }

    public function prijava(AuthLoginRequest $request){
        $http = new Client;

        $korisnik = User::query()->where('email', $request->email)->first();
        if($korisnik && (Hash::check($request->password, $korisnik->password))){
            $response = $http->post('http://localhost:8000/aplikacija/public/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => '0HncwIHlkRzyYggYCc2zF7Z0aXCaWoQbdRVVZkEl',
                'username' => $korisnik->email,
                'password' => $request->password,
                'scope' => '',
                ],
            ]);
            return response([
                'token' => json_decode((string) $response->getBody(), true),
                'korisnik' => $korisnik
            ]); 

        }else{
            return response()->json(['poruka' => 'Korisnik ne postoji!']);
        }
    }

}
