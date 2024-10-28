<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Area;
use App\Models\Asset;
use App\Models\Company;
use App\Models\AssetItem;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssetImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $compcode = Str::upper($row['comp_code']);
        $depcode = Str::upper($row['dep_code']);
        $areacode = Str::upper($row['area_code']);
        $itemcode = Str::upper($row['item_code']);

        $data = new Asset();
        $data->item_id = AssetItem::where('item_code', $itemcode )->first()->id;

        if($row['asset_serialno'] == '')
        {
            $serialno = '-';
        }
        else
        {
            $serialno = $row['asset_serialno'];
        }
        $data->asset_serialno = $serialno;

        if($row['asset_cost'] == ''){
            $cost = 0;
        }
        else{
            $cost = $row['asset_cost'];
        }
        $data->asset_cost =$cost;
        
        if($row['asset_marketval'] == ''){
            $market = 0;
        }
        else{
            $market = $row['asset_marketval'];
        }

        $data->asset_marketval =$market;

        if($row['asset_brand'] == '')
        {
            $brand = '-';
        }
        else
        {
            $brand = $row['asset_brand'];
        }
        $data->asset_brand = Str::headline($brand);
        $date = date_create($row['asset_date']);
        $data->asset_date =  date_format($date,"Y-m-d");
        // dd($data->asset_date =Carbon::createFromFormat('d/m/Y', $row['asset_date'])->format('Y-m-d'));

        if($row['asset_status'] == 'A' || $row['asset_status'] == 'a')
        {
            $status = 1; //ACTIVE
        }
        elseif($row['asset_status'] == 'UM' || $row['asset_status'] == 'um')
        {
            $status = 2; // UNDER MAINTENANCE
        }
        elseif($row['asset_status'] == 'B' || $row['asset_status'] == 'b')
        {
            $status = 3; // BROKEN
        }
        elseif($row['asset_status'] == 'D' || $row['asset_status'] == 'd')
        {
            $status = 4; // DISPOSE
        }
        else{
            $status = 1; // ACTIVE
        }
        $data->asset_status =$status;

        $data->comp_id = Company::where('company_code', $compcode)->first()->id;
        $data->dep_id = Department::where('department_code',$depcode)->first()->id;
        $data->area_id = Area::where('area_code',$areacode )->first()->id;
        if($row['asset_remarks'] == '')
        {
            $remarks = '-';
        }
        else
        {
            $remarks = $row['asset_remarks'];
        }
        $data->asset_remarks = $remarks;

        $type = AssetItem::where('item_code',$itemcode)->first();
        // Increment the numeric part
        $number = $type->item_count + 1;

        // Format the new ID with leading zeros
        $item_seq = sprintf('%04d', $number);
        $dateformated =Carbon::parse($row['asset_date'])->format('my');
        $data->asset_code =Str::upper($row['comp_code']).'/'.Str::upper($row['dep_code']).Str::upper($row['area_code']).'/'.Str::upper($row['item_code']).'/'.$dateformated.'/'.$item_seq;
        $data->staff_id = Auth::user()->id;
        $data->save();

        $seqno = AssetItem::where('item_code', Str::upper($row['item_code']))->first()->item_count;
        AssetItem::where('item_code', Str::upper($row['item_code']))->update(['item_count' => $seqno + 1]);
        


    }
}
