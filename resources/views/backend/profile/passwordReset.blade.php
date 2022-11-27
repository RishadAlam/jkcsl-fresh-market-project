@extends('layouts.main')

@section('main-content')
<div class="container-fluid">
    <h3 class="mt-4 text-bold">পাসওয়ার্ড পরিবর্তন</h3>
    <ol class="breadcrumb mb-4 py-1 ps-2">
        <li class="breadcrumb-item"><a href="{{Route('dashboard')}}">ড্যাশবোর্ড</a></li>
        <li class="breadcrumb-item active">পাসওয়ার্ড পরিবর্তন</li>
    </ol>

    <div class="d-flex align-items-center justify-content-center">
        <div class="card" style="width: 500px;">
            <div class="card-header text-center">
                পাসওয়ার্ড পরিবর্তন
            </div>
            <form action="{{Route('user.password.chenge')}}" method="post">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group position-relative">
                                <label class="small mb-1" for="current_password">পূর্বের পাসওয়ার্ড <span class="text-danger">*</span></label>
                                <input class="form-control py-4 @if (session()->has('current_password'))
                                    is-invalid 
                                @endif @error('current_password') is-invalid @enderror" id="current_password" type="password" name="current_password" required  />
                                <span id="lock" class="lockIcon"><i class='bx bxs-lock' ></i></span>
                                <span class="text-danger">{{session('current_password')}}</span>
                                @error('current_password')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group position-relative">
                                <label class="small mb-1" for="new_password">নতুন পাসওয়ার্ড <span class="text-danger">*</span></label>
                                <input class="form-control py-4 @error('new_password') is-invalid @enderror" id="new_password" type="password" name="new_password" required  />
                                <span id="lock" class="lockIcon"><i class='bx bxs-lock' ></i></span>
                                @error('new_password')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group position-relative">
                                <label class="small mb-1" for="confirmed_password">নিশ্চিত পাসওয়ার্ড <span class="text-danger">*</span></label>
                                <input class="form-control py-4 @error('confirmed_password') is-invalid @enderror" id="confirmed_password" type="password" name="confirmed_password" required  />
                                <span id="lock" class="lockIcon"><i class='bx bxs-lock' ></i></span>
                                @error('confirmed_password')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted text-center">
                    <button type="submit" class="form-control btn btn-primary">Change</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('customJS')
    <script>
        $(document).ready(function() {
            $(".lockIcon").on('click', function(){
                if($(this).siblings('input').attr('type') === 'password'){
                    
                    $(this).html("");
                    $(this).html("<i class='bx bxs-lock-open' ></i>");
                    $(this).siblings('input').attr('type', 'text');

                }else if($(this).siblings('input').attr('type', 'text')){
                    
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
                    text: '{{session("success")}}',
                    icon: 'success',
                    position: 'mid-center',
                })
            @endif
        });
  </script>
@endsection