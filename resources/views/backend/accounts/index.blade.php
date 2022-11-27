@extends('layouts.main')

@section('main-content')
    <div class="container-fluid mb-5">
        <h3 class="mt-4 text-bold">হিসাব</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">হিসাব</li>
        </ol>
    </div>

    <div class="container-fluid">
        <!--Accounts Table-->
        <div class="card mb-4">
            <div class="card-header">
                <span><i class='bx bx-category'></i></span>
                হিসাব প্রতিবেদন
                @php
                    if (isset($_GET['month'])) {
                        $month = $_GET['month'];
                    } else {
                        $month = date('Y-m', strtotime(carbon\carbon::now()));
                    }
                @endphp
                <a href="{{ Route('acc.calculations.print', $month) }}" class="btn btn-sm btn-secondary" target="_blank"><i
                        class='bx bx-printer'></i> Print</a>
                <div class="dateRange text-end">
                    <form action="{{ Route('accounts.calculations') }}" method="GET">
                        <div class="form-group m-0">
                            <span>তারিখঃ</span>
                            <input type="month" id="month" name="month"
                                value="{{ isset($_GET['month']) ? date('Y-m', strtotime($_GET['month'])) : date('Y-m', strtotime(now())) }}" />
                            <button class="btn btn-sm btn-success">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body overflow-auto overflow-lg-unset">
                <div class="row">
                    <div class="col-md-6 mb-3 border p-0">
                        <div class="card-header">
                            <span><i class='bx bx-category'></i></span>
                            ব্যয় প্রতিবেদন
                        </div>
                        <div class="card-body overflow-auto overflow-lg-unset">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <th>#</th>
                                    <th>বিবরণ</th>
                                    <th>খরচ</th>
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
                    <div class="col-md-6 mb-3 border p-0">
                        <div class="card-header">
                            <span><i class='bx bx-category'></i></span>
                            আয় প্রতিবেদন
                        </div>
                        <div class="card-body overflow-auto overflow-lg-unset">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <th>#</th>
                                    <th>বিবরণ</th>
                                    <th>আয়</th>
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
                    <div class="col-md-12 border p-0~">
                        <div class="border mx-auto p-0">
                            <div class="card-header">
                                <span><i class='bx bx-category'></i></span>
                                সর্বশেষ হিসাব
                            </div>
                            <div class="card-body overflow-auto overflow-lg-unset">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <th>#</th>
                                        <th>বিবরণ</th>
                                        <th>আয়</th>
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
                                        <tr class="{{ $totalincome - $totalExpence > 0 ? 'bg-success' : 'bg-danger' }} text-light"
                                            style="font-size: 24px;">
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
        </div>
    </div>
@endsection
