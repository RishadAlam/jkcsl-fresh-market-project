<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeLoginController extends Controller
{
    public function login(Request $request)
    {
        // @dd($request->all());
        /**
         * Login Credentials Validation
         */
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'ইমেল প্রয়োজন',
            'email.email' => 'সঠিক ইমেল ব্যবহার করুন',
            'password.required' => 'পাসওয়ার্ড প্রয়োজন'
        ]);

        /**
         * Auth Validation Check
         */
        if (User::where('email', $request->email)->get()->count() > 0) {

            $user = User::first()->where('email', $request->email)->get(['password', 'status']);
            // dd($user->all());
            foreach ($user->all() as $row) {
                $password = $row['password'];
                $status = $row['status'];
            }
            /**
             * Auth Password Check
             */
            if (Hash::check($request->password, $password)) {
                /**
                 * Auth status check
                 */
                if ($status == 1) {
                    /**
                     * Attemp to login
                     */
                    if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
                        return redirect()->intended(route('dashboard'));
                    } else {
                        return back()->with('loginError', 'আপনার দেওয়া তথ্য সঠিক নয়');
                    }
                } elseif ($status == 0) {
                    return back()->with("loginErrorStatus", "আপনার একাউন্ট সাময়িক ভাবে বন্ধ করা হয়েছে");
                } elseif ($status == 2) {
                    return back()->with("loginErrorStatus", "আপনার ইমেল যাচাই করা হয়নি। দয়াকরে ইমেল চেক করুন");
                }
            } else {
                return back()->with("loginErrorPassword", "ভুল পাসওয়ার্ড দিয়েছেন");
            }
        } else {
            return back()->with("loginErrorEmail", "ভুল ইমেল দিয়েছেন");
        }
    }
}
