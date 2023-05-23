<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $comapanies = Company::select('id', 'company_name')
                ->orderBy('company_name', 'asc')
                ->get();

            return response()->json([
                'success' => 'All companies list showing successfully.',
                'data' => $comapanies,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        try {
            $company = new Company();
            $company->user_id = Auth::user()->id;
            $company->company_name = $request->company_name;
            $company->save();

            return response()->json(['success' => "$company->company_name created successfully."], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        try {
            if ($company) {
                return response()->json([
                    'success' => "$company->company_name details shown successfully.",
                    'data' => $company,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        try {
            $company->user_id = Auth::user()->id;
            $company->company_name = $request->company_name;
            $company->save();

            return response()->json(['success' => "$company->company_name updated successfully."], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        try {
            $is_deleted = $company->delete();

            if ($is_deleted) {
                return response()->json(['success' => "$company->company_name deleted successfully."], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
