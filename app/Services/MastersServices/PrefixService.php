<?php

namespace App\Services\MastersServices;


use App\Models\MasterModel\PrefixModel;


class PrefixService
{
    public static function getAllPrefix()
    {
        return PrefixModel::getAllPrefix();
    }
    public static function findOnePrefixById($prefix_id)
    {
        return PrefixModel::findOnePrefixById($prefix_id);
    }
}
