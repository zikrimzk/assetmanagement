<?php

namespace App\Imports;

use App\Models\Area;
use App\Models\Company;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AreaImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $countError = 0;
        if(Area::where('area_code',$row['area_code'])->where('comp_id',Company::where('company_code',Str::upper($row['company_code']))->first()->id)->exists()){
            $countError += 1;

        }else{
            
            $data = new Area();
            $data->area_name = Str::headline($row['area_name']);
            $data->area_code = Str::upper($row['area_code']);
            $data->comp_id = Company::where('company_code',Str::upper($row['company_code']))->first()->id;
            $data->save();
        }
           
    }
}
