<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Area;
use App\Models\Asset;
use App\Models\Staff;
use App\Models\Company;
use App\Models\AssetItem;
use App\Models\AssetType;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\AssetTransfer;
use App\Charts\AssetValueChart;
use App\Charts\AssetCompanyChart;
use App\Charts\StaffCompanyChart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    /* 
    
    This controller includes : 
    - 

    Last Checked & Updated : 13-07-2024
    By Muhammad Zikri Bin Kashim, UTeM 

    */

    /* Main HomePage */
    public function indexMain(AssetCompanyChart $assetCompanyChart, StaffCompanyChart $staffCompanyChart, AssetValueChart $assetValueChart)
    {
        $costperitem = DB::table('asset_items as a')
            ->join('asset_types as b', 'a.type_id', 'b.id')
            ->join('assets as c', 'a.id', 'c.item_id')
            ->select(
                DB::raw('sum(c.asset_cost) as itemcost'),
                'a.item_code',
                'a.item_name',
                'a.item_count',
                'a.type_id',
                'b.type_name',
                'b.type_code',
            )
            ->groupBy(
                'a.item_code',
                'a.item_name',
                'a.item_count',
                'a.type_id',
                'b.type_name',
                'b.type_code',
            )
            ->get();
        $totalcost = DB::table('assets as a')
            ->select(
                DB::raw('sum(a.asset_cost) as totalcost'),
            )
            ->get();
        return view('Asset-Management.dashboard.user-index', [
            'title' => 'Dashboard',
            'chartassetcomp' => $assetCompanyChart->build(),
            'chartstaffcomp' => $staffCompanyChart->build(),
            'chartassetvalue' => $assetValueChart->build(),
            'item' => $costperitem,
            'totalassetvalue' => $totalcost,
            'type' => AssetType::where('type_count', '>=', 1)->get()


        ]);
    } //done

    /* My Profile */
    public function indexMyProfile()
    {
        return view('Asset-Management.dashboard.profile-index', [
            'title' => Auth::user()->staff_name . ' Profile',
            'user' => Staff::where('id', Auth::user()->id)->first(),
            'comp' => Company::where('id', Auth::user()->comp_id)->first()->company_name,
            'dep' => Department::where('id', Auth::user()->dep_id)->first()->department_name


        ]);
    } //done

    /* Asset Certificate */
    public function indexInfoAsset($id)
    {
        $data = DB::table('assets as a')
            ->join('companies as b', 'a.comp_id', 'b.id')
            ->join('departments as c', 'a.dep_id', 'c.id')
            ->join('areas as d', 'a.area_id', 'd.id')
            ->join('asset_items as e', 'a.item_id', 'e.id')
            ->select('a.id', 'a.asset_code', 'a.asset_serialno', 'e.item_name', 'b.company_name', 'c.department_name', 'd.area_name', 'e.item_code', 'a.asset_cost', 'a.asset_marketval', 'a.asset_brand', 'a.asset_remarks', 'a.asset_status', 'a.asset_date', 'a.comp_id', 'a.dep_id', 'a.area_id', 'a.asset_image')
            ->where('a.id', '=', $id)
            ->first();
        $transfer = DB::table('asset_transfers as a')
            ->join('staffs as b', 'a.transferby', 'b.id')
            ->join('staffs as c', 'a.approvedby', 'c.id')
            ->select('a.id', 'a.trans_description', 'a.trans_date', 'a.trans_status', 'a.asset_id', 'b.staff_name as transferby', 'c.staff_name as approvedby')
            ->where('a.asset_id', '=', $id)
            ->where('a.trans_status', '=', 2)
            ->get();
        $transferCount = DB::table('asset_transfers as a')
            ->join('staffs as b', 'a.transferby', 'b.id')
            ->join('staffs as c', 'a.approvedby', 'c.id')
            ->select('a.id', 'a.trans_description', 'a.trans_date', 'a.trans_status', 'a.asset_id', 'b.staff_name as transferby', 'c.staff_name as approvedby')
            ->where('a.asset_id', '=', $id)
            ->where('a.trans_status', '=', 2)
            ->count();

        return view('Asset-Management.Asset-Module.asset-info', [
            'title' => $data->asset_code,
            'ass' => $data,
            'transfer' => $transfer,
            'transfercount' => $transferCount,
            'user' => Staff::where('id', Auth::user()->id)->first()

        ]);
    } //done

    /* Asset Management Page */
    public function indexAssetManagement(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('assets as a')
                ->join('companies as b', 'a.comp_id', 'b.id')
                ->join('departments as c', 'a.dep_id', 'c.id')
                ->join('areas as d', 'a.area_id', 'd.id')
                ->join('asset_items as e', 'a.item_id', 'e.id')
                ->select('a.id', 'a.asset_code', 'a.asset_serialno', 'e.item_name', 'a.asset_cost', 'a.asset_marketval', 'a.asset_brand', 'a.asset_remarks', 'a.asset_status', 'a.comp_id', 'a.dep_id', 'a.area_id')
                ->where('asset_status', '!=', 5)
                ->orderby('a.created_at', 'asc')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('asset_code', function ($row) {
                $code = '<a class="btn btn-link text-primary" href="' . route('asset-info-index', $row->id) . '">' . $row->asset_code . '</a>';
                return $code;
            });
            $table->addColumn('asset_status', function ($row) {

                if ($row->asset_status == 1) {
                    $status = '<span class="badge bg-success">Active</span>';
                } elseif ($row->asset_status == 2) {
                    $status = '<span class="badge bg-warning">Under Maintenance</span>';
                } elseif ($row->asset_status == 3) {
                    $status = '<span class="badge bg-danger-transparent">Broken</span>';
                } elseif ($row->asset_status == 4) {
                    $status = '<span class="badge bg-danger">Disposed</span>';
                }

                return $status;
            });

            $table->addColumn('action', function ($row) {

                if (Auth::user()->staff_role == 1) {

                    if (AssetTransfer::where('asset_id', $row->id)->where('trans_status', 1)->exists() == true) {
                        $button = '
                        <div class="hstack gap-2 fs-15">
                            <a class="btn btn-icon btn-sm btn-warning rounded-pill disabled" href="' . route('asset-transfer-index', $row->id) . '"><i class="bx bx-transfer-alt"></i></a>
                            <a class="btn btn-icon btn-sm btn-light rounded-pill disabled" href="' . route('asset-update', $row->id) . '"><i class="ri-edit-line" style="color: rgb(0, 51, 153)"></i></a>
                            <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill disabled" data-bs-effect="effect-slide-in-bottom" data-bs-toggle="modal" data-bs-target="#modalDelete-' . $row->id . '"><i class="ri-delete-bin-line"></i></button>
                        </div>
                        ';
                    } else {
                        $button = '
                        <div class="hstack gap-2 fs-15">
                            <a class="btn btn-icon btn-sm btn-secondary rounded-pill" href="' . route('asset-transfer-index', $row->id) . '"><i class="bx bx-transfer-alt"></i></a>
                            <a class="btn btn-icon btn-sm btn-light rounded-pill" href="' . route('asset-update', $row->id) . '"><i class="ri-edit-line" style="color: rgb(0, 51, 153)"></i></a>
                        <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" data-bs-effect="effect-slide-in-bottom" data-bs-toggle="modal" data-bs-target="#modalDelete-' . $row->id . '"><i class="ri-delete-bin-line"></i></button>
                        </div>
                        ';
                    }
                } elseif (Auth::user()->staff_role == 2) {
                    if (AssetTransfer::where('asset_id', $row->id)->where('trans_status', 1)->exists() == true) {
                        $button = '
                        <div class="hstack gap-2 fs-15">
                            <a class="btn btn-icon btn-sm btn-warning rounded-pill disabled" href="' . route('asset-transfer-index', $row->id) . '"><i class="bx bx-transfer-alt"></i></a>
                        </div>
                        ';
                    } else {
                        $button = '
                        <div class="hstack gap-2 fs-15">
                            <a class="btn btn-icon btn-sm btn-secondary rounded-pill" href="' . route('asset-transfer-index', $row->id) . '"><i class="bx bx-transfer-alt"></i></a>
                        </div>
                        ';
                    }
                } elseif (Auth::user()->staff_role == 3) {

                    if (AssetTransfer::where('asset_id', $row->id)->where('trans_status', 1)->exists() == true) {
                        $button = '
                        <div class="hstack gap-2 fs-15">
                            <a class="btn btn-icon btn-sm btn-warning rounded-pill disabled" href="' . route('asset-transfer-index', $row->id) . '"><i class="bx bx-transfer-alt"></i></a>
                        </div>
                        ';
                    } else {
                        $button = '
                        <div class="hstack gap-2 fs-15">
                            <a class="btn btn-icon btn-sm btn-secondary rounded-pill" href="' . route('asset-transfer-index', $row->id) . '"><i class="bx bx-transfer-alt"></i></a>
                        </div>
                        ';
                    }
                }


                return $button;
            });
            $table->rawColumns(['asset_code', 'asset_status', 'action']);

            return $table->make(true);
        }

        $area = DB::table('areas as a')
            ->join('companies as b', 'a.comp_id', '=', 'b.id')
            ->select('a.id', 'a.area_name', 'a.area_code', 'b.company_name', 'b.company_code')
            ->get();

        return view('Asset-Management.Asset-Module.asset-index', [
            'title' => 'Asset Management',
            'comps' => Company::all(),
            'deps' => Department::all(),
            'areas' => $area,
            'types' => AssetType::all(),
            'items' => AssetItem::all(),
            'assets' => Asset::all()

        ]);
    } //done

    /* Asset Update Page */
    public function indexAssetUpdate($id)
    {
        if (Auth::user()->staff_role == 1) {
            $area = DB::table('areas as a')
                ->join('companies as b', 'a.comp_id', '=', 'b.id')
                ->select('a.id', 'a.area_name', 'a.area_code', 'b.company_name', 'b.company_code')
                ->get();
            return view('Asset-Management.Asset-Module.asset-update', [
                'title' => Asset::where('id', $id)->first()->asset_code,
                'comps' => Company::all(),
                'deps' => Department::all(),
                'areas' =>  $area,
                'types' => AssetType::all(),
                'items' => AssetItem::all(),
                'ass' => Asset::where('id', $id)->first()

            ]);
        } else {
            return redirect()->route('user-index');
        }
    } //done

    /* Asset Type Page */
    public function indexAssetType(Request $request)
    {
        if (Auth::user()->staff_role == 1 || Auth::user()->staff_role ==  2) {
            if ($request->ajax()) {

                $data = DB::table('asset_types')
                    ->select('id', 'type_name', 'type_code', 'type_count')
                    ->get();

                $table = DataTables::of($data)->addIndexColumn();

                $table->addColumn('action', function ($row) {

                    $button = '
                <div class="hstack gap-2 fs-15">
                    <button class="btn btn-icon btn-sm btn-light rounded-pill" data-bs-toggle="modal" data-bs-target="#modalUpdateAssetType-' . $row->id . '"><i class="ri-edit-line" style="color: rgb(0, 51, 153)"></i></button>
                    <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" data-bs-effect="effect-slide-in-bottom" data-bs-toggle="modal" data-bs-target="#modalDelete-' . $row->id . '"><i class="ri-delete-bin-line"></i></button>
                </div>
               
                ';

                    return $button;
                });
                $table->rawColumns(['action']);

                return $table->make(true);
            }
            return view('Asset-Management.Asset-Module.asset-type-index', [
                'title' => 'Asset Type',
                'types' => AssetType::all()
            ]);
        } else {
            return redirect()->route('user-index');
        }
    } //done

    /* Asset Item Page */
    public function indexAssetItem(Request $request)
    {
        if (Auth::user()->staff_role == 1 || Auth::user()->staff_role ==  2) {
            if ($request->ajax()) {

                $data = DB::table('asset_items as a')
                    ->join('asset_types as b', 'a.type_id', 'b.id')
                    ->select('a.id', 'a.item_name', 'a.item_code', 'b.type_name', 'a.item_count')
                    ->orderby('a.created_at', 'desc')
                    ->get();

                $table = DataTables::of($data)->addIndexColumn();

                $table->addColumn('action', function ($row) {

                    $button = '
                <div class="hstack gap-2 fs-15">
                    <button class="btn btn-icon btn-sm btn-light rounded-pill" data-bs-toggle="modal" data-bs-target="#modalUpdateAssetItem-' . $row->id . '"><i class="ri-edit-line" style="color: rgb(0, 51, 153)"></i></button>
                </div>
               
                ';

                    return $button;
                });
                $table->rawColumns(['action']);

                return $table->make(true);
            }
            return view('Asset-Management.Asset-Module.asset-item-index', [
                'title' => 'Asset Item',
                'types' => AssetType::all(),
                'items' => AssetItem::all()
            ]);
        } else {
            return redirect()->route('user-index');
        }
    } //done

    /* Asset Transfer */
    public function indexAssetTransfer($id)
    {
        return view('Asset-Management.Asset-Module.asset-transfer-index', [
            'title' => 'Asset Transfer',
            'comps' => Company::all(),
            'deps' => Department::all(),
            'areas' => Area::all(),
            'types' => AssetType::all(),
            'items' => AssetItem::all(),
            'ass' => Asset::where('id', $id)->first()

        ]);
    } //done

    /* Asset Transfer Approval */
    public function indexAssetTransferApproval(Request $request)
    {
        if (Auth::user()->staff_role == 1 || Auth::user()->staff_role ==  2) {
            if ($request->ajax()) {

                $data = DB::table('assets as a')
                    ->join('departments as c', 'a.dep_id', 'c.id')
                    ->join('areas as d', 'a.area_id', 'd.id')
                    ->join('asset_items as e', 'a.item_id', 'e.id')
                    ->join('asset_transfers as f', 'a.id', 'f.asset_id')
                    ->select('a.id', 'f.id as assetid', 'a.asset_code', 'e.item_name', 'c.department_name', 'd.area_name', 'f.trans_description', 'f.trans_date', 'f.trans_status', 'f.transferby')
                    ->where('f.trans_status', '=', 1)
                    ->get();

                $table = DataTables::of($data)->addIndexColumn();
                $table->addColumn('asset_code', function ($row) {
                    $code = '<a class="btn btn-link text-primary" href="' . route('asset-info-index', $row->id) . '">' . $row->asset_code . '</a>';
                    return $code;
                });
                $table->addColumn('trans_status', function ($row) {

                    if ($row->trans_status == 1) {
                        $status = '<span class="badge bg-warning">Pending</span>';
                    } elseif ($row->trans_status == 2) {
                        $status = '<span class="badge bg-success">Approved</span>';
                    }

                    return $status;
                });

                $table->addColumn('transferby', function ($row) {

                    return Staff::where('id', $row->transferby)->first()->staff_name;
                });

                $table->addColumn('action', function ($row) {

                    $button = '
                    <div class="hstack gap-2 fs-15">
                        <a class="btn btn-icon btn-sm btn-success rounded-pill" data-bs-effect="effect-slide-in-bottom" data-bs-toggle="modal" data-bs-target="#modalApprove-' . $row->assetid . '"><i class="bx bx-check"></i></a>
                        <button class="btn btn-icon btn-sm btn-danger rounded-pill" data-bs-effect="effect-slide-in-bottom" data-bs-toggle="modal" data-bs-target="#modalReject-' . $row->assetid . '"><i class="bx bxs-x-circle"></i></button>
                    </div>
                   
                    ';

                    return $button;
                });
                $table->rawColumns(['asset_code', 'trans_status', 'transferby', 'action']);

                return $table->make(true);
            }

            return view('Asset-Management.Asset-Module.asset-approval-index', [
                'title' => 'Asset Transfer Approval',
                'assets' => AssetTransfer::all()

            ]);
        } else {
            return redirect()->route('user-index');
        }
    } //done

    /* Asset Transfer Approval Log*/
    public function indexAssetTransferLog(Request $request)
    {
        if (Auth::user()->staff_role == 1 || Auth::user()->staff_role ==  2) {

            if ($request->ajax()) {

                if (Auth::user()->staff_role == 1) {
                    $data = DB::table('assets as a')
                        ->join('departments as c', 'a.dep_id', 'c.id')
                        ->join('areas as d', 'a.area_id', 'd.id')
                        ->join('asset_items as e', 'a.item_id', 'e.id')
                        ->join('asset_transfers as f', 'a.id', 'f.asset_id')
                        ->select('a.id', 'f.id as assetid', 'a.asset_code', 'e.item_name', 'c.department_name', 'd.area_name', 'f.trans_description', 'f.trans_date', 'f.trans_status', 'f.transferby', 'f.approvedby')
                        ->where('f.trans_status', '!=', 1)
                        ->get();
                } elseif (Auth::user()->staff_role == 2) {
                    $data = DB::table('assets as a')
                        ->join('departments as c', 'a.dep_id', 'c.id')
                        ->join('areas as d', 'a.area_id', 'd.id')
                        ->join('asset_items as e', 'a.item_id', 'e.id')
                        ->join('asset_transfers as f', 'a.id', 'f.asset_id')
                        ->select('a.id', 'f.id as assetid', 'a.asset_code', 'e.item_name', 'c.department_name', 'd.area_name', 'f.trans_description', 'f.trans_date', 'f.trans_status', 'f.transferby', 'f.approvedby')
                        ->where('f.trans_status', '!=', 1)
                        ->where('f.approvedby', '=', Auth::user()->id)
                        ->get();
                }

                $table = DataTables::of($data)->addIndexColumn();
                $table->addColumn('trans_status', function ($row) {

                    if ($row->trans_status == 2) {
                        $status = '<span class="badge bg-success-transparent">Approved</span>';
                    } elseif ($row->trans_status == 3) {
                        $status = '<span class="badge bg-danger-transparent">Rejected</span>';
                    }

                    return $status;
                });

                $table->addColumn('transferby', function ($row) {

                    return Staff::where('id', $row->transferby)->first()->staff_name;
                });
                $table->addColumn('approvedby', function ($row) {

                    return Staff::where('id', $row->approvedby)->first()->staff_name;
                });
                $table->rawColumns(['trans_status', 'transferby', 'approvedby']);

                return $table->make(true);
            }

            return view('Asset-Management.Asset-Module.asset-transfer-log', [
                'title' => 'Asset Transfer Approval',
                'assets' => AssetTransfer::all()

            ]);
        } else {
            return redirect()->route('user-index');
        }
    } //done

    /* Asset Delete Log */
    public function indexAssetDeleteLog(Request $request)
    {
        if (Auth::user()->staff_role == 1) {
            if ($request->ajax()) {

                $data = DB::table('assets as a')
                    ->join('companies as b', 'a.comp_id', 'b.id')
                    ->join('departments as c', 'a.dep_id', 'c.id')
                    ->join('areas as d', 'a.area_id', 'd.id')
                    ->join('asset_items as e', 'a.item_id', 'e.id')
                    ->select('a.id', 'a.asset_code', 'a.asset_serialno', 'e.item_name', 'a.asset_cost', 'a.asset_marketval', 'a.asset_brand', 'a.asset_remarks', 'a.asset_status', 'a.comp_id', 'a.dep_id', 'a.area_id')
                    ->where('asset_status', '=', 5)
                    ->orderby('a.created_at', 'asc')
                    ->get();

                $table = DataTables::of($data)->addIndexColumn();
                $table->addColumn('asset_status', function ($row) {

                    if ($row->asset_status == 5) {
                        $status = '<span class="badge bg-danger">Deleted</span>';
                    }
                    return $status;
                });

                $table->addColumn('action', function ($row) {

                    $button = '
                    <div class="hstack gap-2 fs-15">
                        <a class="btn btn-icon btn-sm btn-light rounded-pill" data-bs-effect="effect-slide-in-bottom" data-bs-toggle="modal" data-bs-target="#modalRecover-' . $row->id . '"><i class="bx bx-revision" style="color: rgb(0, 51, 153)"></i></a>
                    </div>
                   
                    ';

                    return $button;
                });
                $table->rawColumns(['asset_status', 'action']);

                return $table->make(true);
            }

            return view('Asset-Management.Asset-Module.asset-delete-log-index', [
                'title' => 'Asset Delete Log',
                'assets' => Asset::all()

            ]);
        } else {
            return redirect()->route('user-index');
        }
    } //done

    /* Company Management Page */
    public function indexCompanyManagement(Request $request)
    {
        if (Auth::user()->staff_role == 1) {
            if ($request->ajax()) {

                $data = DB::table('companies')
                    ->select('id', 'company_name', 'company_code', 'company_phone', 'company_email', 'company_address', 'company_registno')
                    ->orderby('created_at', 'asc')
                    ->get();

                $table = DataTables::of($data)->addIndexColumn();

                $table->addColumn('action', function ($row) {

                    $button = '
                    <div class="hstack gap-2 fs-15">
                        <a class="btn btn-icon btn-sm btn-light rounded-pill" href="' . route('company-profile', $row->id) . '"><i class="ri-edit-line" style="color: rgb(0, 51, 153)"></i></a>
                        <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" data-bs-effect="effect-slide-in-bottom" data-bs-toggle="modal" data-bs-target="#modalDelete-' . $row->id . '"><i class="ri-delete-bin-line"></i></button>
                    </div>
                
                    ';

                    return $button;
                });
                $table->rawColumns(['action']);

                return $table->make(true);
            }

            return view("Asset-Management.Setting.company-index", [
                'title' => 'Company Management',
                'comps' => Company::all()
            ]);
        } else {
            return redirect()->route('user-index');
        }
    } //done

    /* Company Profile Page */
    public function indexCompanyProfile($code)
    {
        if (Auth::user()->staff_role == 1) {
            try {
                if (Company::where('id', $code)->exists() == true) {
                    return view("Asset-Management.Setting.company-profile", [
                        'title' => 'Company Profile',
                        'comp' => Company::where('id', $code)->first()
                    ]);
                } else {
                    dd("error");
                }
            } catch (Exception) {
                dd("error");
            }
        } else {
            return redirect()->route('user-index');
        }
    } //done

    /* Area Management Page */
    public function indexAreaSetting(Request $request)
    {
        if (Auth::user()->staff_role == 1) {
            if ($request->ajax()) {

                $data = DB::table('areas as a')
                    ->join('companies as b', 'a.comp_id', 'b.id')
                    ->select('a.id', 'a.area_name', 'a.area_code', 'b.company_name')
                    ->get();

                $table = DataTables::of($data)->addIndexColumn();

                $table->addColumn('action', function ($row) {

                    $button = '
                    <div class="hstack gap-2 fs-15">
                        <button class="btn btn-icon btn-sm btn-light rounded-pill" data-bs-toggle="modal" data-bs-target="#modalUpdateArea-' . $row->id . '"><i class="ri-edit-line" style="color: rgb(0, 51, 153)"></i></button>
                        <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" data-bs-effect="effect-slide-in-bottom" data-bs-toggle="modal" data-bs-target="#modalDelete-' . $row->id . '"><i class="ri-delete-bin-line"></i></button>
                    </div>
                
                    ';

                    return $button;
                });
                $table->rawColumns(['action']);

                return $table->make(true);
            }
            return view("Asset-Management.Setting.area-index", [
                'title' => 'Area Management',
                'comps' => Company::all(),
                'areas' => Area::all()

            ]);
        } else {
            return redirect()->route('user-index');
        }
    } //done

    /* Department Management Page */
    public function indexDepartmentManagement(Request $request)
    {
        if (Auth::user()->staff_role == 1) {
            if ($request->ajax()) {

                $data = DB::table('departments')
                    ->select('id', 'department_name', 'department_code')
                    ->get();

                $table = DataTables::of($data)->addIndexColumn();

                $table->addColumn('action', function ($row) {

                    $button = '
                <div class="hstack gap-2 fs-15">
                    <button class="btn btn-icon btn-sm btn-light rounded-pill" data-bs-toggle="modal" data-bs-target="#modalUpdateDepartment-' . $row->id . '"><i class="ri-edit-line" style="color: rgb(0, 51, 153)"></i></button>
                    <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" data-bs-effect="effect-slide-in-bottom" data-bs-toggle="modal" data-bs-target="#modalDelete-' . $row->id . '"><i class="ri-delete-bin-line"></i></button>
                </div>
               
                ';

                    return $button;
                });
                $table->rawColumns(['action']);

                return $table->make(true);
            }
            return view("Asset-Management.Setting.department-index", [
                'title' => 'Department Management',
                'comp' => Company::where('id', 1)->first(),
                'deps' => Department::all()

            ]);
        } else {
            return redirect()->route('user-index');
        }
    } //done

    /* Staff Management Page */
    public function indexStaffManagement(Request $request)
    {
        if (Auth::user()->staff_role == 1) {
            if ($request->ajax()) {

                $data = DB::table('staffs as a')
                    ->join('companies as b', 'a.comp_id', 'b.id')
                    ->join('departments as c', 'a.dep_id', 'c.id')
                    ->select('a.id', 'a.staff_no', 'a.staff_name', 'a.staff_phone', 'a.email', 'b.company_name', 'c.department_name', 'a.staff_role', 'a.staff_status')
                    ->where('a.staff_status', '!=', 3)
                    ->get();

                $table = DataTables::of($data)->addIndexColumn();
                $table->addColumn('staff_role', function ($row) {

                    if ($row->staff_role == 1) {
                        $role = '<span class="badge bg-danger">Admin</span>';
                    } elseif ($row->staff_role == 2) {
                        $role = '<span class="badge bg-secondary">Staff</span>';
                    } elseif ($row->staff_role == 3) {
                        $role = '<span class="badge bg-secondary-transparent">Viewer</span>';
                    } elseif ($row->staff_role == 5) {
                        $role = '<span class="badge bg-dark">Super Admin</span>';
                    }

                    return $role;
                });
                $table->addColumn('staff_status', function ($row) {
                    if ($row->staff_status == 0) {
                        $status = '<span class="badge bg-danger">Not Activated</span>';
                    } elseif ($row->staff_status == 1) {
                        $status = '<span class="badge bg-success">Active</span>';
                    } elseif ($row->staff_status == 2) {
                        $status = '<span class="badge bg-warning">Inactive</span>';
                    } elseif ($row->staff_status == 3) {
                        $status = '<span class="badge bg-danger">Terminated</span>';
                    }

                    return $status;
                });

                $table->addColumn('action', function ($row) {

                    $button = '
                    <div class="hstack gap-2 fs-15">
                        <button class="btn btn-icon btn-sm btn-light rounded-pill" data-bs-toggle="modal" data-bs-target="#modalUpdateStaff-' . $row->id . '"><i class="ri-edit-line" style="color: rgb(0, 51, 153)"></i></button>
                        <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" data-bs-effect="effect-slide-in-bottom" data-bs-toggle="modal" data-bs-target="#modalDelete-' . $row->id . '"><i class="ri-delete-bin-line"></i></button>

                    </div>
                   
                    ';

                    return $button;
                });
                $table->rawColumns(['staff_role', 'staff_status', 'action']);

                return $table->make(true);
            }
            return view("Asset-Management.Setting.staff-index", [
                'title' => 'Staff Management',
                'comps' => Company::all(),
                'deps' => Department::all(),
                'staffs' => Staff::all()

            ]);
        } else {
            return redirect()->route('user-index');
        }
    } // done

}
