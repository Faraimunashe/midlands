<?php

namespace App\Http\Controllers\Mda;

use App\Http\Controllers\Controller;
use App\Models\Mda;
use App\Models\Progress;
use App\Models\Quarter;
use App\Models\Target;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $targets = Target::with('department')->where('author_id', Auth::id())->paginate(20);
        return inertia("Mda/TargetsPage", [
            'targets' => $targets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $quarters = Quarter::all();
        return inertia("Mda/Target/CreatePage", [
            'quarters' => $quarters
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'quarters' => ['required', 'array', 'min:1'],
            'quarters.*' => ['exists:quarters,id'],
        ]);

        DB::beginTransaction();

        try {

            $mda = Mda::where('user_id', Auth::id())->first();
            if(is_null($mda))
            {
                return back()->withErrors(['error' => 'Could not find MDA department']);
            }

            $target = Target::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'] ?? null,
                'department_id' => $mda->department_id,
                'author_id' => auth()->id(),
                'status' => 'In Progress',
            ]);

            // Attach the selected quarters to the target
            $target->quarters()->sync($validated['quarters']);

            DB::commit();

            return back()->with(['success' => 'MDA was created successfully']);
        }catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $target = Target::with('quarters')->find($id);
        return inertia("Mda/Target/ShowPage");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quarters = Quarter::all();
        $target = Target::with('quarters')->with('department')->find($id);

        $last_progress = Progress::where('progressable_type', Target::class)
        ->where('progressable_id', $target->id)
        ->orderBy('created_at', 'desc')
        ->first();

        return inertia("Mda/Target/UpdatePage", [
            'quarters' => $quarters,
            'target' => $target,
            'lastProgress' => $last_progress->progress_percent ?? 0
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'quarters' => ['required', 'array', 'min:1'],
            'quarters.*' => ['exists:quarters,id'],
        ]);

        DB::beginTransaction();

        try {
            $target = Target::findOrFail($id);

            $mda = Mda::where('user_id', Auth::id())->first();
            if (is_null($mda)) {
                return back()->withErrors(['error' => 'Could not find MDA department']);
            }

            $target->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'] ?? null
            ]);

            $target->quarters()->sync($validated['quarters']);

            DB::commit();

            return back()->with(['success' => 'Target was updated successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
