<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $permissions = Permission::all();
        $groups = Permission::select('group_name')->distinct()->get();
        $roles = Role::whereNotIn('name', ['ডেভেলপার'])->get();
        return view('backend.roles.index', compact('permissions', 'roles', 'groups'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'permissions' => 'required'
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return back();
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);
        $permissions = Permission::all();
        $groups = Permission::select('group_name')->distinct()->get();

        $hasPermission = collect($role->permissions)->pluck('id');

        return view('backend.roles.edit', compact('permissions', 'role', 'groups', 'hasPermission'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $role = Role::find($id);
        $role->name = $request->name;
        $role->syncPermissions($request->permissions);
        $role->save();

        return redirect(Route('roles'))->with('success', 'পদবি এবং অনুমতি আপডেট সম্পন্ন হয়েছে');
    }
}
