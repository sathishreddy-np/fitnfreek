<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookSlotRequest;
use App\Http\Requests\UpdateBookSlotRequest;
use App\Models\BookSlot;
use App\Models\Branch;
use App\Models\Company;

class BookSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
    public function store(Company $company, Branch $branch, StoreBookSlotRequest $request)
    {

        try {
            $bookSlot = new BookSlot();
            $bookSlot->user_id = auth()->user()->id;
            $bookSlot->company_id = $company->id;
            $bookSlot->branch_id = $branch->id;
            $bookSlot->name = $request->name;
            $bookSlot->age = $request->age;
            $bookSlot->gender = $request->gender;
            $bookSlot->sport = $request->sport;
            $bookSlot->slot_type = $request->slot_type;
            $bookSlot->slot_name = $request->slot_name;
            $bookSlot->starts_at_unix = $request->starts_at_unix;
            $bookSlot->ends_at_unix = $request->ends_at_unix;
            $bookSlot->starts_at_hours = $request->starts_at_hours;
            $bookSlot->starts_at_minutes = $request->starts_at_minutes;
            $bookSlot->ends_at_hours = $request->ends_at_hours;
            $bookSlot->ends_at_minutes = $request->ends_at_minutes;
            $bookSlot->amount = $request->amount;
            $bookSlot->save();

            return response()->json(['success' => 'Slot Booked'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Branch $branch, BookSlot $bookslot)
    {
        try {

            $bookSlot = BookSlot::where('company_id', $company->id)
                ->where('branch_id', $branch->id)
                ->where('id', $bookslot->id)
                ->first();
            if ($bookSlot) {
                return response()->json([
                    'success' => 'Slot View',
                    'data' => $bookslot,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookSlot $bookSlot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Company $company, Branch $branch, UpdateBookSlotRequest $request, BookSlot $bookslot)
    {
        try {
            $bookslot->company_id = $company->id;
            $bookslot->branch_id = $branch->id;
            $bookslot->name = $request->name;
            $bookslot->age = $request->age;
            $bookslot->gender = $request->gender;
            $bookslot->sport = $request->sport;
            $bookslot->slot_type = $request->slot_type;
            $bookslot->slot_name = $request->slot_name;
            $bookslot->starts_at_unix = $request->starts_at_unix;
            $bookslot->ends_at_unix = $request->ends_at_unix;
            $bookslot->starts_at_hours = $request->starts_at_hours;
            $bookslot->starts_at_minutes = $request->starts_at_minutes;
            $bookslot->ends_at_hours = $request->ends_at_hours;
            $bookslot->ends_at_minutes = $request->ends_at_minutes;
            $bookslot->amount = $request->amount;
            $bookslot->save();

            return response()->json(['success' => 'Slot Updated'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Branch $branch, BookSlot $bookslot)
    {
        try {
            $bookSlot = BookSlot::where('company_id', $company->id)
                ->where('branch_id', $branch->id)
                ->where('id', $bookslot->id)
                ->first();
            if ($bookSlot) {
                $bookSlot->delete();

                return response()->json(['success' => 'Slot Deleted'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
