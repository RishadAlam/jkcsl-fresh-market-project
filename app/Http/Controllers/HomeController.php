<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\stock;
use App\Models\CardSale;
use App\Models\category;
use App\Models\serviceSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
        /**
         * Store Date for Query Build
         */
        $form_date = Carbon::now()->startOfMonth();
        $end_date = Carbon::now()->endOfDay();

        /**
         * Queries
         */

        $query1 = cardSale::query();
        $query2 = serviceSale::query();
        $query3 = cardSale::query();
        $query4 = serviceSale::query();
        $query5 = serviceSale::query();
        $query6 = cardSale::query();
        if (!Auth::user()->roles->first()->hasPermissionTo('ড্যাশবোর্ড অ্যাডমিন')) {
            $query1->where('user_id', Auth::user()->id);
            $query2->where('user_id', Auth::user()->id);
            $query3->where('user_id', Auth::user()->id);
            $query4->where('user_id', Auth::user()->id);
            $query5->where('user_id', Auth::user()->id);
            $query6->where('user_id', Auth::user()->id);
        }


        $stocks = stock::sum('stock');
        $serviceSale = $query5->whereBetween('created_at', [$form_date, $end_date])
            ->sum('quantity');
        $cardSale = $query6->whereBetween('created_at', [$form_date, $end_date])
            ->where('status', true)
            ->sum('quantity');
        $totals['stocks'] = $stocks;
        $totals['serviceSale'] = $serviceSale;
        $totals['cardSale'] = $cardSale;


        $solds = $query1->whereDay('created_at', now()->day)
            ->with('User')
            ->orderby('id', 'DESC')
            ->paginate(10);

        $services = $query2->whereDay('created_at', now()->day)

            ->with('User')
            ->with('category')
            ->with('stock')
            ->orderby('id', 'DESC')
            ->paginate(10);

        $totalCards = $query3->with('User')
            ->select([
                DB::raw("SUM(quantity) AS quantity, user_id")
            ])
            ->whereDay('created_at', now()->day)
            ->groupBy('user_id')
            ->get();

        $totalservices = $query4->with('User')
            ->select([
                DB::raw("SUM(quantity) AS quantity, user_id")
            ])
            ->whereDay('created_at', now()->day)
            ->groupBy('user_id')
            ->get();



        return view('backend.index', compact('solds', 'services', 'totals', 'totalCards', 'totalservices'));
    }
}
