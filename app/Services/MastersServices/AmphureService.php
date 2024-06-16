<?php

namespace App\Services\MastersServices;

use App\Helpers\JsonResult;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RepoController;
use App\Models\BusinessModel;
use App\Models\MasterModel\AmphureModel;
use App\Models\MasterModel\EducationModel;
use App\Models\MasterModel\GenderModel;
use App\Models\SysloginModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AmphureService
{
    public static function getAllAmphureByProvinceId($province_id)
    {
        return AmphureModel::getAllAmphureByProvinceId($province_id);
    }
    public static function findOneAmphureById($amphure_id)
    {
        return AmphureModel::findOneAmphureById($amphure_id);
    }
    // 
}
