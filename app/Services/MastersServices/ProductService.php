<?php

namespace App\Services\MastersServices;

use App\Helpers\JsonResult;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RepoController;
use App\Models\BusinessModel;
use App\Models\MasterModel\ProductModel;
use App\Models\MasterProgramModel;
use App\Models\PersonalModel;
use App\Models\SysloginModel;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProductService
{

    public static function getMasterProgram()
    {
        try {
            return ProductModel::getMasterProgram();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

   
}
