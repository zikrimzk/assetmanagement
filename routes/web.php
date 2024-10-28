<?php

use App\Models\Area;
use App\Models\Department;
use App\Models\AssetTransfer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SqlExportController;
use App\Http\Controllers\AuthenticateController;


/*
    -------Version Control -------
    AssetTrack - Ver 2.5 
    Date : 24/07/2024
    Update Reason : 
        - Adding manual book for every role
        - Fixes the bugs on the dashboard counting 
        - Fixes the installation process that occur an error before
        - Add some security code for authentication and access control.
        - Add backup to SQL option
        - Reduce code for optimization
    Updated by : MUHAMMAD ZIKRI BIN KASHIM, Zeeke Software Solutions
 */

/*-------Login Route ------- */
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', function () {
    return redirect()->route('login');
});

Route::prefix('login')->group(function () {
    //Authenticate Route 13-6-2024
    Route::get('/index', [AuthenticateController::class, 'indexLogin'])->name('login');
    Route::get('/installation-process', [AuthenticateController::class, 'installationProcess'])->name('installation-system');

    //Authenticate Process
    Route::post('/authenticate-process', [AuthenticateController::class, 'authenticate'])->name('auth-process');
    Route::get('/logout-process', [AuthenticateController::class, 'logout'])->middleware('auth:staffs')->name('logout-process');

    //Authenticate First Time Login 14-7-2024
    Route::get('/first-time-login-{id}', [AuthenticateController::class, 'indexPasswordChange'])->name('firsttimelogin');
    Route::post('/password-process-{id}', [AuthenticateController::class, 'updateFirstTimePassword'])->name('first-time-process');
});

/*-------Dashboard / Profile Route ------- */
Route::get('/main', function () {
    return redirect()->route('user-index');
});

Route::prefix('main')->middleware('auth:staffs')->group(function () {

    //Dashboard 
    Route::get('/dashboard', [DashboardController::class, 'indexMain'])->name('user-index');

    //DO NOT TOUCH THIS FUNCTION ! ALERT 
    Route::get('/assettrack-activation', [AuthenticateController::class, 'SystemUpDown'])->name('systemupdown');

    //System SQL download .. DO NOT TOUCH THIS FUNCTION ! ALERT 
    Route::get('/assettrack-download-sql', [SqlExportController::class, 'downloadSql'])->name('downloadsql');

    //My Profile
    Route::get('/my-profile', [DashboardController::class, 'indexMyProfile'])->name('profile-index');
    Route::post('/my-profile-process-{code}', [StaffController::class, 'updateProfile'])->name('profile-update-post');
    Route::post('/my-password-process-{code}', [StaffController::class, 'updatePassword'])->name('password-update-post');
});

