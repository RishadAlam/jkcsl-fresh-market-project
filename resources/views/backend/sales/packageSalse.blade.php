@extends('layouts.main')

@section('main-content')
    <div class="container-fluid mb-5">
        <h3 class="mt-4 text-bold">সার্ভিস বিক্রয়</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">সার্ভিস বিক্রয়</li>
        </ol>

        @if (auth()->user()->can('সার্ভিস বিক্রয়'))
            <div class="d-flex align-items-center justify-content-center">
                <div class="card" style="max-width: 800px;">
                    <div class="card-header text-center">
                        <strong>সার্ভিস বিক্রয়</strong>
                    </div>
                    <form action="{{ Route('salse.packge-sales.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label class="small mb-1" for="officer_id">অফিসার নির্বাচন করুন <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control @error('officer_id') is-invalid @enderror"
                                            style="height: 50px;" name="officer_id" id="officer_id">
                                            @if (auth()->user()->can('সার্ভিস অফিসার নির্বাচন'))
                                                <option disabled selected>অফিসার নির্বাচন করুন</option>
                                                @forelse ($officers as $officer)
                                                    <option value="{{ $officer->id }}"
                                                        {{ old('officer_id') == $officer->id ? 'selected' : '' }}>
                                                        {{ $officer->name }}</option>
                                                @empty
                                                    <option disabled>কোনো অফিসার পাওয়া যাইনি</option>
                                                @endforelse
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="category">ক্যাটাগরি নির্বাচন করুন <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control @error('category') is-invalid @enderror"
                                            style="height: 50px;" name="category" id="category">
                                            <option disabled selected>ক্যাটাগরি নির্বাচন করুন</option>
                                            @forelse ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}</option>
                                            @empty
                                                <option disabled>কোনো ক্যাটাগরি পাওয়া যাইনি</option>
                                            @endforelse
                                        </select>
                                        @error('category')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="product">পণ্য নির্বাচন করুন <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control @error('product') is-invalid @enderror"
                                            style="height: 50px;" name="product" id="product">
                                            <option disabled selected>পণ্য নির্বাচন করুন</option>
                                        </select>
                                        @error('product')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="price">মূল্য দর <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control py-4 @error('price') is-invalid @enderror" id="price"
                                            type="number" value="{{ old('price') }}" placeholder="মূল্য" name="price"
                                            required autocomplete="price" readonly autofocus />
                                        <input id="profitPrice" type="hidden" name="profitPrice" />
                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="stock">স্টক <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control py-4 @error('stock') is-invalid @enderror" id="stock"
                                            type="number" value="{{ old('stock') }}" name="stock" required
                                            autocomplete="stock" readonly autofocus />
                                        @error('stock')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="quantity">বিক্রয় সংখ্যা <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control py-4 @error('quantity') is-invalid @enderror"
                                            id="quantity" type="number" value="{{ old('quantity') }}"
                                            placeholder="বিক্রয় সংখ্যা" name="quantity" required autocomplete="quantity"
                                            autofocus />
                                        @error('quantity')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="stock_rem">অবশিষ্ট স্টক <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control py-4 @error('stock_rem') is-invalid @enderror"
                                            id="stock_rem" type="number" value="{{ old('stock_rem') }}"
                                            placeholder="অবশিষ্ট স্টক" name="stock_rem" required readonly
                                            autocomplete="stock_rem" autofocus />
                                        @error('stock_rem')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="total_price">সর্বমোট মূল্য <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control py-4 @error('total_price') is-invalid @enderror"
                                            id="total_price" value="{{ old('total_price') }}" type="number"
                                            placeholder="সর্বমোট মূল্য" name="total_price" required readonly
                                            autocomplete="total_price" autofocus />
                                        <input id="total_profit" name="total_profit" type="hidden" />
                                        @error('total_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="details">বিস্তারিত</label>
                                        <textarea id="details" name="details"></textarea>
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
        @endif
    </div>

    <div class="container-fluid">
        <!--Stock Table-->
        <div class="card mb-4">
            <div class="card-header">
                <span><i class='bx bx-category'></i></span>
                আজকের বিক্রয় প্রতিবেদন
            </div>
            <div class="card-body overflow-auto overflow-lg-unset">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <th>#</th>
                        <th>তারিখ</th>
                        <th>নাম</th>
                        <th>ক্যাটাগরি</th>
                        <th>মূল্য দর</th>
                        <th>বিক্রয় সংখ্যা</th>
                        <th>সর্বমোট মূল্য </th>
                        <th style="width: 300px;">বিস্তারিত</th>
                        @if (auth()->user()->can('সার্ভিস অফিসার নির্বাচন'))
                            <th>অফিসার</th>
                        @endif
                        @if (auth()->user()->can('সার্ভিস ইডিট') ||
                            auth()->user()->can('সার্ভিস ডিলিট'))
                            <th>একশন</th>
                        @endif
                    </thead>
                    <tbody>
                        @forelse ($solds as $key => $sold)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ date('h:i:s A', strtotime($sold->created_at)) }}</td>
                                <td>{{ $sold->stock->name }}</td>
                                <td>{{ $sold->category->category_name }}</td>
                                <td>{{ $sold->net_price }}</td>
                                <td>{{ $sold->quantity }}</td>
                                <td>{{ $sold->total_price }}</td>
                                <td>{!! $sold->details !!}</td>
                                @if (auth()->user()->can('সার্ভিস অফিসার নির্বাচন'))
                                    <td>{{ $sold->User->name }}</td>
                                @endif
                                @if (auth()->user()->can('সার্ভিস ইডিট') ||
                                    auth()->user()->can('সার্ভিস ডিলিট'))
                                    <td>
                                        <div class="btn-group">
                                            @if (auth()->user()->can('সার্ভিস ইডিট'))
                                                <a href="{{ Route('salse.packge-sales.edit', $sold->id) }}"
                                                    class="edit btn btn-sm btn-warning text-yellow-500">
                                                    <span style="display: grid; font-size: 24px;">
                                                        <i class='bx bx-edit'></i>
                                                    </span>
                                                </a>
                                            @endif
                                            @if (auth()->user()->can('সার্ভিস ডিলিট'))
                                                <button type="submit" class="btn btn-sm btn-danger text-yellow-500"
                                                    data-toggle="modal"
                                                    data-target="#deleteModal_{{ $sold->id }}"><span
                                                        style="display: grid; font-size: 24px;"><i
                                                            class='bx bx-trash'></i></span></button>
                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal_{{ $sold->id }}"
                                                    tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div
                                                        class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                        <div class="modal-content" style="min-width: 600px;">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">ক্যাটাগরি ডিলিট</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form id="deleteForm"
                                                                action="{{ Route('salse.packge-sales.delete', $sold->id) }}"
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
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">কোনো বিক্রয় পাওয়া যাইনি</td>
                            </tr>
                        @endforelse
                    </tbody>
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

            /**
             * Total price calculating
             */
            function totalPrice() {
                var price = $("#price").val()
                var profitPrice = $("#profitPrice").val()
                var totalQuantity = $("#stock").val()
                var quantity = $("#quantity").val()
                var quantityRem = (parseInt(totalQuantity) - parseInt(quantity))
                var total = (parseInt(price) * parseInt(quantity))
                var totalProfit = (parseInt(profitPrice) * parseInt(quantity))
                $("#stock_rem").val(quantityRem)
                $("#total_price").val(total)
                $("#total_profit").val(totalProfit)
            }

            /**
             * Products Load
             */
            $("#category").on("change", function() {
                var category_id = $(this).val()
                var url = '{{ Route('salse.packge-sales.stock-list', ':id') }}'
                url = url.replace(':id', category_id);

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: "JSON",
                    success: function(data) {
                        if (data != '') {
                            var options = []
                            options.push(
                                '<option disabled selected>পণ্য নির্বাচন করুন</option>')
                            $.map(data, function(value) {
                                options.push('<option value="' + value.id + '">' + value
                                    .name + '</option>')
                            })
                            $("#product").html('')
                            $("#product").html(options)
                        } else {
                            $("#product").html('')
                            $("#product").html(
                                '<option disabled selected>কোনো পণ্য পাওয়া যাইনি</option>')
                        }
                    },
                    error: function(data) {
                        console.table(data)
                    }
                })
            })

            /**
             * Product Load
             */
            $("#product").on("change", function() {
                var product_id = $(this).val()
                var url = '{{ Route('salse.packge-sales.product', ':id') }}'
                url = url.replace(':id', product_id);

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: "JSON",
                    success: function(data) {
                        if (data != '') {
                            $("#price").val(data.total)
                            $("#stock").val(data.stock)
                            $("#profitPrice").val(data.profit)
                        } else {
                            $("#price").val(0)
                            $("#stock").val(0)
                        }
                    },
                    error: function(data) {
                        console.table(data)
                    }
                })
            })

            $("#quantity").on("keyup", function() {
                totalPrice()
            })
        })
    </script>
@endsection
