@extends('layouts.main')

@section('main-content')
    <div class="container-fluid mb-5">
        <h3 class="mt-4 text-bold">অফিসার দৈনিক ব্যয়</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">অফিসার দৈনিক ব্যয়</li>
        </ol>

        <div class="d-flex align-items-center justify-content-center">
            <div class="card" style="max-width: 800px;">
                <div class="card-header text-center">
                    <strong>অফিসার দৈনিক ব্যয়</strong>
                </div>
                <form action="{{ Route('expenece.officer.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="date">তারিখ <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control py-4 @error('date') is-invalid @enderror" id="date"
                                        value="{{ old('date') }}" placeholder="তারিখ" name="date" required />
                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="expence">খরচ <span class="text-danger">*</span></label>
                                    <input class="form-control py-4 @error('expence') is-invalid @enderror" id="expence"
                                        type="number" value="{{ old('expence') }}" placeholder="খরচ" name="expence"
                                        required autocomplete="expence" autofocus />
                                    @error('expence')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="small mb-1" for="officer_id">অফিসার <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('officer_id') is-invalid @enderror"
                                        style="height: 50px;" name="officer_id" id="officer_id">
                                        @if (auth()->user()->can('অফিসার দৈনিক ব্যয় অফিসার নির্বাচন'))
                                            <option disabled selected>অফিসার নির্বাচন করুন</option>
                                            @foreach ($officers as $officer)
                                                <option value="{{ $officer->id }}">{{ $officer->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="{{ auth()->user()->id }}" selected>{{ auth()->user()->name }}
                                            </option>
                                        @endif
                                    </select>
                                    @error('officer_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <button type="submit" class="form-control btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!--Stock Table-->
        <div class="card mb-4">
            <div class="card-header">
                <span><i class='bx bx-category'></i></span>
                খরচের প্রতিবেদন
                <div class="dateRange text-end">
                    <form action="{{ Route('expenece.officer') }}" method="GET">
                        <div class="form-group m-0">
                            @if (auth()->user()->can('অফিসার দৈনিক ব্যয় অফিসার নির্বাচন'))
                                <label class="small mb-1" for="officer_id">অফিসার</label>
                                <select name="officer_id" id="officer_id">
                                    <option value="" {{ request()->has('daterange') ? '' : 'selected' }}>সকল অফিসার
                                    </option>
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
                        <th>অফিসার</th>
                        <th>খরচ</th>
                        @if (auth()->user()->can('ব্যয় ইডিট') ||
                            auth()->user()->can('ব্যয় ডিলিট'))
                            <th>একশন</th>
                        @endif
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @forelse ($expences as $key => $expence)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $expence->date }}</td>
                                <td>{{ $expence->user->name }}</td>
                                <td>৳{{ $expence->expence }}/-</td>
                                @if (auth()->user()->can('ব্যয় ইডিট') ||
                                    auth()->user()->can('ব্যয় ডিলিট'))
                                    <td>
                                        <div class="btn-group">
                                            @if (auth()->user()->can('ব্যয় ইডিট'))
                                                <a href="{{ Route('expenece.officer.edit', $expence->id) }}"
                                                    class="edit btn btn-sm btn-warning text-yellow-500">
                                                    <span style="display: grid; font-size: 24px;">
                                                        <i class='bx bx-edit'></i>
                                                    </span>
                                                </a>
                                            @endif
                                            @if (auth()->user()->can('ব্যয় ডিলিট'))
                                                <button type="submit" class="btn btn-sm btn-danger text-yellow-500"
                                                    data-toggle="modal"
                                                    data-target="#deleteModal_{{ $expence->id }}"><span
                                                        style="display: grid; font-size: 24px;"><i
                                                            class='bx bx-trash'></i></span></button>
                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal_{{ $expence->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                        <div class="modal-content" style="min-width: 600px;">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">ক্যাটাগরি ডিলিট</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form id="deleteForm"
                                                                action="{{ Route('expenece.officer.delete', $expence->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="modal-body">
                                                                    <h3 class="text-center text-danger">আপনি কি নিশ্চিত
                                                                        ডিলিট
                                                                        করতে
                                                                        চাইছেন?</h3>
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
                                $total += $expence->expence;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">কোনো বিক্রয় পাওয়া যাইনি</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><b>সর্বমোটঃ</b></td>
                            <td colspan="2"><b>৳{{ $total }}/-</b></td>
                        </tr>
                    </tfoot>
                </table>
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
        })
    </script>
@endsection