/*-------Asset Management Route ------- */
Route::prefix('asset')->middleware('auth:staffs')->group(function () {

    //Asset Type 13-06-2024
    Route::get('/asset-type', [DashboardController::class, 'indexAssetType'])->name('asset-type-index');

    //Asset Type Setting Process
    Route::post('/asset-type-add-process', [AssetController::class, 'createAssetType'])->name('asset-type-add-post');
    Route::post('/asset-type-edit-process-{code}', [AssetController::class, 'editAssetType'])->name('asset-type-edit-post');
    Route::get('/asset-type-delete-process-{id}', [AssetController::class, 'destroyAssetType'])->name('asset-type-delete-get-post');

    //Asset Type Import & Export
    Route::post('/asset-type-import-process', [AssetController::class, 'importAssetType'])->name('asset-type-import-post');
    Route::get('/asset-type-export-excel-process', [AssetController::class, 'exportExcelAssetType'])->name('asset-type-export-excel-get');
    Route::get('/asset-type-export-pdf-process', [AssetController::class, 'exportPdfAssetType'])->name('asset-type-export-pdf-get');

    //Asset Item 13-06-2024
    Route::get('/asset-item', [DashboardController::class, 'indexAssetItem'])->name('asset-item-index');

    //Asset Item Setting Process
    Route::post('/asset-item-add-process', [AssetController::class, 'createAssetItem'])->name('asset-item-add-post');
    Route::post('/update-seq-count', [AssetController::class, 'updateSeqItem'])->name('update-seq-item');
    Route::post('/asset-item-edit-process-{code}', [AssetController::class, 'editAssetItem'])->name('asset-item-edit-post');
    Route::get('/asset-item-delete-process-{id}', [AssetController::class, 'destroyAssetItem'])->name('asset-item-delete-get-post');

    //Asset Item Import & Export
    Route::post('/asset-item-import-process', [AssetController::class, 'importAssetItem'])->name('asset-item-import-post');
    Route::get('/asset-item-export-excel-process', [AssetController::class, 'exportExcelAssetItem'])->name('asset-item-export-excel-get');
    Route::get('/asset-item-export-pdf-process', [AssetController::class, 'exportPdfAssetItem'])->name('asset-item-export-pdf-get');

    //Asset Management 13-06-2024
    Route::get('/asset-management', [DashboardController::class, 'indexAssetManagement'])->name('asset-index');
    Route::get('/asset-update-{id}', [DashboardController::class, 'indexAssetUpdate'])->name('asset-update');


    //Asset Management Process
    Route::post('/asset-add-process', [AssetController::class, 'createAsset'])->name('asset-add-post');
    Route::post('/asset-edit-process-{code}', [AssetController::class, 'editAsset'])->name('asset-edit-post');
    Route::get('/asset-delete-process-{id}', [AssetController::class, 'destroyAsset'])->name('asset-delete-get-post');
    Route::get('/asset-temp-delete-process-{id}', [AssetController::class, 'destroyTempAsset'])->name('asset-temp-delete-get-post');
    Route::post('/update-seq-asset', [AssetController::class, 'updateSeqAsset'])->name('asset-update-seq');


    //Asset Management Import & Export
    Route::post('/asset-import-process', [AssetController::class, 'importAsset'])->name('asset-import-post');
    Route::get('/asset-export-excel-process', [AssetController::class, 'exportExcelAsset'])->name('asset-export-excel-get');
    Route::get('/asset-export-pdf-process', [AssetController::class, 'exportPdfAsset'])->name('asset-export-pdf-get');
    Route::post('/asset-export-pdf-process-custom', [AssetController::class, 'exportCustomExcel'])->name('asset-export-custom-excel');

    //Asset Certificate QR Code Generator 10-07-2024
    Route::get('/info-qr-code-download-{id}', [AssetController::class, 'downloadQr'])->name('asset-download-qr');


    //Asset Delete Log 22-06-2024
    Route::get('/asset-delete-log', [DashboardController::class, 'indexAssetDeleteLog'])->name('asset-delete-log-index');
    Route::get('/asset-recover-process-{id}', [AssetController::class, 'recoverTempAsset'])->name('asset-recover-process');


    //Asset Transfer 24-06-2024
    Route::get('/asset-transfer-{id}', [DashboardController::class, 'indexAssetTransfer'])->name('asset-transfer-index');

    //Asset Transfer Process
    Route::post('/asset-transfer-process', [AssetController::class, 'createAssetTransfer'])->name('asset-transfer-post');


    //Asset Transfer Approval 24-06-2024
    Route::get('/asset-approval', [DashboardController::class, 'indexAssetTransferApproval'])->name('asset-transfer-approval-index');

    //Asset Transfer Process
    Route::get('/asset-approval-process-{id}', [AssetController::class, 'approveAssetTransfer'])->name('asset-approval-process');
    Route::get('/asset-rejection-process-{id}', [AssetController::class, 'rejectAssetTransfer'])->name('asset-rejection-process');

    //Asset Transfer Approval Log 24-06-2024
    Route::get('/asset-transfers-log', [DashboardController::class, 'indexAssetTransferLog'])->name('asset-transfer-log-index');


    //Asset Detailed Infomation Page
    Route::get('/info-asset-{code}', [DashboardController::class, 'indexInfoAsset'])->name('asset-info-index');
});

