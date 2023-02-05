<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', User::class);
        $users = User::all();
        if ($request->ajax()) {
            // $data = User::all();
            return DataTables::of($users)->addIndexColumn()
                ->editColumn('created_at', function($user){ 
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)
                                    ->format('d-m-Y h:i:s a'); 
                    return $formatedDate; 
                })
                ->addColumn('edit', function($user){
                    $url = url(route('users.edit', $user->id));
                    $EditButton = '<a href="'.$url.'">Edit</a>';
                    return $EditButton;
                })
                
                ->addColumn('delete', function($user){
                    $url = url(route('users.destroy', $user->id));
                    $csrf = csrf_token();
                    $DelButton = '<form action="'.$url.'" method="post">
                        <input type="hidden" name="_token" value="'.$csrf.'" />
                        <input type="hidden" name="_method" value="delete">
                        <button class="btn btn-danger btn-sm">del</button>
                        </form>';
                    return $DelButton;
                })
                ->rawColumns(['edit','delete'])
                ->make(true);
        }

        return view('admin.users.index',compact('users'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $this->authorize('view-any', User::class);

    //     $users = User::latest()->paginate();
    //     return view('admin.users.index', [
    //         'users' => $users,
    //     ]);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $user = new User();
        return view('admin.users.create', [
            'user' => $user,
            'userAbilities' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'type' => 'required|in:super-admin,admin,user',
            'permissions' => 'nullable|array'
        ]);

        // dd($request->permissions);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('123456789'),
            'type' => $request->type,
            'permissions' => $request->permissions,
        ]);
        event(new Registered($user));

        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('view', $user);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $userAbilities = [];
        foreach($user->roles  as $role) {
            $userAbilities = array_merge($userAbilities, $role->abilities);
        }
        
        return view('admin.users.edit', [
            'user' => $user,
            'userAbilities' => $userAbilities,
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
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $user->permissions = [''];
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'type' => 'required|in:super-admin,admin,user',
            'permissions' => 'nullable|array'
        ]);

        $user->update($request->all());
        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);
        $user->delete();
        return redirect(route('users.index'));
    }
}
