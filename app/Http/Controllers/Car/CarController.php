<?php

namespace App\Http\Controllers\car;

use App\Helpers\JsonResult;
use App\Helpers\Validators;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\Vehicle\CarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    // create
    public static function create(Request $req)
    {
        try {
            $auth_guard = Auth::guard('api');
            $user =   $auth_guard->user();
            if (is_null($user)) {
                return JsonResult::errors(null,"User is not Found");
            }
            $body = $req->all();
            $body['onwer_id'] = $user->id;
            $body['vehicle_registration'] = trim($body['vehicle_registration']);
            $validators = Validators::validator($body,  [
                "vehicle_name"  => 'required|max:50',
                "vehicle_model" => 'required|max:50',
                "vehicle_color"  => 'required|max:50',
                "vehicle_description" => 'required|max:50',
                "vehicle_type" => 'required|max:50',
                "vehicle_registration" => 'required|max:50'
            ]);
            if ($validators['success'] == false) {
                return JsonResult::errors($validators['data'], $validators['message']);
            }
            $result = CarService::create($body);
            if ( $result['success'] == false) {
                return JsonResult::errors($result['errors'],$result['message']);
            }

            return    JsonResult::success( null,$result['message']) ;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    // update
    public static function update(Request $req)
    {
        try {
            $auth_guard = Auth::guard('api');
            $user =   $auth_guard->user();
            if (is_null($user)) {
                return JsonResult::errors(null,"User is not Found");
            }
            $body = $req->all();
            $body['onwer_id'] = $user->id;
            $body['vehicle_registration'] = trim($body['vehicle_registration']);
            $validators = Validators::validator($body,  [
                "vehicle_name"  => 'required|max:50',
                "vehicle_model" => 'required|max:50',
                "vehicle_color"  => 'required|max:50',
                "vehicle_description" => 'required|max:50',
                "vehicle_type" => 'required|max:50',
                "vehicle_registration" => 'required|max:50'
            ]);
            if ($validators['success'] == false) {
                return JsonResult::errors($validators['data'], $validators['message']);
            }
            $result = CarService::update($body);
            if ( $result['success'] == false) {
                return JsonResult::errors($result['errors'],$result['message']);
            }
            return    JsonResult::success( null,$result['message']) ;

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    // delete
    public static function delete(Request $req)
    {
        try {
            $auth_guard = Auth::guard('api');
            $user =   $auth_guard->user();
            if (is_null($user)) {
                return JsonResult::errors(null,"User is not Found");
            }
            $body = $req->all();
            $body['onwer_id'] = $user->id;
            $result = CarService::delete($body);
            return    JsonResult::success( null,$result['message']) ;

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    // clear
    public static function clear(Request $req)
    {
        try {
            $auth_guard = Auth::guard('api');
            $user =   $auth_guard->user();
            if (is_null($user)) {
                return JsonResult::errors(null,"User is not Found");
            }
            $body = $req->all();
            $body['onwer_id'] = $user->id;
            $result = CarService::clear($body);
            return    JsonResult::success( null,$result['message']) ;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function getCarProfile()
    {
        try {
            $auth_guard = Auth::guard('api');
            $user =   $auth_guard->user();
            if (is_null($user)) {
                return JsonResult::errors(null,"User is not Found");
            }
            $id = $user->id;
            $result = CarService::getCarProfile($id);
            if ( $result['success'] == false) {
                return JsonResult::errors($result['errors'],$result['message']);
            }
            return    JsonResult::success( $result['data'],$result['message']) ;

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function getTypeVehicle()
    {
        try {
            $auth_guard = Auth::guard('api');
            $user =   $auth_guard->user();
            if (is_null($user)) {
                return JsonResult::errors(null,"User is not Found");
            }
            $id = $user->id;
            $result = CarService::getTypeVehicle();
            if ( $result['success'] == false) {
                return JsonResult::errors($result['errors'],$result['message']);
            }
            return    JsonResult::success( $result['data'],$result['message']) ;

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function getCarProfileById($vehicle_id)
    {
        try {
            $auth_guard = Auth::guard('api');
            $user =   $auth_guard->user();
            if (is_null($user)) {
                return JsonResult::errors(null,"User is not Found");
            }
            $result = CarService::getCarProfileById($vehicle_id);
            if ( $result['success'] == false) {
                return JsonResult::errors($result['errors'],$result['message']);
            }
            return    JsonResult::success( $result['data'],$result['message']) ;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
