<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quarter;
use Exception;
use Illuminate\Http\Request;

class QuarterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $quarters = Quarter::paginate(20);
        if(isset($search))
        {
            $quarters = Quarter::where('name', 'like', '%'.$search.'%')
                ->paginate(20);
        }
        return inertia('Admin/QuartersPage', [
            'quarters' => $quarters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Quarter/CreatePage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:250', 'unique:quarters,name'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date']
        ]);

        try {

            $overlapping_quarters = Quarter::where(function($query) use ($request) {
                $query->where('start_date', '<=', $request->end_date)
                    ->where('end_date', '>=', $request->start_date);
            })->exists();

            if ($overlapping_quarters) {
                return back()->withErrors(['error' => 'The specified period overlaps with an existing quarter.']);
            }

            Quarter::create([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);

            return back()->with(['success' => 'Quarter created successfully']);
        }catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quarter = Quarter::find($id);
        if(is_null($quarter))
        {
            return redirect()->back();
        }


        return inertia('Admin/Quarter/UpdatePage', [
            'quarter' => $quarter,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:250'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date']
        ]);

        try {
            $overlapping_quarters = Quarter::where(function($query) use ($request) {
                $query->where('start_date', '<=', $request->end_date)
                    ->where('end_date', '>=', $request->start_date);
            })->exists();

            if ($overlapping_quarters) {
                return back()->withErrors(['error' => 'The specified period overlaps with an existing quarter.']);
            }

            Quarter::find($id)->update([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);

            return back()->with(['success' => 'Quarter updated successfully']);
        }catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{

            $quaerter = Quarter::findOrFail($id);
            $quaerter->delete();

            return back()->with(['success' => 'Quarter deleted successfully.']);
        }catch(Exception $e)
        {
            return back()->withErrors(['error' => 'Exception error']);
        }
    }
}
