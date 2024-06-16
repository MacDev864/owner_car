<?php

namespace App\Services\MastersServices;

use App\Helpers\JsonResult;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RepoController;
use App\Models\BusinessModel;
use App\Models\MasterModel\EducationModel;
use App\Models\MasterModel\GenderModel;
use App\Models\MasterModel\ProvinceModel;
use App\Models\SysloginModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProvinceService
{
    public static function getAllProvince()
    {
        return ProvinceModel::getAllProvince();
    }
    public static function findOneProvinceById($province_id)
    {
        return ProvinceModel::findOneProvinceById($province_id);
    }
}
