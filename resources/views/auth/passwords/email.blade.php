@extends('layouts.entry')

@section('main-body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4">পাসওয়ার্ড পুনরুদ্ধার</h3></div>
                    <div class="card-body">
                        <div class="small mb-3 text-muted">আপনার ইমেল ঠিকানা লিখুন এবং আমরা আপনার পাসওয়ার্ড পুনরায় সেট করার জন্য আপনাকে একটি লিঙ্ক পাঠাব।</div>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group">
                                <label class="small mb-1" for="inputEmailAddress">ইমেল</label>
                                <input class="form-control py-4 @error('email') is-invalid @enderror" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="ইমেইল অ্যাড্রেস দিন" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                <a class="small" href="{{ url('/login') }}">লগইন এ ফিরে যান</a>
                                <button class="btn btn-primary">পাসওয়ার্ড রিসেট করুন</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection