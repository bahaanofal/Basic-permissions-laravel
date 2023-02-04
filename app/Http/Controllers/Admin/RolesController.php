<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-any', Role::class);
        $roles = Role::latest()->paginate();
        return view('admin.roles.index', [
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Role::class);
        $role = new Role();
        $users = User::all();
        $usersInRole = [];
        return view('admin.roles.create', compact(['role', 'users', 'usersInRole']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Role::class);
        $request->validate([
            'name' => 'required|unique:roles',
            'abilities' => 'nullable|array'
        ]);

        Role::create($request->all());
        $role = Role::where('name', $request->post('name'))->first();
        if($request->users){
            $usersForRole = [];
            foreach($request->users as $user){
                $user = User::findOrFail($user);
                $usersForRole[$user->id] = $user->id;
            }
            $role->users()->attach($usersForRole);
        }

        return redirect()->route('roles.index')->with('success', 'Role created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        $this->authorize('view', $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $middleTable = DB::table('role_user')->where('role_id', $id)->get();
        $usersInRole = [];
        foreach($middleTable as $userRole){
            $usersInRole[$userRole->user_id] = $userRole->user_id;
        }
        $role = Role::findOrFail($id);
        $this->authorize('update', $role);
        $users = User::all();
        return view('admin.roles.edit',  [
            'role' => $role,
            'users' => $users,
            'usersInRole' => $usersInRole,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $this->authorize('update', $role);
        $request->validate([
            'name' => 'required|unique:roles,name,'. $id,
            'abilities' => 'nullable|array'
        ]);
        $role->update($request->all());
        if($request->users){
            $usersForRole = [];
            foreach($request->users as $user){
                $user = User::findOrFail($user);
                $usersForRole[$user->id] = $user->id;
            }
            $role->users()->sync($usersForRole);
        }

        return redirect()->route('roles.index')->with('success', 'Role Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $this->authorize('delete', $role);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role Deleted!');
    }
}
