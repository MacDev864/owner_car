<?php

namespace App\Http\Controllers;

use App\Constants\AppConstants;
use App\Models\User;
use App\Services\MastersServices\AmphureService;
use App\Services\MastersServices\BloodService;
use App\Services\MastersServices\BusinessGroupService;
use App\Services\MastersServices\EducationService;
use App\Services\MastersServices\GenderService;
use App\Services\MastersServices\IndustryService;
use App\Services\MastersServices\MaritalStatusService;
use App\Services\MastersServices\NationalityService;
use App\Services\MastersServices\PrefixService;
use App\Services\MastersServices\ProductService;
use App\Services\MastersServices\ProvinceService;
use App\Services\MastersServices\ReligionService;
use App\Services\MastersServices\TambolService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\isEmpty;

class RepoController extends Controller
{
    public const SAVE_SUCCESS = "บันทีกข้อมูลสำเร็จ";

    public const SAVE_ERROR = "บันทึกข้อมูลไม่สำเร็จ";

    public const UPDATE_SUCCESS = "แก้ไขข้อมูลสำเร็จ";

    public const UPDATE_ERROR = "แก้ไขข้อมูลไม่สำเร็จ";

    public const DELETE_SUCCESS = "ลบข้อมูลสำเร็จ";

    public const DELETE_ERROR = "ลบข้อมูลไม่สำเร็จ";

    public const ERROR_DATA_NOT_FOUND = "ไม่พบข้อมูลนี้ในระบบ";

    public const ERROR_INVALID_FORMAT = "รูปแบบไม่ถูกต้อง";

    public static function formatTelephoneNumber($number)
    {
        $str = "** **** ";
        for ($i = 0; $i < strlen($number); $i++) {
            if ($i >= 6) {
                $str .= $number[$i];
            }
        }
        $number = $str;
        return $number;
    }
    public static function formatTelephoneNumbers($number)
    {
        $minus_sign = "-";   // กำหนดเครื่องหมาย 
        $part1 = substr($number, 0, -7);  // เริ่มจากซ้ายตัวที่ 1 ( 0 ) ตัดทิ้งขวาทิ้ง 7 ตัวอักษร ได้ 085 
        $part2 = substr($number, 3, -3);  // เริ่มจากซ้าย ตัวที่ 4 (9) ตัดทิ้งขวาทิ้ง 3 ตัวอักษร ได้ 9490 
        $part3 = substr($number, 7); // เริ่มจากซ้าย ตัวที่ 8 (8) ไม่ตัดขวาทิ้ง ได้ 862  
        $number = $part1 . $minus_sign . $part2 . $minus_sign . $part3;
        return $number;
    }

