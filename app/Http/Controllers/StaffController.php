<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Staff;
use App\Models\Department;
use Illuminate\Support\Str;
use App\Exports\StaffExport;
use App\Imports\StaffImport;
use Illuminate\Http\Request;
use App\Exports\DepartmentExport;
use App\Imports\DepartmentImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class StaffController extends Controller
{
    /* 
    
    This controller includes : 
    - Staff Management 
    - Department Management
    - Profile Management

    Last Checked & Updated : 13-07-2024
    By Muhammad Zikri Bin Kashim, UTeM 

    */

    /* Staff Management */

    public function createStaff(Request $request)
    {
        try {
            $validated = $request->validate([
                'staff_no' => 'required | unique:staffs',
                'staff_name' => 'required',
                'staff_phone' => 'required',
                'email' => 'required | unique:staffs',
                'staff_role' => 'required',
                'staff_status' => 'required',
                'password' => 'required|min:8',
                'cpassword' => 'required|min:8|same:password',
                'dep_id' => 'required',
                'comp_id' => 'required'
            ]);
            $validated['staff_no'] = Str::upper($validated['staff_no']);
            $validated['password'] = bcrypt($validated['password']);
            Staff::create($validated);
            return back()->with('success', 'Staff successfully added !');
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } // done

    public function editStaff(Request $request, $code)
    {
        try {
            $validated = $request->validate([
                'staff_no' => 'required',
                'staff_name' => 'required',
                'staff_phone' => 'required',
                'email' => 'required',
                'staff_role' => 'required',
                'staff_status' => 'required',
                'dep_id' => 'required',
                'comp_id' => 'required'
            ]);
            $validated['staff_no'] = Str::upper($validated['staff_no']);
            Staff::where('id', $code)->update($validated);

            return back()->with('success', 'Staff details successfully updated !');
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function destroyStaff($id)
    {
        try {
            $delete = Staff::where('id', $id)->delete();
            return back()->with('success', 'Staff successfully deleted !');
        } catch (Exception $e) {

            Staff::where('id', $id)->update(['staff_status' => 3]);
            return back()->with('error', 'EDE002 : Staff members are not being completely deleted due to links to their previous data. Instead, their data will be retained in the database but will not be visible in the list. This action is irreversible and cannot be undone.');
        }
    } //done

    public function resetPassword($code)
    {
        try {
            $password = Str::password(8,true,true,false);
            $passwordShow = $password;
            $password = bcrypt($password);

            Staff::where('id', $code)->update(['password' => $password]);

            return back()->with('success', 'Password reset successfully !, The reset password is :  '. $passwordShow);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    } //done

    public function importStaff()
    {
        try {
            Excel::import(new StaffImport, request()->file('file'));
            return back()->with('success', 'Staff data successfully imported !');;
        } catch (Exception $e) {
            return back()->with('error', 'EIE' . $e->getLine() . ': Duplicate data or template format issue, It appears that the data you are trying to insert already exists, or the template format has changed. Please review your data and try again. The details : ' . $e->getMessage());
        }
    } //done

    public function exportExcelStaff()
    {
        return Excel::download(new StaffExport, 'staff-data-export.xlsx');
    } //done

    public function exportPdfStaff()
    {
        return Excel::download(new StaffExport, 'staff-data-export.pdf', \Maatwebsite\Excel\Excel::MPDF);
    } //done


    /* Department Management */
    public function createDepartment(Request $request)
    {
        try {
            $validated = $request->validate([
                'department_name' => 'required',
                'department_code' => 'required | unique:departments',
            ]);
            $validated['department_code'] = Str::upper($validated['department_code']);
            Department::create($validated);
            return back()->with('success', 'Department successfully added !');
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function editDepartment(Request $request, $code)
    {
        try {
            $validated = $request->validate([
                'department_name' => 'required',
                'department_code' => 'required',
            ]);
            $validated['department_code'] = Str::upper($validated['department_code']);
            Department::where('id', $code)->update($validated);
            return back()->with('success', 'Department successfully updated !');
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function destroyDepartment($id)
    {
        try {
            Department::where('id', $id)->delete();
            return back()->with('success', 'Department successfully deleted !');
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function importDepartment()
    {
        try {
            Excel::import(new DepartmentImport, request()->file('file'));
            return back()->with('success', 'Department data successfully imported !');;
        } catch (Exception $e) {
            return back()->with('error', 'EIE' . $e->getLine() . ': Duplicate data or template format issue, It appears that the data you are trying to insert already exists, or the template format has changed. Please review your data and try again. The details : ' . $e->getMessage());
        }
    } //done

    public function exportExcelDepartment()
    {
        return Excel::download(new DepartmentExport, 'department-data-export.xlsx');
    } //done

    public function exportPdfDepartment()
    {
        return Excel::download(new DepartmentExport, 'department-data-export.pdf', \Maatwebsite\Excel\Excel::MPDF);
    } //done


    /* Profile Update Function */

    public function updateProfile(Request $request, $code)
    {
        try {
            $validated = $request->validate([
                'staff_name' => 'required',
                'staff_phone' => 'required',
                'email' => 'required'
            ]);

            Staff::where('id', $code)->update($validated);

            return back()->with('success', 'Profile successfully updated.');
        } catch (Exception $e) {
            return back()->with('error', 'ACC-E' . $e->getLine() . ' : ' . $e->getMessage());

        }
    } //done

    public function updatePassword(Request $request, $code)
    {
        try {
            $checkcurrpass = Hash::check($request->currpassword, Auth::user()->password, []);

            if ($checkcurrpass == true) {
                $validated = $request->validate([
                    'password' => 'required | min:8',
                    'cpassword' => 'required | min:8 |same:password'
                ]);
                $validated['password'] = bcrypt($validated['password']);

                Staff::where('id', $code)->update(['password' => $validated['password']]);

                return back()->with('success', 'Password successfully updated.');
            } else {
                return back()->with('error', 'ACC-E101 : The password you entered does not match our records. Please try again.');
            }
        } catch (Exception $e) {
            return back()->with('error', 'ACC-E' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done
}
