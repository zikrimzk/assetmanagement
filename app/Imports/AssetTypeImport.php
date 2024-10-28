<?php

namespace App\Imports;

use App\Models\AssetType;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssetTypeImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $countError= 0;

        if(AssetType::where('type_code',Str::upper($row['type_code']))->exists()){
            $countError += 1;

        }else{
            $data = new AssetType();
            $data->type_name = Str::headline($row['type_name']);
            $data->type_code = Str::upper($row['type_code']);
            $data->save();
        }
            
    }
}
