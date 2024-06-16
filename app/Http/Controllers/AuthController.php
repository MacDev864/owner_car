<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResult;
use App\Helpers\Validators;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $validators;

    public function __construct(Validators $validators)
    {
        // $this->sms = $smsnoitify;
        // $this->otps = $otps;
        $this->validators = $validators;
    }
    // 
    public static function register(Request $req)
    {
        try {
            $body = $req->all();
            $regex = 'required|regex:/^[0-9][0-9]{9}$/|digits:10';
            $body['type'] = "001";
            $validatormobile = Validators::validator($body,  [
                'username' => $regex,
            ]);
            if ($validatormobile['success'] == false) {
                return JsonResult::errors($validatormobile['data'], $validatormobile['message']);
            }
            $result = AuthService::register($body);
            if ($result['success'] == false) {
                return JsonResult::errors(null, $result['message']);
            }
            return JsonResult::success($result['data'], $result['message']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function mobilelogin(Request $req)
    {
        try {

            $body =  $req->all();
            $regex = 'required|regex:/^[0-9][0-9]{9}$/|digits:10';

            $validator = Validators::validator($body,  [
                'username' => $regex,
            ]);
            if ($validator['success'] == false) {
                return JsonResult::errors($validator['data'], $validator['message']);
            }
            $result = AuthService::mobileLogin($body);

            if ($result['success'] == false) {
                return JsonResult::errors(null, $result['message']);
            }

            return JsonResult::success($result['data'], $result['message']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
