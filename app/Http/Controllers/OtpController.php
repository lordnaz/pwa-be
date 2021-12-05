<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Exceptions\ExceptionHandler as ErrHandler;

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

        $request = Http::withHeaders([
            'Content-Type' => 'application/json',
            'KEY' => $this->pub_key
        ])->post($this->url.'/api/mmpay/otpresponse', [
            'Token' => $token,
            'OTPReferenceNumber' => $req->OTPRefNo,
            'OTP' => $req->OTP,
        ]);

        return $request->json();
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
