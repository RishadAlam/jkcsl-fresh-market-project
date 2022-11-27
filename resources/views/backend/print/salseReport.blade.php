@extends('layouts.print')

@section('printContent')
    <!-- Report Heading -->
    <section id="reportHeading" class="mb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <span>অফিসারঃ <b>{{ $user->name }}</b></span>
                </div>
                <div class="col-4 text-center">
                    <span><b>কার্ড বিক্রয় কমিশন প্রতিবেদন</b></span>
                </div>
                <div class="col-4 text-end">
                    <span>প্রিন্ট তারিখঃ <span>{{ carbon\carbon::now()->format('d-m-Y') }}</span></span>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <th style="width: 10px;">#</th>
                    <th>তারিখ</th>
                    <th>অফিসার</th>
                    <th>মূল্য দর</th>
                    <th style="width: 120px;">বিক্রয় সংখ্যা</th>
                    <th>সর্বমোট মূল্য </th>
                    <th>কমিশন ({{ $card_percentage[0]->card_percentage }}%)</th>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                        $totalQuantity = 0;
                        $totalCommision = 0;
                    @endphp
                    @forelse ($solds as $key => $sold)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $sold->created_at }}</td>
                            <td>{{ $sold->User->name }}</td>
                            <td>৳{{ $sold->net_price }}/-</td>
                            <td>{{ $sold->quantity }}</td>
                            <td>৳{{ $sold->total_price }}/-</td>
                            <td>৳{{ ($card_percentage[0]->card_percentage / 100) * $sold->total_price }}/-</td>
                        </tr>
                        @php
                            $total += $sold->total_price;
                            $totalQuantity += $sold->quantity;
                            $totalCommision += ($card_percentage[0]->card_percentage / 100) * $sold->total_price;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">কোনো বিক্রয় পাওয়া যাইনি</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end"><b>সর্বমোটঃ</b></td>
                        <td><b>৳{{ $totalQuantity }}/-</b></td>
                        <td><b>৳{{ $total }}/-</b></td>
                        <td colspan="2"><b>৳{{ $totalCommision }}/-</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
@endsection
