<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Apicall
{

    public function apirequest($post_array)
    {

        $headers = ['Authorization: Basic YWRtaW46YWRtaW4=', 'salt: 6a4327662ac77daa69be9d443d6fe9c283cce581']; 
        $post_data=http_build_query($post_array); 
        
        $curl=curl_init();

        curl_setopt_array($curl, array( 
            CURLOPT_URL=> "https://gpay.nakroteck.biz/apiv2/api.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $post_array,
            CURLOPT_HTTPHEADER => $headers,
            ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
         return $response;
        }
    }




    public function merchantApi($endpoint){
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://mct.nakroteck.biz/api/{$endpoint}",
        //CURLOPT_URL => "http://localhost/RICKY/merchant/api/{$endpoint}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "token: fa46994d247ef1472708c1271cff4599"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }


    public function OtpPushNotifiction($otp,$phoneNum,$message){
      
        //$_SESSION['auth']['otp'] = $otp;
      
        $data = [
                  "action"     => "OTP-PUSH",
                  "phoneNum"   =>  $phoneNum,
                  "message"    =>  $message
                ];
      
        $response = $this->apirequest($data);
      
    }




}