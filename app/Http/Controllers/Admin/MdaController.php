<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Mda;
use App\Models\NewUser;
use App\Models\Title;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MdaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $mdas = Mda::with('department')->paginate(20);
        if(isset($search))
        {
            $mdas = Mda::with('department')
                ->where('firstnames', 'like', '%'.$search.'%')
                ->orWhere('surname', 'like', '%'.$search.'%')
                ->orWhere('title', 'like', '%'.$search.'%')
                ->orWhere('phone', 'like', '%'.$search.'%')
                ->orWhere('address', 'like', '%'.$search.'%')
                ->paginate(20);
        }

        //dd($mdas);
        return inertia('Admin/MdasPage', [
            'mdas' => $mdas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titles = Title::all();
        $departments = Department::all();
        return inertia('Admin/Mda/CreatePage', [
            'departments' => $departments,
            'titles' => $titles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'department_id' => ['required', 'integer'],
            'title' => ['required', 'string'],
            'firstnames' => ['required', 'string'],
            'surname' => ['required', 'string'],
            'phone' => ['required', 'max:10'],
            'address' => ['required', 'string'],
            'email' => 'required|email|max:250|unique:users',
        ]);

        try {
            $user = User::create([
                'name' => $request->firstnames . " " . $request->surname,
                'email' => $request->email,
                'password' => Hash::make("password")
            ]);

            $user->addRole("mda");

            NewUser::create([
                'user_id' => $user->id,
                'is_new' => 1
            ]);

            Mda::create([
                'department_id' => $request->department_id,
                'user_id' => $user->id,
                'title' => $request->title,
                'firstnames' => $request->firstnames,
                'surname' => $request->surname,
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            return back()->with(['success' => 'MDA was created successfully']);
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
        $titles = Title::all();
        $mda = Mda::with('department')->find($id);
        $departments = Department::all();
        return inertia('Admin/Mda/UpdatePage', [
            'titles' => $titles,
            'departments' => $departments,
            'mda' => $mda
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'department_id' => ['required', 'integer'],
            'title' => ['required', 'string'],
            'firstnames' => ['required', 'string'],
            'surname' => ['required', 'string'],
            'phone' => ['required', 'max:10'],
            'address' => ['required', 'string'],
        ]);

        try {

            Mda::find($id)->update([
                'department_id' => $request->department_id,
                'title' => $request->title,
                'firstnames' => $request->firstnames,
                'surname' => $request->surname,
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            return back()->with(['success' => 'MDA was updated successfully']);
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

            $mda = Mda::findOrFail($id);
            $mda->delete();

            return back()->with(['success' => 'Mda was deleted successfully.']);
        }catch(Exception $e)
        {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
