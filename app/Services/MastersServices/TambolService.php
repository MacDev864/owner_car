<?php

namespace App\Services\MastersServices;

use App\Helpers\JsonResult;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RepoController;
use App\Models\BusinessModel;
use App\Models\MasterModel\EducationModel;
use App\Models\MasterModel\GenderModel;
use App\Models\MasterModel\TambolModel;
use App\Models\SysloginModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TambolService
{
    public static function getAllTambolByAmphureId($amphure_id)
    {
        return TambolModel::getAllTambolByAmphureId($amphure_id);
    }
    public static function findOneTambolById($tambol_id)
    {
        return TambolModel::findOneTambolById($tambol_id);
    }
    // 
}
