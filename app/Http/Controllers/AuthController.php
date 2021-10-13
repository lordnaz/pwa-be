<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Exceptions\ExceptionHandler as ErrHandler;

// use App\Models\User;

class AuthController extends Controller
{
    //
    protected $url;
    protected $port;

    function __construct() {
        $this->url = config('services.wps_svc.url');
        $this->port = config('services.wps_svc.port');
    }

    public function login(Request $req){

        $request = Http::post($this->url.':'.$this->port.'/auth', [
            'username' => 'mtraderetail',
            'password' => 'retail@mtrade',
        ]);

        if($request->successful()){

            $token = $request->header('Authorization');

            $err_code = '001';
            $err_message = ErrHandler::getResponseDesc($err_code);

            $data = [ 
                'status' => 'success',
                'responseCode' => $err_code,
                'responseDescription' => $err_message,
                'authToken' => $token
            ];

        }

        return response()->json($data);

    }

}
