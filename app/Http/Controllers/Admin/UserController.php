<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $users = User::with('roles')->paginate(20);
        if(isset($search))
        {
            $users = User::with('roles')
                ->where('name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->paginate(20);
        }
        return inertia('Admin/UsersPage', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return inertia('Admin/User/CreatePage', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|integer'
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $user->addRole($request->role);

            return back()->with(['success' => 'User created successfully']);
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

        $user = User::with('roles')->find($id);
        if(is_null($user))
        {
            return redirect()->back();
        }


        $roles = Role::all();
        return inertia('Admin/User/UpdatePage', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'role' => 'required|integer',
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250'
        ]);

        //dd($request->role);

        try {
            $user = User::find($id)->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            // $firstRole = $user->roles()->first();
            // $user->removeRole($firstRole->id);

            // $user->addRole($request->role);

            return back()->with(['success' =>'User updated successfully!']);
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

            $user = User::findOrFail($id);
            $user->delete();

            return back()->withErrors(['success' => 'User deleted successfully.']);
        }catch(Exception $e)
        {
            return back()->withErrors(['error' => 'Exception error']);
        }
    }
}
