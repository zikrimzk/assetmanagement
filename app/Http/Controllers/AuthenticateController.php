<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Staff;
use App\Models\System;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthenticateController extends Controller
{
    /* 
    
    This controller includes : 
    - Authentication and Access Control Management
    - Installation Code
    
    Last Checked & Updated : 24-07-2024
    By Muhammad Zikri Bin Kashim, UTeM 

    Note : 
    Never touch this controller without knowing the process or else will cause to system error

    */

    public function indexLogin()
    {
        if (Auth::guard('staffs')->check()) {
            return redirect()->intended(route('user-index'));
        } else {
            return view('Asset-Management.login-index');
        }
    } //done

    public function authenticate(Request $request): RedirectResponse
    {
        if (Auth::guard('staffs')->attempt(['email' => $request->email, 'password' => $request->password, 'staff_status' => 1])) {
            if (DB::table('systems')->latest()->first()->system_status == 1) {
                $request->session()->regenerate();
            } elseif (DB::table('systems')->latest()->first()->system_status == 0) {
                Auth::guard('staffs')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('error', 'Access to this system is currently restricted. Please contact the administrator for further assistance.');
            }
        } elseif (Auth::guard('staffs')->attempt(['email' => $request->email, 'password' => $request->password, 'staff_status' => 0])) {
            Auth::guard('staffs')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $data = Staff::where('email', $request->email)->first();
            return redirect()->route('firsttimelogin', $data->id);
        } elseif (Auth::guard('staffs')->attempt(['email' => $request->email, 'password' => $request->password, 'staff_role' => 5, 'staff_status' => 3])) {
            $request->session()->regenerate();
        }

        return back()->with('error', 'E-ACC002 : The provided credentials do not match our records. Please try again.');
    } //done

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('staffs')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You has successfully logout.');
    } //done

    public function indexPasswordChange($id)
    {
        $data = Staff::where('id', $id)->first();

        if ($data->staff_status == 0) {
            return view('Asset-Management.first-time-index', [
                'staff' => $data
            ]);
        } else {
            return back()->with('error', 'ACC-E103 : You cannot access the page !, your attempt was recorded.');
        }
    } //done

    public function updateFirstTimePassword(Request $request, $id)
    {
        try {
            $data = Staff::where('id', $id)->first();

            $checkcurrpass = Hash::check($request->currpassword, $data->password, []);
            if ($checkcurrpass == true) {
                $validated = $request->validate([
                    'password' => 'required | min:8',
                    'cpassword' => 'required | min:8 |same:password'
                ]);
                $validated['password'] = bcrypt($validated['password']);

                Staff::where('id', $id)->update(['password' => $validated['password'], 'staff_status' => 1]);

                return redirect()->route('login')->with('success', 'Your password successfully changed. Please login using your new credentials.');
            } else {
                return back()->with('error', 'ACC-E101 : The password you entered does not match our records. Please try again.');
            }
        } catch (Exception $e) {
            return back()->with('error', 'ACC-E' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function installationProcess()
    {
        try {
            //Laravel Process Installation Code 
            Artisan::call('storage:unlink');
            Artisan::call('storage:link');
            Artisan::call('migrate:fresh');
            Artisan::call('optimize:clear');

            //System Activation
            $sys = new System();
            $sys->system_status = 1;
            $sys->save();

            // Company Initial Data 
            $company = new Company();
            $company->company_name = 'Company Name';
            $company->company_code = 'TEST';
            $company->company_address = '-';
            $company->company_phone = '06-232512X';
            $company->company_email = 'xxxxx@assettrack.com.my';
            $company->company_registno = '-';
            $company->save();

            // Department Initial Data 
            $dep = new Department();
            $dep->department_name = 'Information Technology';
            $dep->department_code = 'IT';
            $dep->save();

            // Staff Initial Data 
            $data = new Staff();
            $data->staff_no = 'AT001';
            $data->staff_name = Str::headline('AssetTrack Admin');
            $data->staff_phone = '011-XXX XXXX';
            $data->email = 'admin01@assettrack.my';
            $data->staff_role = 1;
            $data->staff_status = 1;
            $data->dep_id = DB::table('departments')->latest()->first()->id;
            $data->comp_id = DB::table('companies')->latest()->first()->id;
            $data->password = bcrypt('assettrack@1234');
            $data->save();


            $data = new Staff();
            $data->staff_no = 'ZK001';
            $data->staff_name = Str::headline('Zeeke Software Solutions');
            $data->staff_phone = '011-13097495';
            $data->email = 'zeekesoftware@assettrack.my';
            $data->staff_role = 5;
            $data->staff_status = 3; //Initially terminated
            $data->dep_id = DB::table('departments')->latest()->first()->id;
            $data->comp_id = DB::table('companies')->latest()->first()->id;
            $data->password = bcrypt('abcd1234');
            $data->save();

            return back()->with('success', 'Installation process has successfully completed. Please login using the given credential. Email : admin01@assettrack.my & Password : assettrack@1234');
        } catch (Exception $e) {
            return back()->with('error', 'IPE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function SystemUpDown()
    {
        try {
            if (DB::table('systems')->latest()->first()->system_status == 0) {
                System::where('id', DB::table('systems')->latest()->first()->id)->update(['system_status' => 1]);
                return back()->with('success', 'AssetTrack mode : ACTIVE');
            } elseif (DB::table('systems')->latest()->first()->system_status == 1) {
                System::where('id', DB::table('systems')->latest()->first()->id)->update(['system_status' => 0]);
                return back()->with('error', 'AssetTrack mode : DEACTIVATED');
            }
        } catch (Exception $e) {
            return back()->with('error', 'SAC' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done
}
