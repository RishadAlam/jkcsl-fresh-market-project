<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\salary;
use App\Models\Setting;
use App\Models\CardSale;
use Illuminate\Http\Request;
use App\Models\officer_expence;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
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
    public function salesReport(Request $request)
    {
        /**
         * Query Build
         */
        $query = cardSale::query();
        if (isset($request->month)) {
            /**
             * Month Range From Request
             */
            $month = date('m', strtotime($request->month));
            $year =  date('Y', strtotime($request->month));

            /**
             * Query Date Range
             */
            $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        } else {
            /**
             * Month Range From Default
             */
            $month = date('m', strtotime(Carbon::now()));
            $year =  date('Y', strtotime(Carbon::now()));

            /**
             * Query Default Date Range
             */
            $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
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
            ->get();

        /**
         * Officer Data
         */
        $officers = User::where('status', true)
            ->whereNotIn('email', ['admin@gmail.com'])
            ->get(['id', 'name']);
        $card_percentage = Setting::get(['card_percentage']);

        /**
         * Return View With Data
         */
        return view('backend.salary.salesReport', compact('solds', 'officers', 'card_percentage'));
    }

    /**
     * View Salary Records And Form
     */
    public function salaryForm(Request $request)
    {
        /**
         * officer Data
         */
        $officers = User::whereNotIn('status', ['2'])
            ->whereNotIn('email', ['admin@gmail.com'])
            ->get(['id', 'name']);

        /**
         * Card Percentage
         */
        $card_percentage = Setting::get(['card_percentage']);

        /**
         * Salary Table Data
         */
        $query = salary::query();
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
         * Default Query
         */
        $salaries = $query->with('User')
            ->orderBy('id', 'DESC')
            ->get();

        return view('backend.salary.index', compact('officers', 'card_percentage', 'salaries'));
    }

    /**
     * Store Salary Records
     */
    public function store(Request $request)
    {
        /**
         * Validate Data
         */
        $request->validate([
            'officer' => 'required',
            'month' => 'required',
            'salery_per' => 'required',
            'expence' => 'required',
            'present_bonus' => 'required',
            'extra_1' => 'required',
            'extra_2' => 'required',
            'extra_3' => 'required',
            'basic_salary' => 'required',
            'total_salary' => 'required',
        ], [
            'officer.required' => 'অফিসার নির্বাচন করুন',
            'month.required' => 'মাস নির্বাচন করুন',
            'present_bonus.required' => 'উপস্থিতি বোনাস দিন',
            'extra_1.required' => 'চা-নাস্তা বিল দিন',
            'extra_2.required' => 'গাড়ি ভাড়া বিল দিন',
            'extra_3.required' => 'মোবাইল বিল দিন',
            'basic_salary.required' => 'বেসিক বেতন দিন',
        ]);

        /**
         * Store Data
         */
        $salary = new salary();
        $salary->user_id = $request->officer;
        $salary->month = $request->month;
        $salary->total_sale = $request->total_sale;
        $salary->salery_percentage = $request->salery_per;
        $salary->expence = $request->expence;
        $salary->present_bonus = $request->present_bonus;
        $salary->extra_1 = $request->extra_1;
        $salary->extra_2 = $request->extra_2;
        $salary->extra_3 = $request->extra_3;
        $salary->basic_salary = $request->basic_salary;
        $salary->total_salary = $request->total_salary;
        $salary->save();

        return back()->with('success', 'বেতন সম্পন্ন হয়েছে');
    }

    /**
     * Dependent Value Form Data
     */
    public function storeValue(Request $request)
    {
        /**
         * Data Filtered
         */
        $month = date('m', strtotime($request->month));
        $year =  date('Y', strtotime($request->month));
        $officer_id = $request->officer_id;

        /**
         * Sum Query on Card Sale Table 
         */
        $sum = CardSale::select([
            DB::raw("SUM(quantity) as quantity "),
            DB::raw("SUM(total_price) as total_price "),
        ])
            ->where('status', true)
            ->where('user_id', $officer_id)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->first();

        /**
         * Sum Query on officer Expence Table 
         */
        $expence = officer_expence::where('user_id', $officer_id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('expence');

        $card_percentage = Setting::get(['card_percentage']);
        $percentage = ($card_percentage[0]->card_percentage / 100) * $sum->total_price;

        /**
         * percentage Store in array
         */
        $sum['percentage'] = "$percentage";
        $sum['expence'] = "$expence";
        return json_encode($sum);
    }

    /**
     * Delete Salary
     */
    public function delete($id)
    {
        $salary = salary::find($id);
        $salary->delete();

        return back()->with('success', 'বেতন ডিলিট সম্পন্ন হয়েছে');
    }

    /**
     * Edit Salary
     */
    public function edit($id)
    {
        $salary = salary::with('User')
            ->where('id', $id)
            ->first();

        // dd($salary->expence);
        return view('backend.salary.edit', compact('salary'));
    }

    /**
     * Store Salary Records
     */
    public function update(Request $request, $id)
    {
        /**
         * Validate Data
         */
        $request->validate([
            'month' => 'required',
            'present_bonus' => 'required',
            'extra_1' => 'required',
            'extra_2' => 'required',
            'extra_3' => 'required',
            'basic_salary' => 'required',
            'total_salary' => 'required',
        ], [
            'month.required' => 'মাস নির্বাচন করুন',
            'present_bonus.required' => 'উপস্থিতি বোনাস দিন',
            'extra_1.required' => 'চা-নাস্তা বিল দিন',
            'extra_2.required' => 'গাড়ি ভাড়া বিল দিন',
            'extra_3.required' => 'মোবাইল বিল দিন',
            'basic_salary.required' => 'বেসিক বেতন দিন',
        ]);

        /**
         * Update Data
         */
        $salary = salary::find($id);
        $salary->month = $request->month;
        $salary->present_bonus = $request->present_bonus;
        $salary->extra_1 = $request->extra_1;
        $salary->extra_2 = $request->extra_2;
        $salary->extra_3 = $request->extra_3;
        $salary->basic_salary = $request->basic_salary;
        $salary->total_salary = $request->total_salary;
        $salary->save();

        return redirect(Route('salary.form'))->with('success', 'বেতন আপডেট সম্পন্ন হয়েছে');
    }
}
