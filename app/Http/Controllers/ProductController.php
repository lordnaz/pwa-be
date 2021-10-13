<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Exceptions\ExceptionHandler as ErrHandler;

class ProductController extends Controller
{
    //

    protected $url;
    protected $port;

    function __construct() {
        $this->url = config('services.wps_svc.url');
        $this->port = config('services.wps_svc.port');
    }


    public function category(Request $req){

        $this->token = $req->auth_token;

        $request = Http::withToken($this->token)->get($this->url.':'.$this->port.'/category/list?countryCode=MY');

        if($request->successful()){

            $err_code = '000';
            $err_message = ErrHandler::getResponseDesc($err_code);

            $data = [ 
                'status' => 'success',
                'responseCode' => $err_code,
                'responseDescription' => $err_message,
                'data' => $request['attributes']['CategoryList']
            ];

        }

        return response()->json($data);

    }

    public function countries(Request $req){

        $this->token = $req->auth_token;

        $request = Http::withToken($this->token)->get($this->url.':'.$this->port.'/country/list');

        if($request->successful()){

            $err_code = '000';
            $err_message = ErrHandler::getResponseDesc($err_code);

            $data = [ 
                'status' => 'success',
                'responseCode' => $err_code,
                'responseDescription' => $err_message,
                'data' => $request['attributes']['countryList']
            ];

        }
        
        return response()->json($data);
    }

}
