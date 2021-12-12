<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Exceptions\ExceptionHandler as ErrHandler;

use App\Models\Transaction;

class OtpController extends Controller
{
    //

    protected $url;
    protected $pub_key;
    protected $priv_key;

    function __construct() {
        $this->url = config('services.otp_svc.url');
        $this->pub_key = config('services.otp_svc.pub_key');
        $this->priv_key = config('services.otp_svc.priv_key');
    }

    public function get_token(){

        $request = Http::withHeaders([
            'Content-Type' => 'application/json',
            'KEY' => $this->pub_key
        ])->post($this->url.'/api/mmpay/token', [
            'pass' => $this->priv_key,
        ]);

        return $request->object();
    }

    public function get_otp(Request $req){

        $tokenObj = $this->get_token();
        $token = $tokenObj->Token;
        
        $request = Http::withHeaders([
            'Content-Type' => 'application/json',
            'KEY' => $this->pub_key
        ])->post($this->url.'/api/mmpay/pay', [
            'Token' => $token,
            'MobileNumber' => $req->PhoneNum,
            'Amount' => $req->Amount,
            'TransactionNumber' => $req->TrxNo,
        ]);

        return $request->json();

        // will return OTPRefNo, URN, Code and Message 
        // OTPRefNo must be hold by the frontend session to trigger validateOTP 
    }

    public function validate_otp(Request $req){

        $tokenObj = $this->get_token();
        $token = $tokenObj->Token;

        $currentdt = date('Y-m-d H:i:s');

        $datetime = date('YmdHis');
        $unique_id = uniqid();

        $trx_id = strtoupper($unique_id)."_".$datetime;

        $request = Http::withHeaders([
            'Content-Type' => 'application/json',
            'KEY' => $this->pub_key
        ])->post($this->url.'/api/mmpay/otpresponse', [
            'Token' => $token,
            'OTPReferenceNumber' => $req->OTPRefNo,
            'OTP' => $req->OTP,
        ]);

        if($request['Code'] == "000"){

            $data = [ 
                'status' => $request['Message'],
                'Code' => $request['Code'],
                'TransactionId' => $request['TransactionId'],
                'Internal_TrxId' => $trx_id
            ];

            // type of status (failed/success transaction stored in DB)
            // 1 - SUCCESS
            // 2 - FAILED
            
            $create_trx = Transaction::create([
                'internal_trx' => $trx_id,
                'mmp_trx' => $request['TransactionId'],
                'status' => "SUCCESS",
                'code' => $request['Code'],
                'message' => $request['Message'],
                'created_at' => $currentdt,
                'updated_at' => $currentdt
            ]);

        }else{

            $data = [ 
                'status' => $request['Message'],
                'Code' => $request['Code'],
                'TransactionId' => $request['TransactionId']
            ];

            $create_trx = Transaction::create([
                'internal_trx' => $trx_id,
                'mmp_trx' => $request['TransactionId'],
                'status' => "FAILED",
                'code' => $request['Code'],
                'message' => $request['Message'],
                'created_at' => $currentdt,
                'updated_at' => $currentdt
            ]);
        }

        return response()->json($data);
        // return $request->json();
    }

    public function pay_status(Request $req){

        $tokenObj = $this->get_token();
        $token = $tokenObj->Token;

        $request = Http::withHeaders([
            'Content-Type' => 'application/json',
            'KEY' => $this->pub_key
        ])->post($this->url.'/api/mmpay/paystatus', [
            'Token' => $token,
            'TransactionNumber' => $req->TrxNo,
        ]);

        return $request->json();
    }

    public function resend_otp(Request $req){

        $tokenObj = $this->get_token();
        $token = $tokenObj->Token;

        $request = Http::withHeaders([
            'Content-Type' => 'application/json',
            'KEY' => $this->pub_key
        ])->post($this->url.'/api/mmpay/otpresend', [
            'Token' => $token,
            'OTPReferenceNumber' => $req->OTPRefNo,
        ]);

        return $request->json();

    }
}
