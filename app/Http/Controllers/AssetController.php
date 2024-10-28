<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Area;
use App\Models\Asset;
use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AssetItem;
use App\Models\AssetType;
use App\Models\Department;
use Illuminate\Support\Str;
use App\Exports\AssetExport;
use App\Imports\AssetImport;
use Illuminate\Http\Request;
use App\Models\AssetTransfer;
use App\Exports\AssetItemExport;
use App\Exports\AssetTypeExport;
use App\Imports\AssetItemImport;
use App\Imports\AssetTypeImport;
use App\Exports\AssetCustomExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{

    /* 
    
    This controller includes : 
    - Asset Type 
    - Asset Item
    - Asset Management
    - Asset Transfer
    - Asset Transfer Approval 
    - Asset Delete Log

    Last Checked & Updated : 13-07-2024
    By Muhammad Zikri Bin Kashim, UTeM 

    */

    /* Asset Type Process */
    public function createAssetType(Request $request)
    {
        try {
            $validated = $request->validate([
                'type_name' => 'required',
                'type_code' => 'required | unique:asset_types'
            ]);
            $validated['type_name'] = Str::headline($validated['type_name']);
            $validated['type_code'] = Str::upper($validated['type_code']);
            AssetType::create($validated);
            return back()->with('success', 'Asset type details successfully added.');
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function editAssetType(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'type_name' => 'required',
                'type_code' => 'required'
            ]);
            $validated['type_name'] = Str::headline($validated['type_name']);
            $validated['type_code'] = Str::upper($validated['type_code']);

            AssetType::where('id', $id)->update($validated);

            return back()->with('success', 'Asset type details successfully updated.');
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function destroyAssetType($id)
    {
        try {
            AssetType::where('id', $id)->delete();
            return back()->with('success', 'Asset type details successfully deleted.');
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function importAssetType()
    {
        try {
            Excel::import(new AssetTypeImport, request()->file('file'));
            return back()->with('success', 'Asset type data successfully imported.');;
        } catch (Exception $e) {
            return back()->with('error', 'EIE' . $e->getLine() . ': Duplicate data or template format issue, It appears that the data you are trying to insert already exists, or the template format has changed. Please review your data and try again. The details : ' . $e->getMessage());
        }
    } //done

    public function exportExcelAssetType()
    {
        return Excel::download(new AssetTypeExport, 'type-data-export.xlsx');
    } //done

    public function exportPdfAssetType()
    {
        return Excel::download(new AssetTypeExport, 'type-data-export.pdf', \Maatwebsite\Excel\Excel::MPDF);
    } //done


    /* Asset Item Process */
    public function createAssetItem(Request $request)
    {
        try {
            $validated = $request->validate([
                'item_name' => 'required',
                'item_code' => 'required | unique:asset_items',
                'type_id'   => 'required'
            ]);
            $validated['item_name'] = Str::headline($validated['item_name']);
            AssetItem::create($validated);
            $seqno = AssetType::where('id', $validated['type_id'])->first()->type_count;
            AssetType::where('id', $validated['type_id'])->update(['type_count' => $seqno + 1]);
            return back()->with('success', 'Asset item details successfully added.');
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function editAssetItem(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'item_name' => 'required',
                'item_code' => 'required',
                'type_id'   => 'required'
            ]);
            $validated['item_name'] = Str::headline($validated['item_name']);
            AssetItem::where('id', $id)->update($validated);
            return back()->with('success', 'Asset item details successfully updated.');
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function destroyAssetItem($id)
    {
        try {
            AssetItem::where('id', $id)->delete();
            return back()->with('success', 'Asset item details successfully deleted.');
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //Practicaly not be used due to uneditable code generation, But the function is there for future needs or improvements

    public function importAssetItem()
    {
        try {
            Excel::import(new AssetItemImport, request()->file('file'));
            return back()->with('success', 'Asset item data successfully imported.');;
        } catch (Exception $e) {
            return back()->with('error', 'EIE' . $e->getLine() . ': Duplicate data or template format issue, It appears that the data you are trying to insert already exists, or the template format has changed. Please review your data and try again. The details : ' . $e->getMessage());
        }
    } //done

    public function exportExcelAssetItem()
    {
        return Excel::download(new AssetItemExport, 'item-data-export.xlsx');
    } //done

    public function exportPdfAssetItem()
    {
        return Excel::download(new AssetItemExport, 'item-data-export.pdf', \Maatwebsite\Excel\Excel::MPDF);
    } //done

    public function updateSeqItem(Request $request)
    {
        $ai = AssetType::where('id', $request->type_id)->first();
        // Increment the numeric part
        $number = $ai->type_count + 1;

        // Format the new ID with leading zeros
        $data = $ai->type_code . sprintf('%02d', $number);
        return response()->json(['data' => $data]);
    } //done


    /* Asset Management Process */
    public function createAsset(Request $request)
    {
        try {
            if ($request->file('asset_image')) {
                $upImage = $request->file('asset_image')->store('assetimage');
            } else {
                $upImage = '';
            }
            $validated = $request->validate([
                'asset_code' => 'required | unique:assets',
                'asset_cost' => '',
                'asset_marketval' => '',
                'asset_brand' => '',
                'asset_serialno' => '',
                'asset_remarks' => '',
                'asset_image' => '',
                'asset_date' => 'required',
                'asset_status' => 'required',
                'comp_id' => 'required',
                'dep_id' => 'required',
                'area_id' => 'required',
                'item_id' => 'required',
                'staff_id' => 'required',

            ]);
            $validated['comp_id'] = Company::where('company_code', $validated['comp_id'])->first()->id;
            $validated['dep_id'] = Department::where('department_code', $validated['dep_id'])->first()->id;
            $validated['area_id'] = Area::where('area_code', $validated['area_id'])->first()->id;
            $validated['item_id'] = AssetItem::where('item_code', $validated['item_id'])->first()->id;
            $validated['asset_image'] = $upImage;
            Asset::create($validated);
            $seqno = AssetItem::where('id', $validated['item_id'])->first()->item_count;
            AssetItem::where('id', $validated['item_id'])->update(['item_count' => $seqno + 1]);
            return response()->json(['success' => 'Asset declared successfully.']);
        } catch (Exception $e) {
            return response()->json(['error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage()]); 
        }
    } //done

    public function editAsset(Request $request, $id)
    {
        try {

            if ($request->image_isHaveChange == "T") {
                //Update Asset With Image Change
                if ($request->file('asset_image')) {
                    $upImage = $request->file('asset_image')->store('assetimage');
                } else {
                    $upImage = '';
                }
                $validated = $request->validate([
                    'asset_code' => 'required',
                    'asset_cost' => '',
                    'asset_marketval' => '',
                    'asset_brand' => '',
                    'asset_serialno' => 'required',
                    'asset_remarks' => '',
                    'asset_date' => 'required',
                    'asset_status' => 'required',
                    'asset_image' => '',
                    'comp_id' => 'required',
                    'dep_id' => 'required',
                    'area_id' => 'required',
                    'item_id' => 'required',
                ]);
                $validated['asset_image'] = $upImage;
            }
            else{
                //Update Asset Without Image Change
                $validated = $request->validate([
                    'asset_code' => 'required',
                    'asset_cost' => '',
                    'asset_marketval' => '',
                    'asset_brand' => '',
                    'asset_serialno' => 'required',
                    'asset_remarks' => '',
                    'asset_date' => 'required',
                    'asset_status' => 'required',
                    'comp_id' => 'required',
                    'dep_id' => 'required',
                    'area_id' => 'required',
                    'item_id' => 'required',
                ]);

            }

            $validated['comp_id'] = Company::where('company_code', $validated['comp_id'])->first()->id;
            $validated['dep_id'] = Department::where('department_code', $validated['dep_id'])->first()->id;
            $validated['area_id'] = Area::where('area_code', $validated['area_id'])->first()->id;

            Asset::where('id', $id)->update($validated);
            return redirect()->route('asset-index')->with('success', 'Asset declaration details successfully updated.');
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function destroyTempAsset($id)
    {
        try {
            Asset::where('id', $id)->update(['asset_status' => 5]);
            return redirect()->route('asset-index')->with('success', 'The asset details have been deleted. You can recover the asset if needed.');
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function destroyAsset($id)
    {
        try {
            Asset::where('id', $id)->delete();
            return back()->with('success', 'Asset details successfully deleted !');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    } //Practicaly not be used due to uneditable code generation, But the function is there for future needs or improvements

    public function importAsset()
    {
        try {
            Excel::import(new AssetImport, request()->file('file'));
            return redirect()->route('asset-index')->with('success', 'Asset declaration data successfully imported.');
        } catch (Exception $e) {
            return redirect()->route('asset-index')->with('error', 'EIE' . $e->getLine() . ': Duplicate data or template format issue, It appears that the data you are trying to insert already exists, or the template format has changed. Please review your data and try again. The details : ' . $e->getMessage());
        }
    } //done

    public function exportExcelAsset()
    {
        return Excel::download(new AssetExport, 'asset-data-export.xlsx');
    } //done

    public function exportPdfAsset()
    {
        return Excel::download(new AssetExport, 'asset-data-export.pdf', \Maatwebsite\Excel\Excel::MPDF);
    } //done

    public function exportCustomExcel(Request $request)
    {
        return Excel::download(new AssetCustomExport($request->comp_id, $request->dep_id, $request->area_id), 'custom-asset-export.xlsx');
    } //done 

    public function updateSeqAsset(Request $request)
    {
        $ai = AssetItem::where('item_code', $request->item_code)->first();
        // Increment the numeric part
        $number = $ai->item_count + 1;

        // Format the new ID with leading zeros
        $data = sprintf('%04d', $number);
        return response()->json(['data' => $data]);
    } //done

    public function downloadQr($id)
    {
        $data = Asset::where('id', $id)->first();
        $pdf = PDF::loadView('Asset-Management.Asset-Module.asset-qrcode-page', [
            'title' => $data->asset_code,
            'id' => $id,
            'ass' => $data
        ]);
        return $pdf->download($data->asset_code . '.pdf');
    } //done


    /* Asset Transfer Process */
    public function createAssetTransfer(Request $request)
    {
        try {
            if (Auth::user()->staff_role == 3) {
                //VIEWER FOLLOWS THE APPROVAL PROCCESS 
                $data = new AssetTransfer();
                if ($request->trans_1 != '' && $request->trans_2 != '') {
                    $desc = 'Asset transfered to ' . $request->trans_1 . ' and ' . $request->trans_2;
                } elseif ($request->trans_1 != '') {
                    $desc = 'Asset transfered to ' . $request->trans_1;
                } elseif ($request->trans_2 != '') {
                    $desc = 'Asset transfered to ' . $request->trans_2;
                }

                $data->trans_description = $desc;
                $data->trans_date = Carbon::now("Asia/Kuala_Lumpur")->toDateTimeString();
                $data->new_dep = $request->dep_id;
                $data->new_area = $request->area_id;
                $data->asset_id = $request->asset_id;
                $data->transferby = $request->transferby_staffid;
                $data->approvedby = 0;
                $data->save();
                return redirect()->route('asset-index')->with('success', 'Asset transfer submitted successfully. The changes will be made after admin approves the transfer details.');
            } elseif (Auth::user()->staff_role == 1 || Auth::user()->staff_role == 2) {
                //ADMIN & STAFF APPROVE AND VERIFIED THEMSELVES
                $data = new AssetTransfer();
                if ($request->trans_1 != '' && $request->trans_2 != '') {
                    $desc = 'Asset transfered to ' . $request->trans_1 . ' and ' . $request->trans_2;
                } elseif ($request->trans_1 != '') {
                    $desc = 'Asset transfered to ' . $request->trans_1;
                } elseif ($request->trans_2 != '') {
                    $desc = 'Asset transfered to ' . $request->trans_2;
                }

                $data->trans_description = $desc;
                $data->trans_date = Carbon::now("Asia/Kuala_Lumpur")->toDateTimeString();
                $data->new_dep = $request->dep_id;
                $data->new_area = $request->area_id;
                $data->asset_id = $request->asset_id;
                $data->trans_status = 2;
                $data->transferby = $request->transferby_staffid;
                $data->approvedby = $request->transferby_staffid;
                $data->save();

                Asset::where('id', $request->asset_id)->update(['dep_id' => $request->dep_id, 'area_id' => $request->area_id]);
                return redirect()->route('asset-index')->with('success', 'Asset transfer has successfully transfered and verified.');
            }
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done


    /* Asset Transfer Approval Process */
    public function approveAssetTransfer($id)
    {
        try {
            $data = AssetTransfer::where('id', $id)->first();

            Asset::where('id', $data->asset_id)->update([
                'dep_id' => $data->new_dep,
                'area_id' => $data->new_area
            ]);

            AssetTransfer::where('id', $id)->update([
                'trans_status' => 2,
                'approvedby' => Auth::user()->id
            ]);

            return redirect()->route('asset-transfer-approval-index')->with('success', 'Asset transfer has successfully transfered and verified.');
        } catch (Exception $e) {
            return back()->with('error', 'EA' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function rejectAssetTransfer($id)
    {
        try {
            AssetTransfer::where('id', $id)->update([
                'trans_status' => 3,
                'approvedby' => Auth::user()->id
            ]);
            return redirect()->route('asset-transfer-approval-index')->with('success', 'Asset transfer request has been rejected. No changes will be made.');
        } catch (Exception $e) {
            return back()->with('error', 'EA' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done


    /* Asset Delete Log Process */
    public function recoverTempAsset($id)
    {
        try {
            Asset::where('id', $id)->update(['asset_status' => 1]);
            return back()->with('success', 'Asset successfully recovered.');
        } catch (Exception $e) {
            return back()->with('error', 'ERD' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done
}
