<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSlotRequest;
use App\Http\Requests\UpdateSlotRequest;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Slot;
use Carbon\Carbon;

class SlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company, Branch $branch)
    {
        try {
            $slots = Slot::select('id', 'day', 'starts_at', 'ends_at')
                ->where('company_id', $company->id)
                ->where('branch_id', $branch->id)
                ->orderBy('id', 'asc')
                ->get();

            return response()->json([
                'success' => 'All slots list showing successfully.',
                'data' => $slots,
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
    public function store(StoreSlotRequest $request, Company $company, Branch $branch)
    {
        try {
            foreach ($request->slots as $each_slot) {

                $slot = new Slot();
                $slot->company_id = $company->id;
                $slot->branch_id = $branch->id;
                $slot->day = $each_slot['day'];
                $slot->slots = $each_slot['slots'];
                $slot->starts_at = $each_slot['starts_at'];
                $slot->ends_at  = $each_slot['ends_at'];
                $slot->save();
            }


            Slot::where('company_id', $company->id)
            ->where('branch_id', $branch->id)
            ->where('created_at', '<', Carbon::parse($slot->created_at)->subSeconds(3))
            ->delete();


            return response()->json(['success' => "Slots created successfully for $branch->branch_name branch of $company->company_name. "], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Slot $slot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slot $slot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSlotRequest $request, Slot $slot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slot $slot)
    {
        //
    }
}
