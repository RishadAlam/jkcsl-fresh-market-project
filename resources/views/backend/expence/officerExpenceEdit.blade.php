@extends('layouts.main')

@section('main-content')
    <div class="container-fluid mb-5">
        <h3 class="mt-4 text-bold">ব্যয় ইডিট</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">ব্যয় ইডিট</li>
        </ol>

        <div class="d-flex align-items-center justify-content-center">
            <div class="card" style="max-width: 800px;">
                <div class="card-header text-center">
                    <strong>ব্যয় ইডিট</strong>
                </div>
                <form action="{{ Route('expenece.officer.update', $expence->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="date">তারিখ <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control py-4 @error('date') is-invalid @enderror" id="date"
                                        type="text" value="{{ date('m/d/Y', strtotime($expence->date)) }}" name="date"
                                        required />
                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="expence">খরচ <span class="text-danger">*</span></label>
                                    <input class="form-control py-4 @error('expence') is-invalid @enderror" id="expence"
                                        type="number" value="{{ $expence->expence }}" placeholder="খরচ" name="expence"
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
                                        <option disabled selected>অফিসার নির্বাচন করুন</option>
                                        @foreach ($officers as $officer)
                                            <option value="{{ $officer->id }}"
                                                {{ $expence->user_id == $officer->id ? 'selected' : '' }}>
                                                {{ $officer->name }}</option>
                                        @endforeach
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
