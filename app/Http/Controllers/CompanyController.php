<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Area;
use App\Models\Company;
use App\Exports\AreaExport;
use App\Imports\AreaImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class CompanyController extends Controller
{

    /* 
    
    This controller includes : 
    - Area Management
    - Company Management
    
    Last Checked & Updated : 13-07-2024
    By Muhammad Zikri Bin Kashim, UTeM 

    */

    /* Area Management */
    public function createArea(Request $request)
    {
        try {
            $validated = $request->validate([
                'area_name' => 'required',
                'area_code' => 'required',
                'comp_id' => 'required'
            ]);
            $validated['area_code'] = Str::upper($validated['area_code']);
           // $check = Area::where('area_code', '=', $validated['area_code'])->where('comp_id', '=', $validated['comp_id'])->exists();

            // if ($check == false) {
                Area::create($validated);
                return back()->with('success', 'Area successfully added !');
            // }
            // else{
            //     return back()->with('error', 'EDE003 : The area is exists, please try again.');
            // }
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function editArea(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'area_name' => 'required',
                'area_code' => 'required',
                'comp_id' => 'required'
            ]);
            $validated['area_code'] = Str::upper($validated['area_code']);

            // $check = Area::where('area_code', '=', $validated['area_code'])->where('comp_id', '=', $validated['comp_id'])->exists();

            // if ($check == false) {
                Area::where('id', $id)->update($validated);
                return back()->with('success', 'Area details sucessfully updated !');
            // }
            // else{
            //     return back()->with('error', 'EDE004 : Update failed! Duplicate data detected. Please ensure the data you are trying to update is unique.');
            // }
           
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function destroyArea($id)
    {
        try {
            Area::where('id', $id)->delete();
            return back()->with('success', 'Area successfully deleted !');
        } catch (Exception $e) {
            return back()->with('error', 'EDE'.$e->getLine().' : ' .$e->getMessage());
        }
    } //done

    public function importArea()
    {
        try {
            Excel::import(new AreaImport, request()->file('file'));
            return back()->with('success', 'Area data successfully imported !');;
        } catch (Exception $e) {
            return back()->with('error', 'EIE'.$e->getLine().': Duplicate data or template format issue, It appears that the data you are trying to insert already exists, or the template format has changed. Please review your data and try again. The details : '. $e->getMessage());
        }
    } //done

    public function exportExcelArea()
    {
        return Excel::download(new AreaExport, 'area-data-export.xlsx');
    } //done

    public function exportPdfArea()
    {
        return Excel::download(new AreaExport, 'area-data-export.pdf', \Maatwebsite\Excel\Excel::MPDF);
    } //done


    /* Company Management */
    public function createCompany(Request $request)
    {
        try {
            $validated = $request->validate([
                'company_name' => 'required',
                'company_code' => 'required | unique:companies',
                'company_phone' => 'required',
                'company_email' => 'required',
                'company_address' => '',
                'company_registno' => ''

            ]);
            $validated['company_code'] = Str::upper($validated['company_code']);
            Company::create($validated);
            return back()->with('success', 'Company successfully registered !');
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function editCompany(Request $request, $code)
    {
        try {
            $validated = $request->validate([
                'company_name' => 'required',
                'company_code' => 'required',
                'company_phone' => 'required',
                'company_email' => 'required',
                'company_address' => '',
                'company_registno' => ''

            ]);
            $validated['company_code'] = Str::upper($validated['company_code']);
            Company::where('id', $code)->update($validated);
            return redirect()->route('company-index')->with('success', 'Company profile successfully updated !');
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done

    public function destroyCompany($id)
    {
        try {
            Company::where('id', $id)->delete();
            return back()->with('success', 'Company successfully deleted !');
        } catch (Exception $e) {
            return back()->with('error', 'EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    } //done
   
}
