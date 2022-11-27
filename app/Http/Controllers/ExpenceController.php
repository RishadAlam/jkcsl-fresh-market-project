<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Expence;
use Illuminate\Http\Request;
use App\Models\officer_expence;

class ExpenceController extends Controller
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
        $query = Expence::query();
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

            $query->whereBetween('date', [$form_date, $end_date]);
        } else {

            $form_date = Carbon::now()->startOfMonth();
            $end_date = Carbon::now()->endOfDay();

            $query->whereBetween('date', [$form_date, $end_date]);
        }
        $expences = $query->orderby('id', 'DESC')
            ->paginate(25);

        return view('backend.expence.index', compact('expences'));
    }

    /**
     * Optimize Validation
     */
    private function compactValidation($request)
    {
        $request->validate([
            'date' => 'required',
            'expence' => 'required',
            'details' => 'required',
        ], [
            'date.required' => "তারিখ দিন",
            'expence.required' => "খরচ দিন",
            'details.required' => "খরচের বিবরণ দিন",
        ]);
    }

    private function compactValidation2nd($request)
    {
        $request->validate([
            'date' => 'required',
            'expence' => 'required',
            'officer_id' => 'required',
        ], [
            'date.required' => "তারিখ দিন",
            'expence.required' => "খরচ দিন",
            'officer_id.required' => "অফিসার নির্বাচন করুন",
        ]);
    }

    /**
     * Optimize Insert Assign
     */
    private function compactData($expences, $request)
    {
        $expences->date = $request->date;
        $expences->expence = $request->expence;
        $expences->details = $request->details;
    }

    private function compactData2nd($expence, $request)
    {
        $expence->user_id = $request->officer_id;
        $expence->date = $request->date;
        $expence->expence = $request->expence;
    }

    /**
     * Expence Store
     */
    public function store(Request $request)
    {
        $this->compactValidation($request);

        $expences = new Expence();
        $this->compactData($expences, $request);
        $expences->save();

        $success = [
            'status' => true,
            'message' =>  "খরচ সম্পন্ন হয়েছে"
        ];
        return back()->with('success', 'খরচ সম্পন্ন হয়েছে');
    }

    /**
     * Delete Expence
     */
    public function delete($id)
    {
        $expence = Expence::find($id);
        $expence->delete();
        return back()->with('success', 'খরচ ডিলিট সম্পন্ন হয়েছে');
    }

    /**
     * Edit expence
     */
    public function edit($id)
    {
        $expence = Expence::find($id);
        return view('backend.expence.edit', compact('expence'));
    }

    /**
     * Expence Update
     */
    public function update(Request $request, $id)
    {
        $this->compactValidation($request);

        $expences = Expence::find($id);
        $this->compactData($expences, $request);
        $expences->save();

        return redirect(Route('expenece'))->with('success', 'খরচ আপডেট সম্পন্ন হয়েছে');
    }

    /**
     * Officer expence Page
     */
    public function officerExpence(Request $request)
    {
        $query = officer_expence::query();
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

            $query->whereBetween('date', [$form_date, $end_date]);
        } else {

            $form_date = Carbon::now()->startOfMonth();
            $end_date = Carbon::now()->endOfDay();

            $query->whereBetween('date', [$form_date, $end_date]);
        }
        /**
         * Author Data Filter Query
         */
        if (isset($request->officer_id)) {
            $query->where('user_id', $request->officer_id);
        }
        $expences = $query->orderby('id', 'DESC')
            ->with('User')
            ->get();

        /**
         * Officer Data
         */
        $officers = User::where('status', true)
            ->whereNotIn('email', ['admin@gmail.com'])
            ->get(['id', 'name']);

        return view('backend.expence.officersExpence', compact('expences', 'officers'));
    }

    /**
     * Officer Expence Store
     */
    public function officerExpenceStore(Request $request)
    {
        /**
         * validate Data
         */
        $this->compactValidation2nd($request);

        /**
         * Store expence
         */
        $expence = new officer_expence();
        $this->compactData2nd($expence, $request);
        $expence->save();

        return back()->with('success', 'অফিসার দৈনিক ব্যয় সম্পন্ন হয়েছে');
    }

    /**
     * Delete Officer Expence
     */
    public function officerExpenceDelete($id)
    {
        $expence = officer_expence::find($id);
        $expence->delete();
        return back()->with('success', 'অফিসার দৈনিক ব্যয় ডিলিট সম্পন্ন হয়েছে');
    }

    /**
     * Edit Officer Expence
     */
    public function officerExpenceEdit($id)
    {
        $expence = officer_expence::find($id);
        /**
         * Officer Data
         */
        $officers = User::where('status', true)
            ->whereNotIn('email', ['admin@gmail.com'])
            ->get(['id', 'name']);
        return view('backend.expence.officerExpenceEdit', compact('expence', 'officers'));
    }

    /**
     * Officer Expence Update
     */
    public function officerExpenceUpdate(Request $request, $id)
    {
        /**
         * validate Data
         */
        $this->compactValidation2nd($request);

        $expence = officer_expence::find($id);
        $this->compactData2nd($expence, $request);
        $expence->save();

        return redirect(Route('expenece.officer'))->with('success', 'অফিসার দৈনিক ব্যয় আপডেট সম্পন্ন হয়েছে');
    }
}
