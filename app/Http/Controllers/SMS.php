<?php

namespace App\Http\Controllers;

class SMS extends Controller
{
    public static function send($message,$to,$sender_id,$api)
    {

        $apiKey = urlencode($api);
            
        $sender = urlencode($sender_id);
        $message = rawurlencode($message);
        
        // Prepare data for POST request
            // $data = array('apikey' => $apiKey, 'numbers' => $to, "sender" => $sender, "message" => $message);
        // Send the POST request with cURL
            // $ch = curl_init('https://api.textlocal.in/send/');
            // curl_setopt($ch, CURLOPT_POST, true);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $response = curl_exec($ch);
            // curl_close($ch);
            
            // Process your response here
           // echo $response;
    }

    public static function getBalance($api)
    {

            // Account details
            $apiKey = urlencode($api);
         
            // Prepare data for POST request
            $data = array('apikey' => $apiKey);
         
            // Send the POST request with cURL
            $ch = curl_init('https://api.textlocal.in/balance/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($ch));
            curl_close($ch);
            

            // Process your response here
           // return $response->balance->sms;
           // return 100;
       
    }

    public static function get_status($code,$to)
    {
        switch($code)
        {
            case '101': $status = ['status'=>0, 'response'=>"Invalid username/password"]; break;
            case '102': $status = ['status'=>0, 'response'=>"Sender not exist"]; break;
            case '103': $status = ['status'=>0, 'response'=>"Receiver not exist"]; break;
            case '104': $status = ['status'=>0, 'response'=>"Invalid route (PA,TA,SA & I)"]; break;
            case '105': $status = ['status'=>0, 'response'=>"Invalid message type"]; break;
            case '106': $status = ['status'=>0, 'response'=>"SMS content not exist"]; break;
            case '107': $status = ['status'=>0, 'response'=>"Transaction template mismatch"]; break;
            case '108': $status = ['status'=>0, 'response'=>"Low credits in the specified route"]; break;
            case '109': $status = ['status'=>0, 'response'=>"Account is not eligible for API"]; break;
            case '110': $status = ['status'=>0, 'response'=>"Promotional route will be working from 9am to 9pm only"]; break;
            default : $status = ['status'=>1, 'response'=>"SMS sent to $to"]; break;
        }
        return $status;
    }
}
