<?php

namespace App\Exceptions;

use Exception;

class ExceptionHandler extends Exception
{
    public static function getResponseDesc($err_code) {

        switch ($err_code) {
            case "000" : $result = "Transaction successful"; break;
            case "001" : $result = "Transaction Accepted and still Pending"; break;
            case "101" : $result = "Invalid syntax"; break;
            case "200" : $result = "Invalid operation"; break;
            case "201" : $result = "Connection to Operator fail"; break;
            case "202" : $result = "Operator Response with invalid request"; break;
            case "203" : $result = "Operator Response with error"; break;
            case "204" : $result = "Unknown Response from Operator"; break;
            case "205" : $result = "Invalid operator"; break;
            case "206" : $result = "System Internal Error"; break;
            case "207" : $result = "Invalid Username or Password"; break;
            case "208" : $result = "Customer Transaction Id missing"; break;
            case "209" : $result = "Internal system Error. Exception error"; break;
            case "210" : $result = "Insufficient SP balance"; break;
            case "211" : $result = "Invalid Number or Invalid Number format"; break;
            case "212" : $result = "Customer has insufficient balance"; break;
            case "213" : $result = "Error in sending request to Request Handler"; break;
            case "214" : $result = "No service provider available"; break;
            case "215" : $result = "No selling currency and rate found"; break;
            case "216" : $result = "Invalid selling price"; break;
            case "217" : $result = "Customer rate plan missing"; break;
            case "218" : $result = "Invalid customer margin type"; break;
            case "219" : $result = "Product Code Missing"; break;
            case "220" : $result = "Invalid Authentication Token"; break;
            case "221" : $result = "Amount wrong or Invalid"; break;
            case "222" : $result = "Receiver Reach limit"; break;
            case "223" : $result = "Sender Reach Limit"; break;
            case "224" : $result = "Invalid signature"; break;
            case "999" : $result = "Refund"; break;
            default  : $result = "Unable to be determined error code"; 
        }
        return $result;
    }
}
