<?php

namespace App\Services\MastersServices;

use App\Models\MasterModel\BloodModel;

class BloodService
{
    public static function getAllBlood()
    {
        return BloodModel::getAllBlood();
    }
    public static function findOneBloodById($blood_id)
    {
        return BloodModel::findOneBloodById($blood_id);
    }
    // 
}
