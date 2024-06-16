<?php

namespace App\Helpers;


use Carbon\Carbon;
use Exception;
use Ichtrojan\Otp\Models\Otp as Model;
use Illuminate\Support\Facades\Validator;

class Validators
{
    public static function validator($body, $data)
    {
        try {
            $result = array();
            $validator = Validator::make($body, $data);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                $message = array();
                $str = "";
                foreach ($errors as $key => $items) {
                    foreach ($items as $key => $item) {
                        $str = $key + 1;
                        $str .= ". ";
                        $str .= $item;
                        array_push($message, $str);
                    }
                }
                $str = "";
                foreach ($message as $key => $item) {
                    if ($key == 0) {
                        $str =   ($key + 1) . ". " . explode(". ", $item)[1];
                        $str .=   "\n ";
                    } else {
                        $str .=   ($key + 1) . ". " . explode(". ", $item)[1];
                        $str .=   "\n";
                    }
                }
                $result['data'] = null;
                $result['message'] =  $str;
                $result['success'] = false;
                return  $result;
            }
            $result['data'] = null;
            $result['message'] = '';
            $result['success'] = true;
            return  $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
