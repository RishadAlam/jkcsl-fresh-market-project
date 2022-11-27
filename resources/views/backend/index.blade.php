@extends('layouts.main')

@section('main-content')
    <div class="container-fluid">
        <h1 class="mt-4">ড্যাশবোর্ড</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">ড্যাশবোর্ড</li>
        </ol>
        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body d-flex justify-content-between">
                        <h3>স্টক</h3>
                        <h3>{{ $totals['stocks'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body d-flex justify-content-between">
                        <h3>সার্ভিস বিক্রয়</h3>
                        <h3>{{ $totals['serviceSale'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body d-flex justify-content-between">
                        <h3>কার্ড বিক্রয়</h3>
                        <h3>{{ $totals['cardSale'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <!--Card Sale Table-->
                <div class="card mb-4">
                    <div class="card-header">
                        <span><i class='bx bx-category'></i></span>
                        দৈনিক কার্ড বিক্রয় প্রতিবেদন
                    </div>
                    <div class="card-body overflow-auto overflow-lg-unset">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <th>#</th>
                                <th>অফিসার</th>
                                <th>মূল্য দর</th>
                                <th>বিক্রয় সংখ্যা</th>
                                <th>সর্বমোট মূল্য </th>
                                <th style="width: 300px;">বিস্তারিত</th>
                            </thead>
                            <tbody>
                                @forelse ($solds as $key => $sold)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $sold->User->name }}</td>
                                        <td>{{ $sold->net_price }}</td>
                                        <td>{{ $sold->quantity }}</td>
                                        <td>{{ $sold->total_price }}</td>
                                        <td>{!! $sold->details !!}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">কোনো বিক্রয় পাওয়া যাইনি</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="row">
                            {{ $solds->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <span><i class='bx bx-category'></i></span>
                        দৈনিক সর্বোচ্ছো কার্ড বিক্রেতা
                    </div>
                    <div class="card-body overflow-auto overflow-lg-unset">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <th>#</th>
                                <th>অফিসার</th>
                                <th>বিক্রয় সংখ্যা</th>
                            </thead>
                            <tbody>
                                @forelse ($totalCards as $key => $cards)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $cards->User->name }}</td>
                                        <td>{{ $cards->quantity }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">কোনো বিক্রেতা পাওয়া যাইনি</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <!--Card Sale Table-->
                <div class="card mb-4">
                    <div class="card-header">
                        <span><i class='bx bx-category'></i></span>
                        দৈনিক সার্ভিস বিক্রয় প্রতিবেদন
                    </div>
                    <div class="card-body overflow-auto overflow-lg-unset">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <th>#</th>
                                <th>অফিসার</th>
                                <th>সার্ভিস</th>
                                <th>ক্যাটাগরি</th>
                                <th>মূল্য দর</th>
                                <th>বিক্রয় সংখ্যা</th>
                                <th>সর্বমোট মূল্য </th>
                                <th style="width: 300px;">বিস্তারিত</th>
                            </thead>
                            <tbody>
                                @forelse ($services as $key => $service)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $service->User->name }}</td>
                                        <td>{{ $service->stock->name }}</td>
                                        <td>{{ $service->category->category_name }}</td>
                                        <td>{{ $service->net_price }}</td>
                                        <td>{{ $service->quantity }}</td>
                                        <td>{{ $service->total_price }}</td>
                                        <td>{!! $service->details !!}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">কোনো বিক্রয় পাওয়া যাইনি</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="row">
                            {{ $services->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <span><i class='bx bx-category'></i></span>
                        দৈনিক সর্বোচ্ছো সার্ভিস বিক্রেতা
                    </div>
                    <div class="card-body overflow-auto overflow-lg-unset">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <th>#</th>
                                <th>অফিসার</th>
                                <th>বিক্রয় সংখ্যা</th>
                            </thead>
                            <tbody>
                                @forelse ($totalservices as $key => $service)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $service->User->name }}</td>
                                        <td>{{ $service->quantity }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">কোনো বিক্রেতা পাওয়া যাইনি</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
