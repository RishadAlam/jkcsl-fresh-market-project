<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
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
        $settings = Setting::find(1);
        return view('backend.webSettings.index', compact('settings'));
    }

    /**
     * Update Category
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'card_price' => 'required',
            'card_percentage' => 'required',
            'share_quantity' => 'required'
        ], [
            'name.required' => 'সফ্টওয়্যার নাম দিন',
            'card_price.required' => 'কার্ডের দাম দিন',
            'card_percentage.required' => 'কার্ড কমিশন দিন',
            'share_quantity.required' => 'শেয়ার সংখ্যা দিন',
        ]);

        $settings = Setting::find($id);
        $settings->name  = $request->name;
        $settings->card_price = $request->card_price;
        $settings->card_percentage = $request->card_percentage;
        $settings->share_quantity = $request->share_quantity;
        $settings->save();

        $success = [
            'status' => true,
            'message' =>  "$request->up_name নাম এর ক্যাটাগরি আপডেট সম্পন্ন হয়েছে"
        ];
        return back()->with('success', 'আপডেট সম্পন্ন হয়েছে');
    }
}
