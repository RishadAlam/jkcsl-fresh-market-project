<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
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
        $roles = Role::whereNotIn('name', ['ডেভেলপার'])->get();
        $users = new User();
        $user = $users->whereNotIn('email', ['admin@gmail.com'])->get();
        return view('backend.employee.index', compact('user', 'roles'));
    }

    /**
     * Employee Registration
     */
    public function registration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'required|min:8',
        ], [
            'name.required' => 'নাম প্রয়োজন',
            'email.required' => 'ইমেল প্রয়োজন',
            'email.email' => 'সঠিক ইমেল ব্যবহার করুন',
            'password.required' => 'পাসওয়ার্ড প্রয়োজন',
            'password.min' => 'আট সংখ্যার পাসওয়ার্ড প্রয়োজন',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole($request->role);

        return back()->with("success", "অফিসার রেজিস্ট্রেশন সম্পন্ন হয়েছে");
    }

    /**
     * Employee Chenge Status
     */
    public function status($id)
    {
        $user = User::find($id, ['id', 'status']);

        if ($user->status == 1) {
            $user->status = 0;
        } else {
            $user->status = 1;
        }
        $user->save();

        return back()->with('success', 'অফিসারের স্ট্যাটাস পরিবর্তন করা হয়েছে');
    }

    /**
     * Employee Edit Page
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::whereNotIn('name', ['ডেভেলপার'])->get();

        return view('backend.employee.edit', compact('user', 'roles'));
    }

    /**
     * Employee Update
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'password' => 'min:8'
        ], [
            'name.required' => 'নাম প্রয়োজন',
            'password.min' => 'আট সংখ্যার পাসওয়ার্ড প্রয়োজন'
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        if (isset($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->syncRoles([$request->role]);
        $user->save();

        // $roles = Role::whereNotIn('name', ['ডেভেলপার'])->get();
        // $users = new User();
        // $user = $users->all();
        // return view('backend.employee.index', compact('user', 'roles'));
        return redirect(Route('employee.all'))->with('success', 'অফিসারের তথ্য পরিবর্তন করা হয়েছে');
    }
}
