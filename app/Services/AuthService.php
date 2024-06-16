<?php

namespace App\Services;

use App\Helpers\JsonResult;
use App\Helpers\sms;
use App\Http\Controllers\RepoController;
use App\Models\AuthModel;
use App\Models\ProfileModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public static function  register($body)
    {

        try {
            DB::beginTransaction();
            $user  =  User::where('username', $body['username'])->first();
            $password = RepoController::random_int(6);
            $message = "รหัสผ่านผู้ใช้งานของคุณคือ" . $password;

            if ($user) {
                $result['message'] = 'ชื่อผู้ใช้งานมีอยู่แล้วในระบบ';
                $result['message_ex'] = "ชื่อผู้ใช้งานมีอยู่แล้วในระบบ";
                $result['success'] = false;
                return $result;
            }
            $user_uuid = RepoController::getNewId();

            $data = [
                "id" =>   $user_uuid,
                "username" =>  $body['username'],
                "password" =>   Hash::make($password),
                "user_level" => 3,
                "is_deleted" =>  0,
                'created_at' => DB::raw('getdate()'),
                'created_by' => $user_uuid,
                "is_verify"=> 1
            ];


            $rsCreateUser =    AuthModel::create($data);
            DB::commit();

            if ($rsCreateUser == false) {
                DB::rollBack();
                $result['message'] = 'ลงทะเบียนโปรไฟล์ผู้ใช้งานไม่สำเร็จ';
                $result['success'] = false;
                $result['result']  = $rsCreateUser;
                return $result;
            }
            /*
                 $data_profile = [
                "id" =>   RepoController::getNewId(),
                "user_id" => $user_uuid,
                "is_delete" =>  0,
                'created_at' => DB::raw('getdate()'),
                'created_by' =>   $user_uuid,
            ];
            $rsUser =    ProfileModel::create($data_profile);
            DB::commit();

            if ($rsUser == false) {
                DB::rollBack();
                $result['message'] = 'ลงทะเบียนโปรไฟล์ผู้ใช้งานไม่สำเร็จ';
                $result['success'] = false;
                $result['result']  = $rsUser;
                return $result;
            };
            */
            $data_set = [
                'url' =>  "https://api-v2.thaibulksms.com/sms",
                'message' => "รหัสผ่านของคุณคือ : " . $password,
                'msisdn' => $body['username'],
                'sender' =>  "MacSYSTEM",

            ];
            sms::sendMessage($data_set);
            $result['data'] = (object) [
               "username" =>  $body['username'], "password" => $password
            ];
            $result['message'] = "ลงทะเบียนใช้งานสำเร็จ";
            $result['message_ex'] = "";
            $result['success'] = true;
            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function  mobileLogin($body)
    {

        try {
            $user  =  User::where('username', $body['username'])->first();
            $rs['data'] =array();
            if (!$user) {
                $error['username'] = 'focus';
                $error['password'] = 'focus';
                $error['message'] = 'ไม่พบชื่อผู้ใช้งานนี้ในระบบ';
                $error['success'] = false;
                return $error;
            }

            $passwordHash =  $user->password;
            if (Hash::check($body['password'], $passwordHash) == false) {
                $error['password'] = 'focus';
                $error['message'] = 'รหัสผ่านไม่ถูกต้อง';
                $error['success'] = false;
                return $error;
            }
            $auth_guard = Auth::guard('api');

            $credentials = [
                "username" => $body['username'],
                "password" => $body['password']
            ];
            // $organzie  = UserService::getUserOrg($user->id);
            $token =  $auth_guard->attempt($credentials);


            if ($token == false) {
                JsonResult::errors();
            }
            $auth_guard = Auth::guard('api');   
            $credential_user = $auth_guard->user();  
     
            // $credential_user->name =  $credential_user->name  ? $credential_user->name :"";
            // $credential_user->email =  $credential_user->email  ? $credential_user->email :"";
            // $credential_user->updated_at =  $credential_user->updated_at  ? $credential_user->updated_at :"";
            // $credential_user->updated_by =  $credential_user->updated_by  ? $credential_user->updated_by :"";
            // $credential_user->deleted_at =  $credential_user->deleted_at  ? $credential_user->deleted_at :"";
            // $credential_user->deleted_by =  $credential_user->deleted_by  ? $credential_user->deleted_by :"";
            // $data_profile = ProfileModel::getProfileById( $credential_user->id);
            // $data_profile->deleted_at =  $data_profile->deleted_at ?   $data_profile->deleted_at:"";
            // $data_profile->deleted_by =  $data_profile->deleted_by ?   $data_profile->deleted_by:"";
    
            $rs['data']['location']  = "";
            $rs['data']['users'] =  $credential_user;
            // $rs['data']['profile'] =  $data_profile;
            $rs['data']['isSuperAdmin'] = $credential_user->isSuperAdmin();

            $rs['data']['isAdmin'] = $credential_user->isAdmin();
            $rs['data']['isUser'] = $credential_user->isUser();
            $rs['data']['token'] = $token;
            $rs['data']['expires_in']=$auth_guard->factory()->getTTL();
            $rs['success'] = true;
            $rs['message'] = "เข้าสู่ระบบสำเร็จ";
            return $rs;

           
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
