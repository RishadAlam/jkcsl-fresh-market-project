<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\salary;
use App\Models\Expence;
use App\Models\Setting;
use App\Models\cardSale;
use App\Models\serviceSale;
use App\Models\officer_expence;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function salesReport($daterange, $officer_id)
    {
        /**
         * Date Explod In two date
         */
        $month = date("m", strtotime($daterange));
        $year = date("Y", strtotime($daterange));

        $solds = cardSale::where('user_id', $officer_id)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', true)
            ->with('User')
            ->get();

        $card_percentage = Setting::get(['card_percentage', 'name']);
        $user = User::find($officer_id);

        return view('backend.print.salseReport', compact('solds', 'card_percentage', 'user'));
    }

    public function salaryPrint($id)
    {
        $card_percentage = Setting::get(['card_percentage', 'name']);
        $salary = salary::with('User')->find($id);
        // dd($salary);
        return view('backend.print.salaryPrint', compact('salary', 'card_percentage',));
    }

    public function accCalculationsPrint($month)
    {
        $monthYear = date('F-Y', strtotime($month));
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

        /**
         * Month Range From Request
         */
        $month = date('m', strtotime($monthYear));
        $year =  date('Y', strtotime($monthYear));

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
        $card_percentage = Setting::get(['card_percentage', 'name']);

        return view('backend.print.accCalculationsPrint', compact('allExpences', 'totalExpence', 'allincomes', 'totalincome', 'card_percentage', 'monthYear'));
    }

    public function shareAccCalculationsPrint($month)
    {
        $monthYear = date('F-Y', strtotime($month));
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

        /**
         * Month Range From Request
         */
        $month = date('m', strtotime($monthYear));
        $year =  date('Y', strtotime($monthYear));

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
        $card_percentage = Setting::get(['card_percentage', 'name']);

        return view('backend.print.shareAccCalculationPrint', compact('allExpences', 'totalExpence', 'allincomes', 'shareQuantity', 'card_percentage', 'monthYear'));
    }
}
