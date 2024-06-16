<?php

namespace App\Services\MastersServices;

use App\Models\MasterModel\IndustryModel;

class IndustryService
{
    public static function getAllIndustryGroup()
    {
        return IndustryModel::getAllIndustryGroup();
    }
    public static function findOneIndustryGroupById($industry_id)
    {
        return IndustryModel::findOneIndustryGroupById($industry_id);
    }
    // 
}
