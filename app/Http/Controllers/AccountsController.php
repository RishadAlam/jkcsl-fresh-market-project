<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\salary;
use App\Models\Expence;
use App\Models\Setting;
use App\Models\CardSale;
use App\Models\serviceSale;
use Illuminate\Http\Request;
use App\Models\officer_expence;

class AccountsController extends Controller
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
    public function index(Request $request)
    {
        /**
         * Expences
         */
        $expenceQuery = Expence::query();
        $officerExpenceQuery = officer_expence::query();
        $salaryExpenceQuery = salary::query();

        /**
         * Incomes
         */
        $cardQuery = CardSale::query();
        $serviceQuery = serviceSale::query();

        if (isset($request->month)) {
            /**
             * Month Range From Request
             */
            $month = date('m', strtotime($request->month));
            $year =  date('Y', strtotime($request->month));

            /**
             * Expences
             */
            $expenceQuery->whereMonth('date', $month)
                ->whereYear('date', $year);
            $officerExpenceQuery->whereMonth('date', $month)
                ->whereYear('date', $year);
            $salaryExpenceQuery->whereMonth('month', $month)
                ->whereYear('month', $year);

            /**
             * Incomes
             */
            $cardQuery->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
            $serviceQuery->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        } else {
            /**
             * Month Range From Default
             */
            $month = date('m', strtotime(Carbon::now()));
            $year =  date('Y', strtotime(Carbon::now()));

            /**
             * Expences
             */
            $expenceQuery->whereMonth('date', $month)
                ->whereYear('date', $year);
            $officerExpenceQuery->whereMonth('date', $month)
                ->whereYear('date', $year);
            $salaryExpenceQuery->whereMonth('month', $month)
                ->whereYear('month', $year);

            /**
             * Incomes
             */
            $cardQuery->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
            $serviceQuery->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        }

        /**
         * Expences main query
         */
        $allExpences['expences'] = $expenceQuery->sum('expence');
        $allExpences['officerExpences'] = $officerExpenceQuery->sum('expence');
        $allExpences['salaries'] = $salaryExpenceQuery->sum('total_salary');
        $totalExpence = array_sum($allExpences);

        /**
         * Incomes main query
         */
        $allincomes['cards'] = $cardQuery->sum('total_price');
        $allincomes['services'] = $serviceQuery->sum('total_profit');
        $totalincome = array_sum($allincomes);

        return view('backend.accounts.index', compact('allExpences', 'totalExpence', 'allincomes', 'totalincome'));
    }

    public function shareAccounts(Request $request)
    {
        /**
         * Expences
         */
        $expenceQuery = Expence::query();
        $officerExpenceQuery = officer_expence::query();
        $salaryExpenceQuery = salary::query();

        /**
         * Incomes
         */
        $cardQuery = CardSale::query();
        $serviceQuery = serviceSale::query();

        if (isset($request->month)) {
            /**
             * Month Range From Request
             */
            $month = date('m', strtotime($request->month));
            $year =  date('Y', strtotime($request->month));

            /**
             * Expences
             */
            $expenceQuery->whereMonth('date', $month)
                ->whereYear('date', $year);
            $officerExpenceQuery->whereMonth('date', $month)
                ->whereYear('date', $year);
            $salaryExpenceQuery->whereMonth('month', $month)
                ->whereYear('month', $year);

            /**
             * Incomes
             */
            $cardQuery->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
            $serviceQuery->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        } else {
            /**
             * Month Range From Default
             */
            $month = date('m', strtotime(Carbon::now()));
            $year =  date('Y', strtotime(Carbon::now()));

            /**
             * Expences
             */
            $expenceQuery->whereMonth('date', $month)
                ->whereYear('date', $year);
            $officerExpenceQuery->whereMonth('date', $month)
                ->whereYear('date', $year);
            $salaryExpenceQuery->whereMonth('month', $month)
                ->whereYear('month', $year);

            /**
             * Incomes
             */
            $cardQuery->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
            $serviceQuery->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        }

        /**
         * Expences main query
         */
        $allExpences['expences'] = $expenceQuery->sum('expence');
        $allExpences['officerExpences'] = $officerExpenceQuery->sum('expence');
        $allExpences['salaries'] = $salaryExpenceQuery->sum('total_salary');
        $totalExpence = array_sum($allExpences);

        /**
         * Incomes main query
         */
        $allincomes['cards'] = $cardQuery->sum('total_price');
        $allincomes['services'] = $serviceQuery->sum('total_profit');

        $shareQuantity = Setting::get('share_quantity')->first();

        return view('backend.accounts.shareAccounts', compact('allExpences', 'totalExpence', 'allincomes', 'shareQuantity'));
    }
}
