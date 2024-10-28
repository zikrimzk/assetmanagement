<?php

namespace App\Imports;

use App\Models\AssetItem;
use App\Models\AssetType;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssetItemImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $type = AssetType::where('type_code', Str::upper($row['type_code']))->first();
        
        // Increment the numeric part
        $number = $type->type_count + 1;
        // Format the new ID with leading zeros
        $item_code = $type->type_code . sprintf('%02d', $number);
        $data = new AssetItem();
        $data->item_name = Str::headline($row['item_name']);
        $data->item_code = $item_code;
        $data->type_id = $type->id;
        $data->save();

        // Update Representative Type Count Upon Importing
        $seqno = AssetType::where('id',$type->id)->first()->type_count;
        AssetType::where('id',$type->id)->update(['type_count'=>$seqno+1]);
    }
}
