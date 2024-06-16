<?php

namespace App\Helpers;


class sms
{
    private $api;

    private $token;



    public function cURL($body = [])
    {
        if (!is_array($body)) {
            die("Body rquire array");
        }
        $postfield =  "key=" . $body['key'] . "&secret=" . $body['secret'];
        $postfield .= array_key_exists('token', $body) && array_key_exists('pin', $body) ? "&token=" . $body['token'] . "&pin=" . $body['pin'] : "&msisdn=" . $body['tel'];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $body['url'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>  $postfield,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "content-type: application/x-www-form-urlencoded"
            ],
        ]);

        $response = curl_exec($curl);
        $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        $resData = json_decode($response);

        $res = (object)[
            'httpStatusCode' => $httpStatusCode,
            'error' => null,
            'success' => null,
        ];
        if ($httpStatusCode == 200) {
            $res->data = $resData;
            $res->success = true;
        } else {

            $res->error = $resData->errors;
            $res->success = false;
        }


        return $res;
    }
    public static function sendMessage($body = [])
    {
        if (!is_array($body)) {
            die("Body rquire array");
        }
        $postfield =  "message=" . $body['message'] . "&msisdn=" . $body['msisdn'] . "&sender=" . $body['sender'] . "&force=corporate";


        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $body['url'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>  $postfield,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Basic OXRzOEppbEVPLVE4VVpvWWhhaDlZRlVXbm5CMHFWOmlOdm8zcTNZRW9seTNHV0hPRWt1dVRNaDNvSGNJSw==",
                "content-type: application/x-www-form-urlencoded"
            ],
        ]);

        $response = curl_exec($curl);
        $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        $resData = (array)json_decode($response);
        $res = (object)[
            'data' => null,
            'httpStatusCode' => $httpStatusCode,
            'error' => null,
            'success' => null,
            'message' => ""
        ];
        if (array_key_exists('error', $resData)) {
            $res->error = $resData['error']->name;
            $res->success = false;
            $res->message =  $resData['error']->description;
        } else {
                $res->data = $resData;
                $res->success = true;
                $res->message = "เราได้ส่งรหัสผ่านใหม่ไปยังอีเมล/เบอร์โทรของคุณแล้ว";
        }
        // if ($err) {


        // } else {

        // }
        return $res;
    }
}
