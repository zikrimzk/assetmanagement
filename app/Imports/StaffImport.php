<?php

namespace App\Imports;

use App\Models\Staff;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $countError = 0;
        
        if(Staff::where('staff_no',$row['staff_no'])->exists())
        {
            $countError += 1;
        }
        else{
            $data = new Staff(); 
            $data->staff_no = $row['staff_no'];
            $data->staff_name = Str::headline($row['staff_name']);
            $data->staff_phone = $row['staff_phone'];
            $data->email = $row['email'];
            if($row['staff_role'] == 'A' || $row['staff_role'] == 'a' )
            {
                $data->staff_role = 1; // ADMIN
            }
            elseif($row['staff_role'] == 'S' || $row['staff_role'] == 's')
            {
                $data->staff_role = 2; // STAFF
            }
            elseif($row['staff_role'] == 'V' || $row['staff_role'] == 'v')
            {
                $data->staff_role = 3; // VIEWER
            }
            $data->staff_status = 0;
            $data->dep_id = Department::where('department_code', Str::upper($row['department_code']))->first()->id;
            $data->comp_id = Company::where('company_code',Str::upper($row['company_code']))->first()->id;
            $data->password = bcrypt($row['password']);
            $data->save();
        }

            
    }
}
