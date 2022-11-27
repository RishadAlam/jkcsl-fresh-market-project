@extends('layouts.print')

@section('printContent')
    <!-- Report Heading -->
    <section id="reportHeading" class="mb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4" style="font-size: 22px">
                    <span>মাসঃ <b>{{ $monthYear }}</b></span>
                </div>
                <div class="col-4 text-center" style="font-size: 22px">
                    <span><b>হিসাব প্রতিবেদন</b></span>
                </div>
                <div class="col-4 text-end">
                    <span>প্রিন্ট তারিখঃ <span>{{ carbon\carbon::now()->format('d-m-Y') }}</span></span>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb-3 border p-0">
                    <div class="card-header" style="font-size: 22px">
                        <span><i class='bx bx-category'></i></span>
                        ব্যয় প্রতিবেদন
                    </div>
                    <div class="card-body overflow-auto overflow-lg-unset" style="font-size: 22px">
                        <table class="table table-bordered">
                            <thead>
                                <th style="width: 10px;">#</th>
                                <th style="width: 50%;">বিবরণ</th>
                                <th style="width: 50%;">খরচ</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>সাধারণ ব্যয়</td>
                                    <td>৳{{ $allExpences['expences'] }}/-</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>অফিসার কর্তৃক ব্যয়</td>
                                    <td>৳{{ $allExpences['officerExpences'] }}/-</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>অফিসার বেতন</td>
                                    <td>৳{{ $allExpences['salaries'] }}/-</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-end" style="border-top: 1px solid"><b>সর্বমোট
                                            ব্যয়ঃ</b></td>
                                    <td style="border-top: 1px solid"><b>৳{{ $totalExpence }}/-</b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 mb-3 border p-0">
                    <div class="card-header" style="font-size: 22px">
                        <span><i class='bx bx-category'></i></span>
                        আয় প্রতিবেদন
                    </div>
                    <div class="card-body overflow-auto overflow-lg-unset" style="font-size: 22px">
                        <table class="table table-bordered">
                            <thead>
                                <th style="width: 10px;">#</th>
                                <th style="width: 50%;">বিবরণ</th>
                                <th style="width: 50%;">আয়</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>কার্ড বিক্রয় আয়</td>
                                    <td>৳{{ $allincomes['cards'] }}/-</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>সার্ভিস বিক্রয় আয়</td>
                                    <td>৳{{ $allincomes['services'] }}/-</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-end" style="border-top: 1px solid"><b>সর্বমোট
                                            আয়ঃ</b></td>
                                    <td style="border-top: 1px solid"><b>৳{{ $totalincome }}/-</b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 border p-0">
                    <div class="border mx-auto p-0">
                        <div class="card-header" style="font-size: 22px">
                            <span><i class='bx bx-category'></i></span>
                            সর্বশেষ হিসাব
                        </div>
                        <div class="card-body overflow-auto overflow-lg-unset" style="font-size: 22px">
                            <table class="table table-bordered">
                                <thead>
                                    <th style="width: 10px;">#</th>
                                    <th style="width: 50%;">বিবরণ</th>
                                    <th style="width: 50%;">আয়</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2</td>
                                        <td>সর্বমোট আয়</td>
                                        <td>৳{{ $totalincome }}/-</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>সর্বমোট খরচ</td>
                                        <td>৳{{ $totalExpence }}/-</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr style="font-size: 24px;">
                                        <td colspan="2" class="text-end" style="border-top: 1px solid"><b>সর্বশেষ
                                                হিসাবঃ</b></td>
                                        <td style="border-top: 1px solid"><b>{{ $totalincome - $totalExpence }}/-</b>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
