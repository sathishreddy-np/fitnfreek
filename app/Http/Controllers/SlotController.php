<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSlotRequest;
use App\Http\Requests\UpdateSlotRequest;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Slot;
use App\Models\SlotClassification;
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
                $slot->sport = $each_slot['sport'];
                $slot->slot_type = $each_slot['slot_type'];
                $slot->day = $each_slot['day'];
                $slot->no_of_slots = $each_slot['no_of_slots']+1;
                $slot->starts_at_hours = $each_slot['starts_at_hours']+1;
                $slot->starts_at_minutes = $each_slot['starts_at_minutes']+1;
                $slot->ends_at_hours = $each_slot['ends_at_hours']+1;
                $slot->ends_at_minutes = $each_slot['ends_at_minutes']+1;
                $slot->save();


                foreach ($each_slot['slot_classifications'] as $each_classification) {
                    $slot_classification = new SlotClassification();
                    $slot_classification->slot_id = $slot->id;
                    $slot_classification->allowed_gender = $each_classification['allowed_gender'];
                    $slot_classification->allowed_age_from = $each_classification['allowed_age_from'];
                    $slot_classification->allowed_age_to = $each_classification['allowed_age_to'];
                    $slot_classification->amount = $each_classification['amount'];
                    $slot_classification->save();
                }
            }

            $old_slot = Slot::where('company_id', $company->id)
            ->where('branch_id', $branch->id)->first();


            Slot::where('company_id', $company->id)
                ->where('branch_id', $branch->id)
                ->where('created_at', '<', Carbon::parse($slot->created_at)->subSeconds(3))
                ->delete();

            if($slot){
                SlotClassification::where('slot_id', $old_slot->id)
                ->where('created_at', '<', Carbon::parse($slot->created_at)->subSeconds(3))
                ->delete();
            }

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