    public static function pageDefaultVariables(
        $pagescale = '1',
        $page_name = '',
        $category_name = 'company',
        $category_name_th = 'ข้อมูลกลาง',
        $dropdown_name = ''
    ) {
        $data = [
            //! Width page scale
            'pagescale' => $pagescale,

            //! Page active
            'page_name' => $page_name,

            //todo -> Default homepage
            'category_name' => $category_name,
            'category_name_th' => $category_name_th,

            //todo -> dropdown active
            'dropdown_name' => $dropdown_name,
        ];
        return $data;
    }
    public static function pageDefaultVariablesDropdown(
        $page_group = "dashboard",
        $page_v1_name_en = 'dashboard',
        $page_v1_name_th = 'โปรไฟล์ส่วนตัว',
        $page_v2_name_th = '',
        $page_v2_name_en = '',
        $page_v3_name_en = '',
        $page_v3_name_th = '',
        $page_settings = '',
        User $user,
        $masters = AppConstants::MASTER
    ) {
        $birthdate = date_format(date_create($user->user_profile['birthdate']), 'd/m/Y');
        // $selected_amphure_id_1 = 
        $data = [
            'page_group' =>  $page_group,
            'page_v1_name_en' =>   $page_v1_name_en,
            'page_v1_name_th' => $page_v1_name_th,
            'page_v2_name_en' => $page_v2_name_en,
            'page_v2_name_th' =>  $page_v2_name_th,
            'page_v3_name_en' =>   $page_v3_name_en,
            'page_v3_name_th' =>  $page_v3_name_th,
            'page_settings' => $page_settings,
            'user_data' =>  $user->toArray(),


        ];
        $info_amphure_id_1 = array();
        $info_tambol_id_1 = array();
        $info_amphure_id_2 = array();
        $info_tambol_id_2 = array();

        $data['user_data']['user_profile']['birthdate'] =  $birthdate;
        $amphure_id_1 = AmphureService::findOneAmphureById($user['user_profile']['amphure_id_1']);
        $tambol_id_1 = TambolService::findOneTambolById($user['user_profile']['tambol_id_1']);
        $amphure_id_2 = AmphureService::findOneAmphureById($user['user_profile']['amphure_id_2']);
        $tambol_id_2 = TambolService::findOneTambolById($user['user_profile']['tambol_id_2']);
        $data['user_data']['user_profile']['select_amphure_id_1'] = null;
        $data['user_data']['user_profile']['select_tambol_id_1'] = null;
        $data['user_data']['user_profile']['select_amphure_id_2'] = null;
        $data['user_data']['user_profile']['select_tambol_id_2'] = null;
        if (!is_null($amphure_id_1)) {
            $info_amphure_id_1  = [
                'id' =>   $amphure_id_1->id,
                'name_th' =>   $amphure_id_1->name_th,
            ];
            $data['user_data']['user_profile']['select_amphure_id_1'] =    $info_amphure_id_1;
        }
        if (!is_null($tambol_id_1)) {
            $info_tambol_id_1  = [
                'id' =>   $tambol_id_1->id,
                'name_th' =>   $tambol_id_1->name_th,
            ];
            $data['user_data']['user_profile']['select_tambol_id_1'] = $info_tambol_id_1;
        }
        if (!is_null($amphure_id_2)) {
            $info_amphure_id_2  = [
                'id' =>   $amphure_id_2->id,
                'name_th' =>   $amphure_id_2->name_th,
            ];
            $data['user_data']['user_profile']['select_amphure_id_2'] = $info_amphure_id_2;
        }
        if (!is_null($tambol_id_2)) {
            $info_tambol_id_2 =  [
                'id' =>   $tambol_id_2->id,
                'name_th' =>   $tambol_id_2->name_th,
            ];
            $data['user_data']['user_profile']['select_tambol_id_2'] =   $info_tambol_id_2;
        }

        $data['user_data']['company_profile']['select_amphure_id_1'] = null;
        $data['user_data']['company_profile']['select_tambol_id_1'] = null;
        $data['user_data']['company_profile']['select_amphure_id'] = null;
        $data['user_data']['company_profile']['select_tambol_id'] = null;
        $amphure_id = AmphureService::findOneAmphureById($user['company_profile']['amphure_id']);
        $tambol_id = TambolService::findOneTambolById($user['company_profile']['tambol_id']);
        if (!is_null($amphure_id)) {
            $info_amphure_id  = [
                'id' =>   $amphure_id->id,
                'name_th' =>   $amphure_id->name_th,
            ];
            $data['user_data']['company_profile']['select_amphure_id'] = $info_amphure_id;
        }
        if (!is_null($tambol_id)) {
            $info_tambol_id =  [
                'id' =>   $tambol_id->id,
                'name_th' =>   $tambol_id->name_th,
            ];
            $data['user_data']['company_profile']['select_tambol_id'] =   $info_tambol_id;
        }
        $result = self::generateDataMaster($masters);
        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $data[$key] = $value;
            }
        }

        return $data;
    }
    public static function random_string($string_length = 6)
    {
        $random_string = "";
        $random_characters = array_merge(range('0', '9'), range('A', 'Z'), range('a', 'z'));
        $max = count($random_characters) - 1;
        for ($i = 0; $i < $string_length; $i++) {
            $rand = mt_rand(0, $max);
            $random_string .= $random_characters[$rand];
        }
        return $random_string;
    }
    public static function random_int($string_length = 6)
    {
        $random_string = "";
        $random_characters = array_merge(range('0', '9'));
        $max = count($random_characters) - 1;
        for ($i = 0; $i < $string_length; $i++) {
            $rand = mt_rand(0, $max);
            $random_string .= $random_characters[$rand];
        }
        return $random_string;
    }
    public static function uploadImg($request, $user, $type, $text)
    {
        try {
            $body = array();
            if ($request->hasFile($type)) {
                $image = $request->file($type);

                if ($image) {
                    $id = $user->id;
                    $imagePath = AppConstants::prefix_image($user->sys_customer_code);

                    // Delete existing image
                    File::delete($imagePath . $type . "-" . $id);

                    // Move the new image and update profile_img field
                    $new_img_name = $type . "-" . $id . '.' . $image->getClientOriginalExtension();
                    $image->move($imagePath, $new_img_name);
                    $body[$type] = $new_img_name;
                }
            } else {
                // If no image provided, remove profile_img field
                unset($body[$type]);
            }
            return $body;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public static function uploadFile($request, $user, $type, $text)
    {
        try {
            $body = array();
            if ($request->hasFile($type)) {
                $image = $request->file($type);

                if ($image) {
                    $id = $user->id;
                    $imagePath = AppConstants::prefix_pettion();

                    // Delete existing image
                    File::delete($imagePath . $type . "-" . time());

                    // Move the new image and update profile_img field
                    $new_img_name =  $type . "-" . time() . $image->getClientOriginalExtension();
                    $image->move($imagePath, $new_img_name);
                    $body[$type] = $new_img_name;
                }
            }
            return $body;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function dropdownMasterData()
    {
        try {
            $data = [
                "dropdown_prfix" => PrefixService::getAllPrefix()->toArray(),
                "dropdown_gender" => GenderService::getAllGender()->toArray(),
                "dropdown_blood" => BloodService::getAllBlood()->toArray(),
                "dropdown_provinces" => ProvinceService::getAllProvince()->toArray(),
                "dropdown_nationality" =>  NationalityService::getAllNationality()->toArray(),
                "dropdown_religion" => ReligionService::getAllReligion()->toArray(),
                "dropdown_education" =>  EducationService::getAllEducation()->toArray(),
                "dropdown_industry" => IndustryService::getAllIndustryGroup()->toArray(),
                "dropdown_business" => BusinessGroupService::getAllBusinessGroup()->toArray(),
                "dropdown_marital_status" => MaritalStatusService::getAllMaritalStatus()->toArray(),
            ];

            return $data;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function setProfile($profile)
    {
        $profile_set = (object)[];
        $profile_set->fullname = self::setFullname($profile);
        $profile_set->address_1 = self::setAddress_1($profile);
        $profile_set->address_2 = $profile->is_same_address  ? self::setAddress_1($profile) : self::setAddress_2($profile);
        $profile_set->birthdate =  $profile->birthdate ? date_format(date_create($profile->birthdate), "d/m/Y") : "ไม่พบข้อมูล";
        $profile_set->weight = $profile->weight ? $profile->weight . " กก." : "ไม่พบข้อมูล";
        $profile_set->height = $profile->height ? $profile->height . " ซม." : "ไม่พบข้อมูล";
        $profile_set->id_card = $profile->id_card ? $profile->id_card : "ไม่พบข้อมูล";
        $profile_set->tel = $profile->tel ? self::formatTelephoneNumbers($profile->tel) : "ไม่พบข้อมูล";
        $profile_set->gender = $profile->join_gender_id ? $profile->join_gender_id->gender_name_th : "ไม่พบข้อมูล";
        $profile_set->blood = $profile->join_blood_id ? $profile->join_blood_id->blood_name_th : "ไม่พบข้อมูล";
        $profile_set->religion = $profile->join_religion_id ? $profile->join_religion_id->religion_name_th : "ไม่พบข้อมูล";
        $profile_set->nationality =   $profile->join_nationality_id ? $profile->join_nationality_id->nationality_name_th : "ไม่พบข้อมูล";
        $profile_set->maritalstatus =   $profile->join_marital_status_id ? $profile->join_marital_status_id->marital_status_name_th : "ไม่พบข้อมูล";
        $profile_set->education =   $profile->join_education_id ? $profile->join_education_id->education_name_th : "ไม่พบข้อมูล";
        $profile_set->social_contact_1 =   $profile->social_contact_1 ? $profile->social_contact_1 : "ไม่พบข้อมูล";
        return $profile_set;
    }
    public static function setLoginData($data)
    {
        $login_set = (object)[];
        $data->tel = self::formatTelephoneNumber($data->tel);
        $login_set = (array)$data->toArray();
        return $login_set;
    }
    public static function chkRequest($type)
    {
        $text = '';
        switch ($type) {
            case 1:
                $text = 'ขอเปลี่ยน E-mail ผู้ดูแลระบบ';
                break;
            case 2:
                $text = 'ขอยกเลิกใช้บริการ';
                break;
            case 3:
                $text = 'อื่นๆ';
                break;
        
        }
        return $text;
    }
    public static function setComProfile($company)
    {
        $company_set = (object)[];
        $company_set->name =  $company->name ? $company->name : "ไม่พบข้อมูล";
        $company_set->name_en = $company->name_en ? $company->name_en : "ไม่พบข้อมูล";
        $company_set->short_name = $company->short_name ? $company->short_name : "ไม่พบข้อมูล";
        $company_set->person_name = $company->person_name ? $company->person_name : "ไม่พบข้อมูล";
        $company_set->tax_code = $company->tax_code ? $company->tax_code : "ไม่พบข้อมูล";
        $company_set->employer_account_number = $company->employer_account_number ? $company->employer_account_number : "ไม่พบข้อมูล";
        $company_set->company_description = $company->company_description ? $company->company_description : "ไม่พบข้อมูล";
        // 
        $company_set->address = self::setAddress_1($company);
        $company_set->industry_group = $company->join_industry_group_id ?  $company->join_industry_group_id->industry_name_th : "ไม่พบข้อมูล";
        $company_set->business_group =  $company->join_business_group_id ? $company->join_business_group_id->business_name_th : "ไม่พบข้อมูล";
        return $company_set;
    }
    public static function setProgramSelect($program)
    {
        $program_set = [];
        $program_data =  ProductService::getMasterProgram()->toArray();
        foreach ($program_data as $key => $product) {
            $product->is_active =  filter_var(0, FILTER_VALIDATE_BOOLEAN);
            foreach ($program as $key => $item) {
                $product->is_active =  $product->product_id == $item->program_id ? filter_var($item->is_active, FILTER_VALIDATE_BOOLEAN) :  $product->is_active;
                if ($product->is_active) {
                    if ($product->product_id == $item->program_id) {
                        $product->last_login_date =  date_format(now(), "d/m/Y");
                        $product->last_login_time =  date_format(now(), "H:i") . " น.";
                        array_push($program_set, $product);
                    }
                }
            }
        }
        // $program_set = $program_data;
        return $program_set;
    }
    public static function generateDataMaster($masters)
    {

        $dropdown = self::dropdownMasterData();


        foreach ($masters as $key => $master) {
            $data[$master . '_id'] =  null;
            $data[AppConstants::PREFIX_DROPDOWN . $master] =   array();
            switch (true) {
                case $master == "prfix":
                    $data[AppConstants::PREFIX_DROPDOWN . $master] =   $dropdown[AppConstants::PREFIX_DROPDOWN . $master];
                    break;
                case $master == "gender":
                    $data[AppConstants::PREFIX_DROPDOWN . $master] = $dropdown[AppConstants::PREFIX_DROPDOWN . $master];
                    break;
                case $master == "blood":
                    $data[AppConstants::PREFIX_DROPDOWN . $master] = $dropdown[AppConstants::PREFIX_DROPDOWN . $master];
                    break;
                case $master == "provinces":
                    $data[AppConstants::PREFIX_DROPDOWN . $master] = $dropdown[AppConstants::PREFIX_DROPDOWN . $master];
                    break;
                case $master == "religion":
                    $data[AppConstants::PREFIX_DROPDOWN . $master] = $dropdown[AppConstants::PREFIX_DROPDOWN . $master];
                    break;
                case $master == "nationality":
                    $data[AppConstants::PREFIX_DROPDOWN . $master] = $dropdown[AppConstants::PREFIX_DROPDOWN . $master];
                    break;
                case $master == "education":
                    $data[AppConstants::PREFIX_DROPDOWN . $master] = $dropdown[AppConstants::PREFIX_DROPDOWN . $master];
                    break;
                case $master == "industry":
                    $data[AppConstants::PREFIX_DROPDOWN . $master] = $dropdown[AppConstants::PREFIX_DROPDOWN . $master];
                    break;
                case $master == "business":
                    $data[AppConstants::PREFIX_DROPDOWN . $master] =  $dropdown[AppConstants::PREFIX_DROPDOWN . $master];
                    break;
                case $master == "marital_status":
                    $data[AppConstants::PREFIX_DROPDOWN . $master] =  $dropdown[AppConstants::PREFIX_DROPDOWN . $master];
                    break;
                    // 

            }
        }
        return $data;
    }
    public static function setFullname($profile)
    {
        $full_name = $profile->join_prefix_id ? $profile->join_prefix_id->prefix_name_th . "" . $profile->first_name . " " . $profile->last_name : "" . $profile->first_name . " " . $profile->last_name;
        return $full_name;
    }
    public static function setAddress_1($profile)
    {
        $adress_1 = $profile->address_1 ? $profile->address_1 . " ต." : " ";
        $adress_1 .=  $profile->join_tambol_id_1 ? $profile->join_tambol_id_1->name_th . " อ." : "";
        $adress_1 .= $profile->join_amphure_id_1 ? $profile->join_amphure_id_1->name_th . " จ." : "";
        $adress_1 .= $profile->join_province_id_1 ? $profile->join_province_id_1->name_th . " " : "";
        $adress_1 .= $profile->join_tambol_id_1 ? $profile->join_tambol_id_1->zip_code : "";

        $location  = $adress_1;
        return $location;
    }
    public static function setAddress_2($profile)
    {

        $adress_2 = $profile->address_2 ? $profile->address_2 . " ต."  :  "";
        $adress_2 .=  $profile->join_tambol_id_2 ? $profile->join_tambol_id_2->name_th . " อ." :  "";
        $adress_2 .= $profile->join_amphure_id_2 ? $profile->join_amphure_id_2->name_th . " จ." :  "";
        $adress_2 .= $profile->join_province_id_2 ? $profile->join_province_id_2->name_th . " " : "";
        $adress_2 .= $profile->join_tambol_id_2 ? $profile->join_tambol_id_2->zip_code : "";
        $location  =  $adress_2;
        return $location;
    }
    public static function pageBreadcrumb(
        $page_name_th = "",
        $page_name_th_url = "",
        $page_name_v1 = "",
        $page_name_v1_url = "",
        $page_name_v2 = "",
        $page_name_v2_url = ""
    ) {
        $data = [
            //todo -> Breadcrumb page level 1            
            'page_name_th' => $page_name_th,
            'page_name_th_url' => $page_name_th_url,

            //todo -> Breadcrumb page level 2
            'page_name_v1' => $page_name_v1,
            'page_name_v1_url' => $page_name_v1_url,

            //todo -> Breadcrumb page level 3
            'page_name_v2' => $page_name_v2,
            'page_name_v2_url' => $page_name_v2_url,
        ];
        return $data;
    }

    public static function getNewId()
    {
        return DB::select('select NEWID() as uuid')[0]->uuid;
    }
}
