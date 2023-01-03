<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
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
        $categories = category::all();
        $v = DB::statement('SELECT c.*, SUM(s.stock) AS stock FROM categories AS c LEFT JOIN stocks AS s ON s.category_id = c.id GROUP BY c.id');
        dd($v);
        return view('backend.category.index', compact('categories'));
    }

    /**
     * Store Catetory
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'unique:categories,category_name'
        ], [
            'name.unique' => 'এই নাম এর ক্যাটাগরি আগে থেকেই রেজিস্ট্রেশন হয়েছে'
        ]);

        /**
         * Attemp to Store Catetory
         */
        $cat = new category();
        $cat->category_name  = $request->name;
        $cat->category_details = $request->details;
        $cat->save();


        $success = [
            'status' => true,
            'message' =>  "$request->name নাম এর ক্যাটাগরি রেজিস্ট্রেশন সম্পন্ন হয়েছে"
        ];
        return response()->json($success);
    }

    /**
     * Edit Category
     */
    public function edit($id)
    {
        $category = category::find($id);
        $data = [
            'id' => $category->id,
            'name' => $category->category_name,
            'details' => $category->category_details
        ];

        return response()->json($data);
    }

    /**
     * Update Category
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'unique:categories,category_name'
        ], [
            'name.unique' => 'এই নাম এর ক্যাটাগরি আগে থেকেই রেজিস্ট্রেশন হয়েছে'
        ]);

        $cat = category::find($id, ['id', 'category_name', 'category_details']);
        $cat->category_name  = $request->up_name;
        $cat->category_details = $request->up_details;
        $cat->save();

        $success = [
            'status' => true,
            'message' =>  "$request->up_name নাম এর ক্যাটাগরি আপডেট সম্পন্ন হয়েছে"
        ];
        return response()->json($success);
    }

    /**
     * Delete Category
     */
    public function delete($id)
    {
        $category = category::find($id);
        $category->delete();
        return back()->with('success', 'ক্যাটাগরি ডিলিট সম্পন্ন হয়েছে');
    }
}
