<?php

namespace App\Services\Vehicle;

use App\Helpers\JsonResult;
use App\Helpers\sms;
use App\Http\Controllers\RepoController;
use App\Models\AuthModel;
use App\Models\ProfileModel;
use App\Models\TypeVehicleModel;
use App\Models\User;
use App\Models\VehicleModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CarService
{
    public static function create($data)
    {
        DB::beginTransaction();

        try {
            $result = array();
            $is_exists_regitration = VehicleModel::findOneRegistration($data['vehicle_registration']);
            if ($is_exists_regitration) {
                $result['success'] = false;
                $result['message'] = "Your Registration " . $data['vehicle_registration']  . " is already exists";
                $result['errors'] = null;
                return $result;
            }
            // 
            $data['vehicle_code'] =   "CAR" . RepoController::random_int(4);

            $data['vehicle_id'] = RepoController::getNewId();
            $data['created_at'] = now();
            $data['created_by'] = $data['onwer_id'];
            $data['is_deleted'] = 0;
            VehicleModel::create($data);
            DB::commit();
            $result['success'] = true;
            $result['message'] = "Your car is Created Successfully";
            $result['errors'] = null;
            return $result;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public static function update($data)
    {
        DB::beginTransaction();

        try {
            $result = array();
            $data['updated_at'] = now();
            $data['updated_by'] = $data['onwer_id'];
            $data['is_deleted'] = 0;

            VehicleModel::update($data['vehicle_id'], $data);
            DB::commit();
            $result['success'] = true;
            $result['message'] = "Your car is Updated Successfully";
            $result['errors'] = null;
            return $result;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public static function delete($data)
    {
        DB::beginTransaction();

        try {
            $result = array();
            $data['updated_at'] = now();
            $data['updated_by'] = $data['onwer_id'];
            $data['is_deleted'] = 1;

            VehicleModel::update($data['vehicle_id'], $data);
            DB::commit();
            $result['success'] = true;
            $result['message'] = "Your car is Deleted Successfully";
            $result['errors'] = null;
            return $result;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public static function clear($data)
    {
        DB::beginTransaction();
        try {
            $result = array();
            $data['updated_at'] = now();
            $data['updated_by'] = $data['onwer_id'];
            $data['is_deleted'] = 1;

            VehicleModel::clear($data['onwer_id'], $data);
            DB::commit();
            $result['success'] = true;
            $result['message'] = "Your car is Clear Successfully";
            $result['errors'] = null;
            return $result;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    // 
    public static function getCarProfile($id)
    {
        try {

            $result['data'] =  VehicleModel::getProfileByownerId($id)->toArray();
            if (empty($result['data'])) {
                $result['success'] = true;
                $result['message'] = "ไม่พบข้อมูลยานพาหนะ";
                $result['errors'] = null;
                return $result;
            }
            $result['success'] = true;
            $result['message'] = "พบข้อมูลยานพาหนะ";
            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function getTypeVehicle()
    {
        try {

            $result['data'] =  TypeVehicleModel::getTypeVehicle()->toArray();
            if (empty($result['data'])) {
                $result['success'] = true;
                $result['message'] = "Your Vehicle is Not Found ";
                $result['errors'] = null;
                return $result;
            }
            $result['success'] = true;
            $result['message'] = "Your Vehicle is Found ";
            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function getCarProfileById($vehicle_id)
    {
        try {
            $result['data'] =  VehicleModel::getCarProfileById($vehicle_id);
            if (is_null($result['data'])) {
                $result['success'] = true;
                $result['message'] = "Your Vehicle is Not Found ";
                $result['errors'] = null;
                return $result;
            }
            $result['success'] = true;
            $result['message'] = "Your Vehicle is Found ";
            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
