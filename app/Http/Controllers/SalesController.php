<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\stock;
use App\Models\Setting;
use App\Models\CardSale;
use App\Models\category;
use App\Models\serviceSale;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class SalesController extends Controller
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
    public function card()
    {
        $settings = Setting::first();
        $officers = User::where('status', true)
            ->whereNotIn('email', ['admin@gmail.com'])
            ->get(['id', 'name']);
        $solds = cardSale::whereDay('created_at', now()->day)
            ->where('status', false)
            ->with('User')
            ->orderby('id', 'DESC')
            ->get();
        return view('backend.sales.cardSalse', compact('officers', 'settings', 'solds'));
    }

    /**
     * Packege Sales Page
     */
    public function package()
    {
        $officers = User::where('status', true)
            ->whereNotIn('email', ['admin@gmail.com'])
            ->get(['id', 'name']);
        $categories = category::get(['id', 'category_name']);
        $solds = serviceSale::whereDay('created_at', now()->day)
            ->with('User')
            ->with('category')
            ->with('stock')
            ->orderby('id', 'DESC')
            ->get();
        // dd($solds);
        return view('backend.sales.packageSalse', compact('officers', 'categories', 'solds'));
    }

    /**
     * Cards Sales Report Page
     */
    public function report(Request $request)
    {
        /**
         * Query Build
         */
        $query = cardSale::query();
        if (isset($request->daterange)) {
            /**
             * Date Explod In two date
             */
            $date = explode('-', $request->daterange);
            $form_date = date("Y-m-d", strtotime($date['0']));
            if (isset($date['1'])) {
                $end_date = date("Y-m-d", strtotime($date['1']));
            } else {
                $end_date = date("Y-m-d", strtotime($date['0']));
            }

            /**
             * Query Date Range
             */
            $query->whereBetween('created_at', [$form_date, Carbon::parse($end_date)->endofDay()]);
        } else {
            /**
             * Store Date for Query Build
             */
            $form_date = Carbon::now()->startOfMonth();
            $end_date = Carbon::now()->endOfDay();

            /**
             * Query Default Date Range
             */
            $query->whereBetween('created_at', [$form_date, $end_date]);
        }

        /**
         * Author Data Filter Query
         */
        if (isset($request->officer_id)) {
            $query->where('user_id', $request->officer_id);
        }

        /**
         * Default Query
         */
        $solds = $query->where('status', true)
            ->with('User')
            ->orderby('id', 'DESC')
            ->paginate(25);

        /**
         * Officer Data
         */
        $officers = User::where('status', true)
            ->whereNotIn('email', ['admin@gmail.com'])
            ->get(['id', 'name']);

        /**
         * Return View With Data
         */
        return view('backend.sales.cardSalesReport', compact('solds', 'officers'));
    }

    /**
     * Total Sales Report Page
     */
    public function totalReport(Request $request)
    {
        /**
         * Query Build
         */
        $query = serviceSale::query();
        if (isset($request->daterange)) {
            /**
             * Date Explod In two date
             */
            $date = explode('-', $request->daterange);
            $form_date = date("Y-m-d", strtotime($date['0']));
            if (isset($date['1'])) {
                $end_date = date("Y-m-d", strtotime($date['1']));
            } else {
                $end_date = date("Y-m-d", strtotime($date['0']));
            }

            /**
             * Query Date Range
             */
            $query->whereBetween('created_at', [$form_date, Carbon::parse($end_date)->endofDay()]);
        } else {
            /**
             * Store Date for Query Build
             */
            $form_date = Carbon::now()->startOfMonth();
            $end_date = Carbon::now()->endOfDay();

            /**
             * Query Default Date Range
             */
            $solds = serviceSale::whereBetween('created_at', [$form_date, $end_date]);
        }

        /**
         * Author Data Filter Query
         */
        if (isset($request->officer_id)) {
            $query->where('user_id', $request->officer_id);
        }

        /**
         * Default Query
         */
        $solds = $query->with('User')
            ->with('category')
            ->with('stock')
            ->orderby('id', 'DESC')
            ->paginate(25);

        /**
         * Officer Data
         */
        $officers = User::where('status', true)
            ->whereNotIn('email', ['admin@gmail.com'])
            ->get(['id', 'name']);

        /**
         * Return View With Data
         */
        return view('backend.sales.totalReport', compact('solds', 'officers'));
    }

    /**
     * Packege Sales stock product List
     */
    public function stockList($id)
    {
        $stocks = stock::where('category_id', $id)->get(['id', 'name']);
        return $stocks;
    }

    /**
     * Packege Sales Page product load
     */
    public function product($id)
    {
        $product = stock::where('id', $id)->get(['total', 'stock', 'profit'])->first();
        return $product;
    }

    /**
     * Packege Sales store
     */
    public function productStore(Request $request)
    {
        $request->validate([
            'officer_id' => 'required|numeric',
            'category' => 'required|numeric',
            'product' => 'required|numeric',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'quantity' => 'required|numeric|min:0',
            'stock_rem' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0'
        ], [
            'officer_id.required' => 'অফিসার নির্বাচন করুন',
            'category.required' => 'ক্যাটাগরি নির্বাচন করুন',
            'product.required' => 'পণ্য নির্বাচন করুন',
            'price.required' => 'মূল্য দর দিন',
            'stock.required' => 'স্টক দিন',
            'quantity.required' => 'বিক্রয় সংখ্যা দিন',
            'total_price.required' => 'বিক্রয় মূল্য দিন',
            'quantity.min' => 'বিক্রয় সংখ্যা দিন',
            'stock_rem.required' => 'অবশিষ্ট স্টক দিন',
            'stock_rem.min' => 'স্টক শেষ',
        ]);

        $productStore = new serviceSale();
        $productStore->user_id = $request->officer_id;
        $productStore->category_id = $request->category;
        $productStore->stock_id = $request->product;
        $productStore->net_price = $request->price;
        $productStore->quantity = $request->quantity;
        $productStore->total_profit = $request->total_profit;
        $productStore->total_price = $request->total_price;
        $productStore->details = $request->details;
        $productStore->save();

        $stocks = stock::find($request->product, ['id', 'stock']);
        $stocks->stock = ($stocks->stock - $request->quantity);
        $stocks->save();

        return back()->with("success", "সার্ভিস বিক্রয় সম্পন্ন হয়েছে");
    }

    /**
     * Delete Service Sale
     */
    public function productDelete($id)
    {
        $solds = serviceSale::find($id);
        stock::find($solds->stock_id)
            ->increment('stock', $solds->quantity);

        $solds->delete();
        return back()->with('success', 'বিক্রয় ডিলিট সম্পন্ন হয়েছে');
    }

    /**
     * Edit Service Sale
     */
    public function productEdit($id)
    {
        $officers = User::where('status', true)
            ->whereNotIn('email', ['admin@gmail.com'])
            ->get(['id', 'name']);
        $solds = serviceSale::with('User')
            ->with('category')
            ->with('stock')
            ->orderby('id', 'DESC')
            ->find($id);

        return view('backend.sales.packegeEdit', compact('solds', 'officers'));
    }

    /**
     * Update Service Sale
     */
    public function productUpdate(Request $request, $id)
    {
        $request->validate([
            'officer_id' => 'required|numeric',
            'stock' => 'required|numeric',
            'quantity' => 'required|numeric|min:0',
            'stock_rem' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0'
        ], [
            'officer_id.required' => 'অফিসার নির্বাচন করুন',
            'stock.required' => 'স্টক দিন',
            'quantity.required' => 'বিক্রয় সংখ্যা দিন',
            'total_price.required' => 'বিক্রয় মূল্য দিন',
            'quantity.min' => 'বিক্রয় সংখ্যা দিন',
            'stock_rem.required' => 'অবশিষ্ট স্টক দিন',
            'stock_rem.min' => 'স্টক শেষ',
        ]);

        $productUpdate = serviceSale::find($id, ['id', 'user_id', 'stock_id', 'quantity', 'total_price', 'details']);
        $productUpdate->user_id = $request->officer_id;
        $productUpdate->quantity = $request->quantity;
        $productUpdate->total_price = $request->total_price;
        $productUpdate->details = $request->details;
        $productUpdate->save();

        $stock = stock::find($productUpdate->stock_id, ['id', 'stock']);
        $stock->stock = $request->stock_rem;
        $stock->save();

        return redirect(Route('sales.totalReport'))->with('success', 'আপডেট সম্পন্ন হয়েছে');
    }


    /**
     * Card Sales store
     */
    public function cardStore(Request $request)
    {
        $request->validate([
            'officer_id' => 'required|numeric',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric|gt:0',
            'total_price' => 'required|numeric|gt:0'
        ], [
            'officer_id.required' => 'অফিসার নির্বাচন করুন',
            'price.required' => 'মূল্য দর দিন',
            'quantity.required' => 'বিক্রয় সংখ্যা দিন',
            'total_price.required' => 'বিক্রয় মূল্য দিন',
            'quantity.gt' => 'বিক্রয় সংখ্যা দিন',
        ]);

        $cardStore = new CardSale();
        $cardStore->user_id = $request->officer_id;
        $cardStore->net_price = $request->price;
        $cardStore->quantity = $request->quantity;
        $cardStore->total_price = $request->total_price;
        $cardStore->details = $request->details;
        $cardStore->save();

        return back()->with("success", "কার্ড বিক্রয় সম্পন্ন হয়েছে");
    }

    /**
     * Delete Card Sale
     */
    public function cardDelete($id)
    {
        $solds = CardSale::find($id);
        $solds->delete();
        return back()->with('success', 'বিক্রয় ডিলিট সম্পন্ন হয়েছে');
    }

    /**
     * Edit Card Sale
     */
    public function cardEdit($id)
    {
        $officers = User::where('status', true)
            ->whereNotIn('email', ['admin@gmail.com'])
            ->get(['id', 'name']);
        $solds = CardSale::with('User')
            ->orderby('id', 'DESC')
            ->find($id);

        return view('backend.sales.cardEdit', compact('solds', 'officers'));
    }

    /**
     * Update Service Sale
     */
    public function cardUpdate(Request $request, $id)
    {
        $request->validate([
            'officer_id' => 'required|numeric',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric|gt:0',
            'total_price' => 'required|numeric|gt:0'
        ], [
            'officer_id.required' => 'অফিসার নির্বাচন করুন',
            'price.required' => 'মূল্য দর দিন',
            'quantity.required' => 'বিক্রয় সংখ্যা দিন',
            'total_price.required' => 'বিক্রয় মূল্য দিন',
            'quantity.gt' => 'বিক্রয় সংখ্যা দিন',
        ]);

        $cardUpdate = CardSale::find($id);
        $cardUpdate->user_id = $request->officer_id;
        $cardUpdate->net_price = $request->price;
        $cardUpdate->quantity = $request->quantity;
        $cardUpdate->total_price = $request->total_price;
        $cardUpdate->details = $request->details;
        $cardUpdate->save();

        return redirect(Route('sales.card'))->with('success', 'আপডেট সম্পন্ন হয়েছে');
    }

    /**
     * Card Sale Approval
     */
    public function cardApprove(Request $request)
    {
        $cards = CardSale::find($request->id);
        foreach ($cards as $card) {
            $card->status = true;
            $card->save();
        }

        $success = [
            'status' => true,
            'message' =>  "অনুমোদন সম্পন্ন হয়েছে"
        ];
        return response()->json($success);
    }

    /**
     * Card Sale Tamadi
     */
    public function cardTamadi(Request $request)
    {
        /**
         * Query Build
         */
        $query = cardSale::query();
        if (isset($request->daterange)) {
            /**
             * Date Explod In two date
             */
            $date = explode('-', $request->daterange);
            $form_date = date("Y-m-d", strtotime($date['0']));
            if (isset($date['1'])) {
                $end_date = date("Y-m-d", strtotime($date['1']));
            } else {
                $end_date = date("Y-m-d", strtotime($date['0']));
            }

            /**
             * Query Date Range
             */
            $query->whereBetween('created_at', [$form_date, Carbon::parse($end_date)->endofDay()]);
        }

        /**
         * Author Data Filter Query
         */
        if (isset($request->officer_id)) {
            $query->where('user_id', $request->officer_id);
        }

        /**
         * Default Query
         */
        $solds = $query->whereDate('created_at', '<', now()->today())
            ->where('status', false)
            ->with('User')
            ->orderby('id', 'DESC')
            ->get();

        /**
         * Officer Data
         */
        $officers = User::where('status', true)
            ->whereNotIn('email', ['admin@gmail.com'])
            ->get(['id', 'name']);

        /**
         * Return View With Data
         */
        return view('backend.sales.cardSalesTamadi', compact('officers', 'solds'));
    }
}
