<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
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
        return view('backend.profile.index');
    }
    /**
     * Password Reset Page
     */
    public function passwordReset()
    {
        return view('backend.profile.passwordReset');
    }

    /**
     * Password Change
     */
    public function passwordChenge(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirmed_password' => 'required|same:new_password',
        ], [
            'current_password.required' => 'পূর্বের পাসওয়ার্ড দিন',
            'new_password.required' => 'নতুন পাসওয়ার্ড দিন',
            'new_password.min' => '৮ অক্ষরের পাসওয়ার্ড দিন',
            'new_password.required' => 'নিশ্চিত পাসওয়ার্ড দিন',
            'confirmed_password.same' => 'পাসওয়ার্ড নিশ্চিত হয়নি',
        ]);

        #Match The Old Password
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->with("current_password", "ভুল পাসওয়ার্ড");
        }

        #Update the new Password
        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("success", "পাসওয়ার্ড পরিবর্তন সম্পন্ন হয়েছে");
    }

    /**
     * Profile Update
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'img' => 'mimes:png,jpg,webp,jpeg'
        ], [
            'name.required' => 'নাম লিখুন',
            'img.mimes' => 'png,jpg,webp,jpeg ফরমেটের ছবি দিন',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->father_name = $request->fatherName;
        $user->phone = $request->mobile;
        $user->phone2  = $request->mobile_2;
        $user->nid  = $request->nid;
        $user->dob  = $request->dob;
        $user->blood  = $request->blood;

        /**
         * Image Procecing
         */
        if (!empty($request->img)) {
            if ($request->old_img != null) {
                $path = public_path('storage/images/' . $request->old_img . '');
                unlink($path);
            }
            $extention = $request->img->extension();
            $imgName = 'user_' . time() . '.' . $extention;
            $imagePath = $request->img->storeAs('images/', $imgName, 'public');
            $user->image  = $imgName;
        }

        $user->save();

        return back()->with('success', 'প্রফাইল আপডেট সম্পন্ন হয়েছে');
    }
}
