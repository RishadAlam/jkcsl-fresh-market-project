@extends('layouts.main')

@section('main-content')
    <div class="container-fluid">
        <h3 class="mt-4 text-bold">কার্ড বিক্রয় কমিশন প্রতিবেদন</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">কার্ড বিক্রয় কমিশন প্রতিবেদন</li>
        </ol>

        <div class="container-fluid">
            <!--Stock Table-->
            <div class="card mb-4">
                <div class="card-header">
                    <span><i class='bx bx-category'></i></span>
                    কার্ড বিক্রয় কমিশন প্রতিবেদন
                    <a href="#" class="btn btn-sm btn-secondary" id="printBtn" target="_blank"
                        style="display: none;"><i class='bx bx-printer'></i>
                        Print</a>
                    <div class="dateRange text-end">
                        <form action="{{ Route('salary.salesReport') }}" method="GET">
                            <div class="form-group m-0">
                                <label class="small mb-1" for="officer_id">অফিসার</label>
                                <select name="officer_id" id="officer_id">
                                    <option selected disabled>অফিসার নির্বাচন করুন</option>
                                    @forelse ($officers as $officer)
                                        <option value="{{ $officer->id }}"
                                            {{ request()->get('officer_id') == $officer->id ? 'selected' : '' }}>
                                            {{ $officer->name }}</option>
                                    @empty
                                        <option disabled>কোনো অফিসার পাওয়া যাইনি</option>
                                    @endforelse
                                </select>
                                <span>তারিখঃ</span>
                                <input type="month" id="month" name="month"
                                    value="{{ isset($_GET['month']) ? date('Y-m', strtotime($_GET['month'])) : date('Y-m', strtotime(now())) }}" />
                                <button type="submit" class="btn btn-sm btn-success">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body overflow-auto overflow-lg-unset">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <th>#</th>
                            <th>তারিখ</th>
                            <th>অফিসার</th>
                            <th>মূল্য দর</th>
                            <th>বিক্রয় সংখ্যা</th>
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
            </div>
        </div>
    </div>
@endsection

@section('customJS')
    <script>
        $(document).ready(function() {
            /**
             * Success Message Toster
             */
            @if (session()->has('success'))
                $.toast({
                    heading: 'Success',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    position: 'mid-center',
                })
            @endif

            function print() {
                @if (isset(request()->officer_id))
                    var officer_id = $('#officer_id').val()
                    var daterange = $('#month').val()
                    var btn = $('#printBtn')
                    var url =
                        "{{ Route('sales.report.print', ['daterange' => ':daterange', 'officer_id' => ':officer_id']) }}"
                    url = url.replace(':daterange', daterange)
                    url = url.replace(':officer_id', officer_id)
                    console.log(url)
                    console.log(daterange)
                    btn.css('display', 'inline-block')
                    btn.attr('href', url)
                @endif
            }
            print()
        })
    </script>
@endsection
