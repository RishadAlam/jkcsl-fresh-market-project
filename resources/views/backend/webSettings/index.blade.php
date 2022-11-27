@extends('layouts.main')

@section('main-content')
    <div class="container-fluid mb-5">
        <h3 class="mt-4 text-bold">সেটিংস</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">সেটিংস</li>
        </ol>

        <div class="d-flex align-items-center justify-content-center">
            <div class="card" style="max-width: 800px;">
                <div class="card-header text-center">
                    <strong>সেটিংস</strong>
                </div>
                <form action="{{ Route('settings.update', 1) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="name">সফ্টওয়্যার নাম <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control py-4 @error('name') is-invalid @enderror" id="name"
                                        type="text" placeholder="সফ্টওয়্যার নাম" value="{{ $settings->name }}"
                                        name="name" required autocomplete="name" autofocus />
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="card_price">কার্ডের দাম <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control py-4 @error('card_price') is-invalid @enderror"
                                        id="card_price" placeholder="কার্ডের দাম" type="number"
                                        value="{{ $settings->card_price }}" name="card_price" required
                                        autocomplete="card_price" autofocus />
                                    @error('card_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="card_percentage">কার্ড কমিশন (%) <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control py-4 @error('card_percentage') is-invalid @enderror"
                                        id="card_percentage" type="number" placeholder="কার্ড কমিশন"
                                        value="{{ $settings->card_percentage }}" name="card_percentage" required
                                        autocomplete="card_percentage" autofocus />
                                    @error('card_percentage')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="share_quantity">শেয়ার সংখ্যা <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control py-4 @error('share_quantity') is-invalid @enderror"
                                        id="share_quantity" type="number" placeholder="কার্ড কমিশন"
                                        value="{{ $settings->share_quantity }}" name="share_quantity" required
                                        autocomplete="share_quantity" autofocus />
                                    @error('share_quantity')
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
             * SummerNote
             */
            $('textarea').summernote({
                height: 150,
            });

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
