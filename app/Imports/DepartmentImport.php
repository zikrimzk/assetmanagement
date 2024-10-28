<?php

namespace App\Imports;

use App\Models\Department;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DepartmentImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $countError = 0;
        if(Department::where('department_code',Str::upper($row['department_code']))->exists()){
            $countError += 1;
            
        }else{
            $data = new Department();
            $data->department_name = Str::headline($row['department_name']);
            $data->department_code = Str::upper($row['department_code']);
            $data->save();
        }
            
    }
}