/*-------Company Setting Route ------- */
Route::prefix('company')->middleware('auth:staffs')->group(function () {

    /* Company Setting*/
    Route::get('/company-management', [DashboardController::class, 'indexCompanyManagement'])->name('company-index');

    //Company Profile 10-6-2024
    Route::get('/company-profile-{code}', [DashboardController::class, 'indexCompanyProfile'])->name('company-profile');

    //Company Registration Process
    Route::post('/company-add-process', [CompanyController::class, 'createCompany'])->name('company-add-post');
    Route::post('/company-edit-{code}', [CompanyController::class, 'editCompany'])->name('company-edit-post');
    Route::get('/company-delete-process-{id}', [CompanyController::class, 'destroyCompany'])->name('company-delete-get-post');



    //Area Management 11-06-2024
    Route::get('/area-management', [DashboardController::class, 'indexAreaSetting'])->name('area-index');

    //Area Setting Process
    Route::post('/area-add-process', [CompanyController::class, 'createArea'])->name('area-add-post');
    Route::post('/area-edit-process-{code}', [CompanyController::class, 'editArea'])->name('area-edit-post');
    Route::get('/area-delete-process-{id}', [CompanyController::class, 'destroyArea'])->name('area-delete-get-post');

    //Area Import & Export
    Route::post('/area-import-process', [CompanyController::class, 'importArea'])->name('area-import-post');
    Route::get('/area-export-excel-process', [CompanyController::class, 'exportExcelArea'])->name('area-export-excel-get');
    Route::get('/area-export-pdf-process', [CompanyController::class, 'exportPdfArea'])->name('area-export-pdf-get');
});

/*-------Staff Management Route ------- */
Route::prefix('staff')->middleware('auth:staffs')->group(function () {

    /* Staff Setting*/

    // Department Management 12-06-2024
    Route::get('/department-management', [DashboardController::class, 'indexDepartmentManagement'])->name('department-index');

    // Department Management Process
    Route::post('/department-add-process', [StaffController::class, 'createDepartment'])->name('department-add-post');
    Route::post('/department-edit-process-{code}', [StaffController::class, 'editDepartment'])->name('department-edit-post');
    Route::get('/department-delete-process-{id}', [StaffController::class, 'destroyDepartment'])->name('department-delete-get-post');

    //Area Import & Export
    Route::post('/department-import-process', [StaffController::class, 'importDepartment'])->name('department-import-post');
    Route::get('/department-export-excel-process', [StaffController::class, 'exportExcelDepartment'])->name('department-export-excel-get');
    Route::get('/department-export-pdf-process', [StaffController::class, 'exportPdfDepartment'])->name('department-export-pdf-get');

    // Staff Management 12-06-2024
    Route::get('/staff-management', [DashboardController::class, 'indexStaffManagement'])->name('staff-index');

    // Staff Management Process
    Route::post('/staff-add-process', [StaffController::class, 'createStaff'])->name('staff-add-post');
    Route::post('/staff-edit-process-{code}', [StaffController::class, 'editStaff'])->name('staff-edit-post');
    Route::get('/staff-delete-process-{id}', [StaffController::class, 'destroyStaff'])->name('staff-delete-get-post');
    Route::get('/admin-reset-password-{id}', [StaffController::class, 'resetPassword'])->name('staff-reset-password');

    //Area Import & Export
    Route::post('/staff-import-process', [StaffController::class, 'importStaff'])->name('staff-import-post');
    Route::get('/staff-export-excel-process', [StaffController::class, 'exportExcelStaff'])->name('staff-export-excel-get');
    Route::get('/staff-export-pdf-process', [StaffController::class, 'exportPdfStaff'])->name('staff-export-pdf-get');
});

/*-------Extra Api Call Route ------- */
//API Call Method
Route::get('/departments/{id}', function ($id) {
    $department = Department::find($id);
    return response()->json(['name' => $department->department_name]);
});

Route::get('/areas/{id}', function ($id) {
    $area = Area::find($id);
    return response()->json(['name' => $area->area_name]);
});

Route::get('/approvalcount', function () {
    $count = AssetTransfer::where('trans_status', 1)->count();
    return response()->json(['count' => $count]);
});
