@extends('layouts.main')

@section('main-content')
    <div class="container-fluid mb-5">
        <h3 class="mt-4 text-bold">অফিসার ইডিট</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">অফিসার ইডিট</li>
        </ol>

        <div class="d-flex align-items-center justify-content-center">
            <div class="card" style="max-width: 800px;">
                <div class="card-header text-center">
                    <strong>অফিসার ইডিট</strong>
                </div>
                <form action="{{ Route('employee.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputname">নাম পরিবর্তন <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control py-4 @error('name') is-invalid @enderror" id="inputname"
                                        type="text" placeholder="নাম লিখুন" name="name" value="{{ $user->name }}"
                                        required autocomplete="name" autofocus />
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="small mb-1" for="role">পদবি পরিবর্তন <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control select" style="height: 50px;" name="role" id="role">
                                        <option value="" disabled selected>পদবি নির্বাচন করুন</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ $user->roles['0']->id == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group position-relative">
                                    <label class="small mb-1" for="password">পাসওয়ার্ড পরিবর্তন <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control py-4 @error('password') is-invalid @enderror" id="password"
                                        type="password" placeholder="পাসওয়ার্ড দিন" name="password" />
                                    <span id="lock" class="lockIcon"><i class='bx bxs-lock'></i></span>
                                    @error('password')
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
             * Password Vissible or not
             */
            $(".lockIcon").on('click', function() {
                if ($(this).siblings('input').attr('type') === 'password') {

                    $(this).html("");
                    $(this).html("<i class='bx bxs-lock-open' ></i>");
                    $(this).siblings('input').attr('type', 'text');

                } else if ($(this).siblings('input').attr('type', 'text')) {

                    $(this).html("  ");
                    $(this).html("<i class='bx bxs-lock' ></i>");
                    $(this).siblings('input').attr('type', 'password');
                }
            })
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
