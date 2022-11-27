<?php

namespace App\Http\Controllers;

use App\Models\stock;
use App\Models\category;
use Illuminate\Http\Request;

class StockManageController extends Controller
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
        $categories = category::get(['id', 'category_name']);
        $stocks = category::with('stock')->get();
        return view('backend.stock.stock', compact('categories', 'stocks'));
    }

    /**
     * Store Stock
     */
    public function store(Request $request)
    {
        /**
         * Attemp to Store Stock
         */
        $stock = new stock();
        $stock->name  = $request->name;
        $stock->category_id = $request->category;
        $stock->real_price = $request->real_price;
        $stock->profit = $request->profit;
        $stock->total = $request->total;
        $stock->stock = $request->stock;
        $stock->details = $request->details;
        $stock->save();


        $success = [
            'status' => true,
            'message' =>  "$request->name রেজিস্ট্রেশন সম্পন্ন হয়েছে"
        ];
        return response()->json($success);
    }

    /**
     * Edit Category
     */
    public function edit($id)
    {
        $stock = stock::find($id);
        $data = [
            'id' => $stock->id,
            'name' => $stock->name,
            'category_id' => $stock->category_id,
            'real_price' => $stock->real_price,
            'profit' => $stock->profit,
            'total' => $stock->total,
            'stock' => $stock->stock,
            'details' => $stock->details,
        ];
        return response()->json($data);
    }

    /**
     * Update Category
     */
    public function update(Request $request, $id)
    {
        $stock = stock::find($id, ['id', 'name', 'category_id', 'real_price', 'profit', 'total', 'stock', 'details']);
        $stock->name  = $request->up_name;
        $stock->category_id = $request->up_category;
        $stock->real_price = $request->up_real_price;
        $stock->profit = $request->up_profit;
        $stock->total = $request->up_total;
        $stock->stock = $request->up_stock;
        $stock->details = $request->up_details;
        $stock->save();

        $success = [
            'status' => true,
            'message' =>  "$request->up_name নাম এর স্টক আপডেট সম্পন্ন হয়েছে"
        ];
        return response()->json($success);
    }

    /**
     * Delete Category
     */
    public function delete($id)
    {
        $stock = stock::find($id);
        $stock->delete();
        return back()->with('success', 'স্টক ডিলিট সম্পন্ন হয়েছে');
    }
}
