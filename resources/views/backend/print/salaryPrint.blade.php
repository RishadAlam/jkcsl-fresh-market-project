@extends('layouts.print')

@section('printContent')
    <!-- Report Heading -->
    <section id="reportHeading">
        <div class="container-fluid mb-5">
            <div class="row">
                <div class="col-4"></div>
                <div class="col-4 text-center">
                    <span><b style="font-size: 36px;">সেলারি রিসিপ্ট</b></span>
                    <hr class="m-0">
                </div>
                <div class="col-4 text-end"></div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6 border p-3">
                    <h4 class="d-flex mb-3">
                        <b>অফিসারঃ</b>
                        <div class="border-bottom border-secondary ps-5" style="width: 100%;">
                            {{ $salary->User->name }}
                        </div>
                    </h4>
                    <h4 class="d-flex mb-3">
                        <b>পদবীঃ</b>
                        <div class="border-bottom border-secondary ps-5" style="width: 100%;">
                            {{ $salary->User->roles[0]->name }}
                        </div>
                    </h4>
                    <h4 class="d-flex mb-3">
                        <b>মাসঃ</b>
                        <div class="border-bottom border-secondary ps-4" style="width: 50%;">
                            {{ date('F', strtotime($salary->month)) }}
                        </div>
                        <b>সালঃ</b>
                        <div class="border-bottom border-secondary ps-5" style="width: 50%;">
                            {{ date('Y', strtotime($salary->month)) }}
                        </div>
                    </h4>
                </div>
                <div class="col-3 text-end"></div>
            </div>
        </div>
    </section>
    <section class="mt-5 mb-5">
        <div class="p-3" style="font-size: 22px">
            <table class="table table-bordered">
                <thead>
                    <th style="width: 10px">#</th>
                    <th style="width: 50%">বিবরণ</th>
                    <th style="width: 50%">টাকা</th>
                </thead>
                <tbody>
                    <tr>
                        <td>১</td>
                        <td>সর্বমোট বিক্রয়</td>
                        <td>{{ $salary->total_sale }}টি</td>
                    </tr>
                    <tr>
                        <td>২</td>
                        <td>কমিশন</td>
                        <td>৳{{ $salary->salery_percentage }}/-</td>
                    </tr>
                    <tr>
                        <td>৩</td>
                        <td>দৈনিক খরচ</td>
                        <td>৳{{ $salary->expence }}/-</td>
                    </tr>
                    <tr>
                        <td>৪</td>
                        <td>উপস্থিতি বোনাস</td>
                        <td>৳{{ $salary->present_bonus }}/-</td>
                    </tr>
                    <tr>
                        <td>৫</td>
                        <td>চা-নাস্তার বিল</td>
                        <td>৳{{ $salary->extra_1 }}/-</td>
                    </tr>
                    <tr>
                        <td>৬</td>
                        <td>গাড়ি ভাড়া বিল</td>
                        <td>৳{{ $salary->extra_2 }}/-</td>
                    </tr>
                    <tr>
                        <td>৭</td>
                        <td>মোবাইল বিল</td>
                        <td>৳{{ $salary->extra_3 }}/-</td>
                    </tr>
                    <tr>
                        <td>৮</td>
                        <td>বেসিক বেতন</td>
                        <td>৳{{ $salary->basic_salary }}/-</td>
                    </tr>
                <tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-end border-top"><b>সর্বমোট</b></td>
                        <td><b>{{ $salary->total_salary }} টাকা</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <section class="mt-5">
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-6 px-5 mt-5">
                    <div class="border-bottom text-center py-3"><span style="font-size: 24px;">অফিসার
                            স্বাক্ষর</span></div>
                </div>
                <div class="col-6 px-5 mt-5">
                    <div class="border-bottom text-center py-3"><span style="font-size: 24px;">ম্যান্যাজিং ডিরেক্টর
                            স্বাক্ষর</span></div>
                </div>
            </div>
        </div>
    </section>
@endsection
