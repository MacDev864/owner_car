<?php

namespace App\Constants;

class MasterTable
{

    public const SYS_TABLE_MAPPING = [
        1 => [
            'table' => 'sys_users',
            'code' => 'emp_code',
            'id' => 'id'
        ],
        2 => [
            'table' => 'department',
            'code' => 'department_code',
            'id' => 'department_id'
        ],
        3 => [
            'table' => 'section',
            'code' => 'section_code',
            'id' => 'section_id'
        ],
        4 => [
            'table' => 'position',
            'code' => 'position_code',
            'id' => 'position_id'
        ],
        7 => [
            'table' => 'company_shift',
            'code' => 'shift_code',
            'id' => 'shift_id'
        ],
        6 => [
            'table' => 'group_day_of_work',
            'code' => 'group_day_of_work_code',
            'id' => 'group_day_of_work_id'
        ],
        5 => [
            'table' => 'company_evaluate',
            'code' => 'evaluate_code',
            'id' => 'evaluate_id',
        ],
        8 => [
            'table' => 'company_ravenue',
            'code' => 'ravenue_code',
            'id' => 'ravenue_id',
        ],
        9 => [
            'table' => 'company_deduct',
            'code' => 'deduct_code',
            'id' => 'deduct_id',
        ],
        10 => [
            'table' => 'company_fund',
            'code' => 'fund_code',
            'id' => 'fund_id',
        ],
        11 => [
            'table' => 'company_overtime_form',
            'code' => 'overtime_form_code',
            'id' => 'overtime_form_id',
        ],
        12 => [
            'table' => 'company_job_form',
            'code' => 'job_form_code',
            'id' => 'job_form_id',
        ],
        13 => [
            'table' => 'company_warning_form',
            'code' => 'cwf_code',
            'id' => 'cwf_id',

        ],
        14 => [
            'table' => 'company_upsalary_form',
            'code' => 'upsalary_form_code',
            'id' => 'upsalary_form_id',
        ],
    ];

    // employeer table
    public const EMPLOYEE = "sys_users";

    // payroll table
    public const  EMPLOYEE_SLIP  =  "employee_slip";
    public const  EMPLOYEE_SLIP_HEADER  =  "employee_slip_table";
    public const  EMPLOYEE_SLIP_ITEM  =  "employee_slip_item";
    public const  COMPANY_PAYMENT_PERIOD  =  "company_payment_period";
}
