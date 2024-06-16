<?php

namespace App\Models;

use App\Helpers\JsonResult;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TypeVehicleModel
{

    private const TABLE = 'type_vehicle';

    private const PK = 'id';
    public static function findOneRegistration($registration)
    {
        return
            DB::table(self::TABLE)
           ->where("vehicle_registration",$registration)
           ->where('is_deleted',0)
            ->first();
    }
    public static function getTypeVehicle()
    {
        return
            DB::table(self::TABLE)
            ->where('is_deleted',0)
            ->get();
    }
    public static function getProfileByownerId($id)
    {
        return
            DB::table(self::TABLE)
            ->where('onwer_id',$id)
            ->where('is_deleted',0)
            ->get();
    }
    public static function getCarProfileById($id)
    {
        return
            DB::table(self::TABLE)
            ->where(self::PK,$id)
            ->where('is_deleted',0)
            ->first();
    }
    // 
     public static function getProfileById($id)
    {
        return
            DB::table(self::TABLE)
           ->where(self::PK,$id)
            ->first();
    }
    
    public static function create($data)
    {
        return DB::table(self::TABLE)->insert($data);
    }
    public static function clear($id,$data)
    {
        return DB::table(self::TABLE)
            ->where("onwer_id",$id)
            ->update($data);
    }
    public static function update($id,$data)
    {
        return DB::table(self::TABLE)
            ->where(self::PK,$id)
            ->update($data);
    }
    // 
}
