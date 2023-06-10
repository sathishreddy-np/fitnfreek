<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSlotRequest;
use App\Http\Requests\UpdateSlotRequest;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Slot;
use App\Models\SlotClassification;
use Illuminate\Support\Facades\DB;

class SlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company, Branch $branch)
    {
        try {
            $slots = Slot::with('slot_classifications')->where('company_id', $company->id)
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
            DB::transaction(function () use ($request, $company, $branch) {
                $old_slot_ids = Slot::where('company_id', $company->id)
                    ->where('branch_id', $branch->id)->pluck('id');

                if ($old_slot_ids->count() > 0) {
                    Slot::with('slot_classifications')->whereIn('id', $old_slot_ids)->delete();
                }

                $this->storeSlots($request->slots, $company, $branch);
            });
            return response()->json(['success' => "Slots created successfully for $branch->branch_name branch of $company->company_name."], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function storeSlots($slots, $company, $branch)
    {
        foreach ($slots as $each_slot) {
            $slot = new Slot();
            $slot->company_id = $company->id;
            $slot->branch_id = $branch->id;
            $slot->sport = $each_slot['sport'];
            $slot->slot_type = $each_slot['slot_type'];
            $slot->slot_name = $each_slot['slot_name'];
            $slot->days_of_plan = $each_slot['days_of_plan'];
            $slot->no_of_times_allowed = $each_slot['no_of_times_allowed'];
            $slot->day = $each_slot['day'];
            $slot->no_of_slots = $each_slot['no_of_slots'] + 1;
            $slot->starts_at_hours = $each_slot['starts_at_hours'] + 1;
            $slot->starts_at_minutes = $each_slot['starts_at_minutes'] + 1;
            $slot->ends_at_hours = $each_slot['ends_at_hours'] + 1;
            $slot->ends_at_minutes = $each_slot['ends_at_minutes'] + 1;
            $slot->save();

            $this->storeSlotClassifications($each_slot['slot_classifications'], $slot);
        }
    }

    private function storeSlotClassifications($slot_classifications, $slot)
    {
        foreach ($slot_classifications as $each_classification) {
            $slot_classification = new SlotClassification();
            $slot_classification->slot_id = $slot->id;
            $slot_classification->allowed_gender = $each_classification['allowed_gender'];
            $slot_classification->allowed_age_from = $each_classification['allowed_age_from'];
            $slot_classification->allowed_age_to = $each_classification['allowed_age_to'];
            $slot_classification->amount = $each_classification['amount'];
            $slot_classification->save();
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
