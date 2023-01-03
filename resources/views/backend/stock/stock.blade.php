@extends('layouts.main')

@section('main-content')
    <div class="container-fluid">
        <h3 class="mt-4 text-bold">স্টক ম্যানেজমেন্ট</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">স্টক ম্যানেজমেন্ট</li>
        </ol>

        @if (auth()->user()->can('স্টক রেজিস্ট্রেশন'))
            {{-- Manage Stock --}}
            <!-- Button trigger modal -->
            <div class="text-end">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                    পণ্য/প্যাকেজ রেজিস্ট্রেশন
                </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">পণ্য/প্যাকেজ রেজিস্ট্রেশন</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="stockStore">
                            <div class="modal-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputname">নাম <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control py-4" id="inputname" type="text"
                                                placeholder="নাম লিখুন" name="name" required autocomplete="name"
                                                autofocus />
                                            <span class="text-danger" id="nameError"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="category">ক্যাটাগরি <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" style="height: 50px;" name="category"
                                                id="category">
                                                <option disabled selected>ক্যাটাগরি নির্বাচন করুন</option>
                                                @forelse ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->category_name }}
                                                    </option>
                                                @empty
                                                    <option disabled>কোনো ক্যাটাগরি পাওয়া যাইনি</option>
                                                @endforelse
                                            </select>
                                            <span class="text-danger" id="categoryError"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="real_price">প্রকৃত মূল্য <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control py-4" id="real_price" type="number"
                                                placeholder="প্রকৃত মূল্য" name="real_price" required
                                                autocomplete="real_price" autofocus />
                                            <span class="text-danger" id="real_priceError"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="profit">লভ্যাংশ <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control py-4" id="profit" type="number"
                                                placeholder="লভ্যাংশ মূল্য" name="profit" required autocomplete="profit"
                                                autofocus />
                                            <span class="text-danger" id="profitError"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="total">মোট <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control py-4" id="total" type="number"
                                                placeholder="মোট মূল্য" name="total" required readonly />
                                            <span class="text-danger" id="totalError"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="stock">স্টক <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control py-4" id="stock" type="number"
                                                placeholder="স্টক" name="stock" required />
                                            <span class="text-danger" id="stockError"></span>
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
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="formClose"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="formSubmit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!--Stock Table-->
        <div class="card mb-4">
            <div class="card-header">
                <span><i class='bx bxs-store'></i></span>
                ক্যাটাগরি টেবিল
            </div>
            <div class="card-body p-0">
                <div class="row">
                    {{-- @dd($stocks) --}}
                    @forelse ($stocks as $row)
                        <div class="col-lg-12 mb-5">
                            <div class="card">
                                <div class="card-header">
                                    <strong>{{ $row->category_name }}</strong>
                                </div>
                                <div class="card-body p-0 overflow-auto overflow-lg-unset">
                                    <table class="table table-striped table-hover table-bordered">
                                        <thead>
                                            <th style="width: 2%">#</th>
                                            <th style="width: 15%">নাম</th>
                                            <th style="width: 40%">বিস্তারিত</th>
                                            <th style="width: 5%">স্টক</th>
                                            <th style="width: 5%">প্রকৃত মূল্য</th>
                                            <th style="width: 5%">মুনাফা</th>
                                            <th style="width: 5%">বিক্রয় মূল্য</th>
                                            <th style="width: 5%">স্টক মূল্য</th>
                                            <th style="width: 5%">স্টক মুনাফা</th>
                                            <th style="width: 5%">স্টক বিক্রয় মূল্য</th>
                                            @if (auth()->user()->can('স্টক ইডিট') ||
                                                auth()->user()->can('স্টক ডিলিট'))
                                                <th style="width: 8%">একশন</th>
                                            @endif
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalStock = 0;
                                                $RealPrice = 0;
                                                $profit = 0;
                                                $totalsales = 0;
                                                $totalStockPrice = 0;
                                                $totalRealPrice = 0;
                                                $totalprofit = 0;
                                            @endphp
                                            @forelse ($row->stock as $kay => $value)
                                                <tr>
                                                    <td>{{ ++$kay }}</td>
                                                    <td>{{ $value->name }}</td>
                                                    <td>{!! $value->details !!}</td>
                                                    <td>{{ $value->stock }}টি</td>
                                                    <td>৳{{ $value->real_price }}/-</td>
                                                    <td>৳{{ $value->profit }}/-</td>
                                                    <td>৳{{ $value->total }}/-</td>
                                                    <td>৳{{ $value->stock * $value->real_price }}/-</td>
                                                    <td>৳{{ $value->stock * $value->profit }}/-</td>
                                                    <td>৳{{ $value->stock * ($value->real_price + $value->profit) }}/-</td>
                                                    @if (auth()->user()->can('স্টক ইডিট') ||
                                                        auth()->user()->can('স্টক ডিলিট'))
                                                        <td>
                                                            <div class="btn-group">
                                                                @if (auth()->user()->can('স্টক ইডিট'))
                                                                    <button data-id="{{ $value->id }}"
                                                                        class="edit btn btn-sm btn-warning text-yellow-500"
                                                                        data-toggle="modal" data-target="#editModal">
                                                                        <span style="display: grid; font-size: 24px;">
                                                                            <i class='bx bx-edit'></i>
                                                                        </span>
                                                                    </button>
                                                                @endif
                                                                @if (auth()->user()->can('স্টক ডিলিট'))
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-danger text-yellow-500"
                                                                        data-toggle="modal"
                                                                        data-target="#deleteModal_{{ $value->id }}"><span
                                                                            style="display: grid; font-size: 24px;"><i
                                                                                class='bx bx-trash'></i></span></button>

                                                                    <!-- Delete Modal -->
                                                                    <div class="modal fade"
                                                                        id="deleteModal_{{ $value->id }}"
                                                                        tabindex="-1" aria-labelledby="deleteModalLabel"
                                                                        aria-hidden="true">
                                                                        <div
                                                                            class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                                            <div class="modal-content"
                                                                                style="min-width: 600px;">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">স্টক ডিলিট</h5>
                                                                                    <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span
                                                                                            aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <form
                                                                                    action="{{ Route('stock.delete', $value->id) }}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <div class="modal-body">
                                                                                        <h3
                                                                                            class="text-center text-danger">
                                                                                            আপনি কি
                                                                                            নিশ্চিত ডিলিট করতে চাইছেন?</h3>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                            class="btn btn-secondary"
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
                                                    $totalStock += $value->stock;
                                                    $RealPrice += $value->real_price;
                                                    $profit += $value->profit;
                                                    $totalsales += $value->total;
                                                    $totalStockPrice += $value->stock * ($value->real_price + $value->profit);
                                                    $totalRealPrice += $value->stock * $value->real_price;
                                                    $totalprofit += $value->stock * $value->profit;
                                                @endphp
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">কোনো সার্ভিস পাওয়া যাইনি</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-end">সর্বমোটঃ</td>
                                                <td>{{ $totalStock }}টি</td>
                                                <td>৳{{ $RealPrice }}/-</td>
                                                <td>৳{{ $profit }}/-</td>
                                                <td>৳{{ $totalsales }}/-</td>
                                                <td>৳{{ $totalRealPrice }}/-</td>
                                                <td>৳{{ $totalprofit }}/-</td>
                                                <td>৳{{ $totalStockPrice }}/-</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @empty
                        <span class="text-center" style="width: 100%;">কোনো সার্ভিস পাওয়া যাইনি</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>


    @if (auth()->user()->can('স্টক ইডিট'))
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">স্টক ইডিট</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editstock">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input id="id" type="hidden" name="id" />
                                        <label class="small mb-1" for="up_name">নাম <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control py-4" id="up_name" type="text"
                                            placeholder="নাম লিখুন" name="up_name" required autocomplete="up_name"
                                            autofocus />
                                        <span class="text-danger" id="up_nameError"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="up_category">ক্যাটাগরি <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" style="height: 50px;" name="up_category"
                                            id="up_category">
                                            <option disabled selected>ক্যাটাগরি নির্বাচন করুন</option>
                                            @forelse ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}
                                                </option>
                                            @empty
                                                <option disabled>কোনো ক্যাটাগরি পাওয়া যাইনি</option>
                                            @endforelse
                                        </select>
                                        <span class="text-danger" id="up_categoryError"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="up_real_price">প্রকৃত মূল্য <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control py-4" id="up_real_price" type="number"
                                            placeholder="প্রকৃত মূল্য" name="up_real_price" required
                                            autocomplete="up_real_price" autofocus />
                                        <span class="text-danger" id="up_real_priceError"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="up_profit">লভ্যাংশ <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control py-4" id="up_profit" type="number"
                                            placeholder="লভ্যাংশ মূল্য" name="up_profit" required
                                            autocomplete="up_profit" autofocus />
                                        <span class="text-danger" id="up_profitError"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="up_total">মোট <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control py-4" id="up_total" type="number"
                                            placeholder="মোট মূল্য" name="up_total" required readonly />
                                        <span class="text-danger" id="up_totalError"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="up_stock">স্টক <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control py-4" id="up_stock" type="number"
                                            placeholder="স্টক" name="up_stock" required />
                                        <span class="text-danger" id="up_stockError"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="up_details">বিস্তারিত</label>
                                        <textarea id="up_details" name="up_details"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="editFormClose"
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="editFormSubmit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
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
             * SummerNote
             */
            $('#details').summernote({
                height: 150,
            });

            /**
             * Total Price Calculation
             */
            $("#real_price").on("keyup", function() {
                total();
            })

            $("#profit").on("keyup", function() {
                total();
            })

            function total() {
                var realPrice = $("#real_price").val();
                var profit = $("#profit").val();
                var totalPrice = $("#total");
                var total = parseInt(realPrice) + parseInt(profit);
                totalPrice.val(total);
            }

            /**
             * Update Total Price Calculation
             */
            $("#up_real_price").on("keyup", function() {
                upTotal();
            })

            $("#up_profit").on("keyup", function() {
                upTotal();
            })

            function upTotal() {
                var realPrice = $("#up_real_price").val();
                var profit = $("#up_profit").val();
                var totalPrice = $("#up_total");
                var total = parseInt(realPrice) + parseInt(profit);
                totalPrice.val(total);
            }

            /**
             * Registration Stock form submit
             */
            $("#stockStore").on("submit", function(e) {
                e.preventDefault();

                /**
                 * form Input Store In valiabe
                 */
                var name = $("input[name=name]")
                var category = $("#category")
                var real_price = $("input[name=real_price]")
                var profit = $("input[name=profit]")
                var total = $("input[name=total]")
                var stock = $("input[name=stock]")

                /**
                 * Form Validation
                 */
                if (name.val() == '') {
                    name.addClass('is-invalid')
                    $('#nameError').text('নাম প্রয়োজন')
                }
                if (category.val() == null) {
                    category.addClass('is-invalid')
                    $('#categoryError').text('ক্যাটাগরির প্রয়োজন')
                }
                if (real_price.val() == '') {
                    real_price.addClass('is-invalid')
                    $('#real_priceError').text('প্রকৃত মূল্য প্রয়োজন')
                }
                if (profit.val() == '') {
                    profit.addClass('is-invalid')
                    $('#profitError').text('লভ্যাংশ প্রয়োজন')
                }
                if (total.val() == '') {
                    total.addClass('is-invalid')
                    $('#totalError').text('মোট মূল্য প্রয়োজন')
                }
                if (stock.val() == '') {
                    stock.addClass('is-invalid')
                    $('#stockError').text('স্টক প্রয়োজন')
                }

                /**
                 * Attemp to submit
                 */
                if (name.val() != '' && category.val() != null && real_price.val() != '' && profit.val() !=
                    '' && total.val() != '' && stock.val() != '') {
                    let url = '{{ Route('stock.store') }}';
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: $("#stockStore").serialize(),
                        dataType: "JSON",
                        beforesend: $("#formSubmit").attr('disabled', true),
                        success: function(data) {
                            $("#formSubmit").attr('disabled', false)
                            if (data.status == true) {
                                $("#stockStore").trigger('reset');
                                $("#formClose").trigger('click');
                                /**
                                 * success message print
                                 */
                                $.toast({
                                    heading: 'Success',
                                    text: data.message,
                                    icon: 'success',
                                    position: 'mid-center',
                                })
                                setTimeout(() => {
                                    location.reload();
                                }, 3000);
                            } else {
                                /**
                                 * Error message print
                                 */
                                $.toast({
                                    heading: 'Error',
                                    text: data.message,
                                    icon: 'error',
                                    position: 'mid-center',
                                })
                            }
                        },
                        error: function(data) {
                            $("#formSubmit").attr('disabled', false)
                            /**
                             * Error message print
                             */
                            $.toast({
                                heading: 'Error',
                                text: 'স্টক রেজিস্ট্রেশন সম্পন্ন হয়নি আবার চেষ্টা করুন',
                                icon: 'error',
                                position: 'mid-center',
                            })

                        }
                    })
                }
            })

            /**
             * Edit Stock Modal Show
             */
            $(".edit").on("click", function(e) {
                e.preventDefault()

                let id = $(this).data('id')
                var upid = $("#id")
                var name = $("input[name=up_name]")
                var real_price = $("input[name=up_real_price]")
                var profit = $("input[name=up_profit]")
                var total = $("input[name=up_total]")
                var stock = $("input[name=up_stock]")
                let details = $("#up_details")
                let url = '{{ Route('stock.edit', ':id') }}'
                url = url.replace(":id", id)
                $.ajax({
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        upid.val('');
                        upid.val(data.id);
                        name.val('');
                        name.val(data.name);
                        $("#up_category option[value='" + data.category_id + "']").prop(
                            'selected', true);
                        real_price.val('');
                        real_price.val(data.real_price);
                        profit.val('');
                        profit.val(data.profit);
                        total.val('');
                        total.val(data.total);
                        stock.val('');
                        stock.val(data.stock);
                        details.summernote('code', '');
                        details.summernote('code', data.details);
                    },
                    error: function(data) {
                        $.toast({
                            heading: 'Error',
                            text: data,
                            icon: 'error',
                            position: 'mid-center',
                        })
                    }
                })
            })

            /**
             * Update Category form submit
             */
            $("#editstock").on("submit", function(e) {
                e.preventDefault()

                /**
                 * form Input Store In valiabe
                 */
                var id = $("#id").val()
                var name = $("input[up_name=name]")
                var category = $("#up_category")
                var real_price = $("input[name=up_real_price]")
                var profit = $("input[name=up_profit]")
                var total = $("input[name=up_total]")
                var stock = $("input[name=up_stock]")

                /**
                 * Form Validation
                 */
                if (name.val() == '') {
                    name.addClass('is-invalid')
                    $('#nameError').text('নাম প্রয়োজন')
                }
                if (category.val() == null) {
                    category.addClass('is-invalid')
                    $('#categoryError').text('ক্যাটাগরির প্রয়োজন')
                }
                if (real_price.val() == '') {
                    real_price.addClass('is-invalid')
                    $('#real_priceError').text('প্রকৃত মূল্য প্রয়োজন')
                }
                if (profit.val() == '') {
                    profit.addClass('is-invalid')
                    $('#profitError').text('লভ্যাংশ প্রয়োজন')
                }
                if (total.val() == '') {
                    total.addClass('is-invalid')
                    $('#totalError').text('মোট মূল্য প্রয়োজন')
                }
                if (stock.val() == '') {
                    stock.addClass('is-invalid')
                    $('#stockError').text('স্টক প্রয়োজন')
                }
                console.log($("#editstock").serialize())

                /**
                 * Attemp to submit
                 */
                if (name.val() != '' && category.val() != null && real_price.val() != '' && profit.val() !=
                    '' && total.val() != '' && stock.val() != '') {
                    let url = '{{ Route('stock.update', ':id') }}';
                    url = url.replace(":id", id)
                    $.ajax({
                        url: url,
                        type: "PUT",
                        data: $("#editstock").serialize(),
                        dataType: "JSON",
                        beforesend: $("#editFormSubmit").attr('disabled', true),
                        success: function(data) {
                            $("#editFormSubmit").attr('disabled', false)
                            if (data.status == true) {
                                $("#editstock").trigger('reset');
                                $("#editFormClose").trigger('click');
                                /**
                                 * success message print
                                 */
                                $.toast({
                                    heading: 'Success',
                                    text: data.message,
                                    icon: 'success',
                                    position: 'mid-center',
                                })
                                setTimeout(() => {
                                    location.reload();
                                }, 3000);
                            } else {
                                /**
                                 * Error message print
                                 */
                                $.toast({
                                    heading: 'Error',
                                    text: data.message,
                                    icon: 'error',
                                    position: 'mid-center',
                                })
                            }
                        },
                        error: function(data) {
                            $("#editFormSubmit").attr('disabled', false)
                            /**
                             * Error message print
                             */
                            if (data.status === 422) {
                                var error = JSON.parse(data.responseText)
                                $.toast({
                                    heading: 'Error',
                                    text: error.message,
                                    icon: 'error',
                                    position: 'mid-center',
                                })
                            } else {
                                $.toast({
                                    heading: 'Error',
                                    text: 'ক্যাটাগরি আপডেট সম্পন্ন হয়নি আবার চেষ্টা করুন',
                                    icon: 'error',
                                    position: 'mid-center',
                                })
                            }
                        }
                    })
                }
            })
        });
    </script>
@endsection
