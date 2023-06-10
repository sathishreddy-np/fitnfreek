<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Models\Branch;
use App\Models\Company;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        try {
            $branches = Branch::select('id', 'branch_name', 'is_main_branch')
                ->where('company_id', $company->id)
                ->orderBy('is_main_branch', 'desc')
                ->orderBy('branch_name', 'asc')
                ->get();

            return response()->json([
                'success' => "$company->company_name company branches list showing successfully.",
                'data' => $branches,
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
    public function store(StoreBranchRequest $request, Company $company)
    {
        try {
            $branch = new Branch();
            $branch->company_id = $company->id;
            $branch->branch_name = $request->branch_name;
            $branch->is_main_branch = $request->is_main_branch;
            $branch->save();

            if ($request->is_main_branch) {
                Branch::where('company_id', $company->id)->whereNot('id', $branch->id)->update(['is_main_branch' => 0]);
            }

            return response()->json(['success' => "$branch->branch_name created successfully for $company->company_name."], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Branch $branch)
    {
        try {
            $branch = Branch::where('company_id', $company->id)
                ->where('id', $branch->id)
                ->first();
            if ($branch) {
                return response()->json([
                    'success' => "$branch->branch_name details shown successfully for $company->company_name.",
                    'data' => $branch,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBranchRequest $request, Company $company, Branch $branch)
    {
        try {
            $branch->company_id = $company->id;
            $branch->branch_name = $request->branch_name;
            $branch->is_main_branch = $request->is_main_branch;
            $branch->save();

            if ($request->is_main_branch) {
                Branch::where('company_id', $company->id)->whereNot('id', $branch->id)->update(['is_main_branch' => 0]);
            }

            return response()->json(['success' => "$branch->branch_name updated successfully for $company->company_name."], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Branch $branch)
    {
        try {
            $branch = Branch::where('company_id', $company->id)
                ->where('id', $branch->id)
                ->first();
            if ($branch) {
                $is_deleted = $branch->delete();
            }
            if ($is_deleted) {
                return response()->json(['success' => "$branch->branch_name deleted successfully for $company->company_name."], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
