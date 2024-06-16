<?php

namespace App\Services\MastersServices;

use App\Models\MasterModel\BusinessGroupModel;
use App\Models\MasterModel\IndustryModel;

class BusinessGroupService
{
    public static function getAllBusinessGroup()
    {
        return BusinessGroupModel::getAllBusinessGroup();
    }
    public static function findOneBusinessGroupById($business_id)
    {
        return BusinessGroupModel::findOneBusinessGroupById($business_id);
    }
    // 
}
