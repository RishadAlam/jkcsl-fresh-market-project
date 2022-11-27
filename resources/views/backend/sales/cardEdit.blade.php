@extends('layouts.main')

@section('main-content')
    <div class="container-fluid mb-5">
        <h3 class="mt-4 text-bold">কার্ড বিক্রয়</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{Route('dashboard')}}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">কার্ড বিক্রয়</li>
        </ol>

        <div class="d-flex align-items-center justify-content-center">
            <div class="card" style="max-width: 800px;">
                <div class="card-header text-center">
                    <strong>কার্ড বিক্রয়</strong>
                </div>
                <form action="{{Route('sales.card.update', $solds->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group position-relative">
                                    <label class="small mb-1" for="officer_id">অফিসার নির্বাচন করুন <span class="text-danger">*</span></label>
                                    <select class="form-control @error('officer_id') is-invalid @enderror" style="height: 50px;" name="officer_id" id="officer_id">
                                        <option disabled selected>অফিসার নির্বাচন করুন</option>
                                        @forelse ($officers as $officer)
                                            <option value="{{$officer->id}}" {{$solds->user_id == $officer->id ? 'selected' : ''}}>{{$officer->name}}</option>
                                        @empty
                                            <option disabled>কোনো অফিসার পাওয়া যাইনি</option>
                                        @endforelse
                                    </select>
                                    @error('officer_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="price">মূল্য দর <span class="text-danger">*</span></label>
                                    <input class="form-control py-4 @error('price') is-invalid @enderror" id="price" type="number" value="{{ $solds->net_price }}" placeholder="মূল্য" name="price" required autocomplete="price" readonly autofocus />
                                    @error('price')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="quantity">বিক্রয় সংখ্যা <span class="text-danger">*</span></label>
                                    <input class="form-control py-4 @error('quantity') is-invalid @enderror" id="quantity" type="number" value="{{ $solds->quantity }}" placeholder="বিক্রয় সংখ্যা" name="quantity" required autocomplete="quantity" autofocus />
                                    @error('quantity')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="total_price">সর্বমোট মূল্য <span class="text-danger">*</span></label>
                                    <input class="form-control py-4 @error('total_price') is-invalid @enderror" id="total_price" value="{{ $solds->total_price }}" type="number" placeholder="সর্বমোট মূল্য" name="total_price" required readonly autocomplete="total_price" autofocus />
                                    @error('total_price')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="small mb-1"  for="details">বিস্তারিত</label>
                                    <textarea id="details" name="details">{!!$solds->details!!}</textarea>
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
        $(document).ready(function(){
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

            /**
             * Total price calculating
            */
           function totalPrice(){
                var price = $("#price").val()
                var quantity = $("#quantity").val()
                var total = (parseInt(price) * parseInt(quantity))
                $("#total_price").val(total)
           }

           $("#quantity").on("keyup", function(){
                totalPrice()
           })
        })
    </script>
@endsection