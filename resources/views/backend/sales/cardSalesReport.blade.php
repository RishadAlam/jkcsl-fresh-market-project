@extends('layouts.main')

@section('main-content')
    <div class="container-fluid">
        <h3 class="mt-4 text-bold">কার্ড বিক্রয় প্রতিবেদন</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">কার্ড বিক্রয় প্রতিবেদন</li>
        </ol>

        <div class="container-fluid">
            <!--Stock Table-->
            <div class="card mb-4">
                <div class="card-header">
                    <span><i class='bx bx-category'></i></span>
                    কার্ড বিক্রয় প্রতিবেদন
                    <div class="dateRange text-end">
                        <form action="{{ Route('sales.report') }}" method="GET">
                            <div class="form-group m-0">
                                @if (auth()->user()->can('কার্ড অফিসার নির্বাচন'))
                                    <label class="small mb-1" for="officer_id">অফিসার</label>
                                    <select name="officer_id" id="officer_id">
                                        <option value="" {{ request()->has('daterange') ? '' : 'selected' }}>সকল
                                            অফিসার</option>
                                        @forelse ($officers as $officer)
                                            <option value="{{ $officer->id }}"
                                                {{ request()->get('officer_id') == $officer->id ? 'selected' : '' }}>
                                                {{ $officer->name }}</option>
                                        @empty
                                            <option disabled>কোনো অফিসার পাওয়া যাইনি</option>
                                        @endforelse
                                    </select>
                                @endif
                                <span>তারিখঃ</span>
                                <input type="text" id="daterange"
                                    value="{{ request()->has('daterange')? request()->get('daterange'): Carbon\Carbon::now()->startOfMonth()->format('m/d/Y') .'-' .Carbon\Carbon::now()->format('m/d/Y') }}"
                                    name="daterange" placeholder="" />
                                <button class="btn btn-sm btn-success">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body overflow-auto overflow-lg-unset">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <th>#</th>
                            <th>তারিখ</th>
                            @if (auth()->user()->can('কার্ড অফিসার নির্বাচন'))
                                <th>অফিসার</th>
                            @endif
                            <th>মূল্য দর</th>
                            <th>বিক্রয় সংখ্যা</th>
                            <th>সর্বমোট মূল্য </th>
                            <th style="width: 300px;">বিস্তারিত</th>
                            @if (auth()->user()->can('কার্ড বিক্রয় প্রতিবেদন ইডিট') ||
                                auth()->user()->can('কার্ড বিক্রয় প্রতিবেদন ডিলিট'))
                                <th class="text-center">একশন</th>
                            @endif
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                                $totalQuantity = 0;
                            @endphp
                            @forelse ($solds as $key => $sold)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $sold->created_at }}</td>
                                    @if (auth()->user()->can('কার্ড অফিসার নির্বাচন'))
                                        <td>{{ $sold->User->name }}</td>
                                    @endif
                                    <td>{{ $sold->net_price }}</td>
                                    <td>{{ $sold->quantity }}</td>
                                    <td>{{ $sold->total_price }}</td>
                                    <td>{!! $sold->details !!}</td>
                                    @if (auth()->user()->can('কার্ড বিক্রয় প্রতিবেদন ইডিট') ||
                                        auth()->user()->can('কার্ড বিক্রয় প্রতিবেদন ডিলিট'))
                                        <td class="text-center">
                                            <div class="btn-group">
                                                @if (auth()->user()->can('কার্ড বিক্রয় প্রতিবেদন ইডিট'))
                                                    <a href="{{ Route('sales.card.edit', $sold->id) }}"
                                                        class="edit btn btn-sm btn-warning text-yellow-500">
                                                        <span style="display: grid; font-size: 24px;">
                                                            <i class='bx bx-edit'></i>
                                                        </span>
                                                    </a>
                                                @endif
                                                @if (auth()->user()->can('কার্ড বিক্রয় প্রতিবেদন ডিলিট'))
                                                    <button type="submit" class="btn btn-sm btn-danger text-yellow-500"
                                                        data-toggle="modal"
                                                        data-target="#deleteModal_{{ $sold->id }}"><span
                                                            style="display: grid; font-size: 24px;"><i
                                                                class='bx bx-trash'></i></span></button>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteModal_{{ $sold->id }}"
                                                        tabindex="-1" aria-labelledby="deleteModalLabel"
                                                        aria-hidden="true">
                                                        <div
                                                            class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                            <div class="modal-content" style="min-width: 600px;">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">কার্ড ডিলিট</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form id="deleteForm"
                                                                    action="{{ Route('sales.card.delete', $sold->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <div class="modal-body">
                                                                        <h3 class="text-center text-danger">আপনি কি নিশ্চিত
                                                                            ডিলিট
                                                                            করতে চাইছেন?</h3>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Delete</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                                @php
                                    $total += $sold->total_price;
                                    $totalQuantity += $sold->quantity;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">কোনো বিক্রয় পাওয়া যাইনি</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                @if (auth()->user()->can('কার্ড অফিসার নির্বাচন'))
                                    <td></td>
                                @endif
                                <td colspan="3" class="text-end"><b>সর্বমোটঃ</b></td>
                                <td><b>৳{{ $totalQuantity }}/-</b></td>
                                <td colspan="3"><b>৳{{ $total }}/-</b></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="row">
                        {{ $solds->links() }}
                    </div>
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
    </script>
@endsection
