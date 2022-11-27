@extends('layouts.entry')

@section('main-body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">প্রবেশ করুন</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.login') }}">
                            @csrf
                            @if (session()->has('loginErrorStatus'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('loginErrorStatus') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="small mb-1" for="inputEmailAddress">ইমেইল</label>
                                <input
                                    class="form-control py-4 @error('email') is-invalid @enderror @if (session()->has('loginErrorEmail')) is-invalid @endif"
                                    id="inputEmailAddress" type="email" placeholder="ইমেইল অ্যাড্রেস দিন" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus />
                                @if (session()->has('loginErrorEmail'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ session('loginErrorEmail') }}</strong>
                                    </span>
                                @endif
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="inputPassword">পাসওয়ার্ড</label>
                                <input
                                    class="form-control py-4 @error('password') is-invalid @enderror @if (session()->has('loginErrorPassword')) is-invalid @endif"
                                    id="inputPassword" type="password" placeholder="পাসওয়ার্ড দিন" name="password" required
                                    autocomplete="current-password" />

                                @if (session()->has('loginErrorPassword'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ session('loginErrorPassword') }}</strong>
                                    </span>
                                @endif
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox"
                                        name="remember" {{ old('remember') ? 'checked' : '' }} />
                                    <label class="custom-control-label" for="rememberPasswordCheck">পাসওয়ার্ড মনে
                                        রাখুন</label>
                                </div>
                            </div> --}}
                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                @if (Route::has('password.request'))
                                    <a class="small" href="{{ route('password.request') }}">পাসওয়ার্ড ভুলে গেছেন?</a>
                                @endif
                                <button type="submit" class="btn btn-primary">প্রবেশ করুন</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
