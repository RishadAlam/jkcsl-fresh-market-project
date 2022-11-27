@extends('layouts.main')

@section('main-content')
    <div class="container-fluid mb-5">
        <h3 class="mt-4 text-bold">বেতন</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">বেতন</li>
        </ol>

        <div class="d-flex align-items-center justify-content-center">
            <div class="card" style="max-width: 800px;">
                <div class="card-header text-center">
                    <strong>বেতন ফরম</strong>
                </div>
                <form action="{{ Route('salary.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="officer">অফিসার <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('product') is-invalid @enderror"
                                        style="height: 50px;" name="officer" id="officer">
                                        <option disabled selected>অফিসার নির্বাচন করুন</option>
                                        @foreach ($officers as $officer)
                                            <option value="{{ $officer->id }}">{{ $officer->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('officer')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="month">মাস <span class="text-danger">*</span></label>
                                    <input type="month" style="height: 50px;" class="form-control" id="month"
                                        name="month" />
                                    @error('month')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="total_sale">সর্বমোট বিক্রয় <span
                                            class="text-danger">*</span></label>
                                    <input type="number" value="0" style="height: 50px;" class="form-control"
                                        id="total_sale" name="total_sale" placeholder="" readonly />
                                    @error('total_sale')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="salery_per">কমিশন
                                        ({{ $card_percentage[0]->card_percentage }}%)<span
                                            class="text-danger">*</span></label>
                                    <input type="number" value="0" style="height: 50px;" class="form-control"
                                        id="salery_per" name="salery_per" placeholder="" readonly />
                                    @error('salery_per')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="expence">খরচ<span class="text-danger">*</span></label>
                                    <input type="number" value="0" style="height: 50px;" class="form-control"
                                        id="expence" name="expence" placeholder="" readonly />
                                    @error('expence')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="present_bonus">উপস্থিতি বোনাস<span
                                            class="text-danger">*</span></label>
                                    <input type="number" value="0" style="height: 50px;" class="form-control"
                                        id="present_bonus" name="present_bonus" placeholder="" />
                                    @error('present_bonus')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="extra_1">চা-নাস্তা<span
                                            class="text-danger">*</span></label>
                                    <input type="number" value="0" style="height: 50px;" class="form-control"
                                        id="extra_1" name="extra_1" placeholder="" />
                                    @error('extra_1')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="extra_2">গাড়ি ভাড়া<span
                                            class="text-danger">*</span></label>
                                    <input type="number" value="0" style="height: 50px;" class="form-control"
                                        id="extra_2" name="extra_2" placeholder="" />
                                    @error('extra_2')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="extra_3">মোবাইল বিল<span
                                            class="text-danger">*</span></label>
                                    <input type="number" value="0" style="height: 50px;" class="form-control"
                                        id="extra_3" name="extra_3" placeholder="" />
                                    @error('extra_3')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="basic_salary">বেসিক বেতন<span
                                            class="text-danger">*</span></label>
                                    <input type="number" value="0" style="height: 50px;" class="form-control"
                                        id="basic_salary" name="basic_salary" placeholder="" />
                                    @error('basic_salary')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="total_salary">সর্বমোট বেতন<span
                                            class="text-danger">*</span></label>
                                    <input type="number" value="0" style="height: 50px;" class="form-control"
                                        id="total_salary" name="total_salary" readonly />
                                    @error('total_salary')
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
        <!--Salary Table-->
        <div class="card mb-4">
            <div class="card-header">
                <span><i class='bx bx-category'></i></span>
                বেতনের প্রতিবেদন
                <div class="dateRange text-end">
                    <form action="{{ Route('salary.form') }}" method="GET">
                        <div class="form-group m-0">
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
                        <th>মাস</th>
                        <th>সর্বমোট বিক্রয়</th>
                        <th>কমিশন</th>
                        <th>খরচ</th>
                        <th>উপস্থিতি বোনাস</th>
                        <th>চা-নাস্তা</th>
                        <th>গাড়ি ভাড়া</th>
                        <th>মোবাইল বিল</th>
                        <th>বেসিক বেতন</th>
                        <th>সর্বমোট বেতন</th>
                        <th>একশন</th>
                    </thead>
                    <tbody>
                        @forelse ($salaries as $key => $salary)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $salary->created_at }}</td>
                                <td>{{ $salary->User->name }}</td>
                                <td>{{ $salary->month }}</td>
                                <td>{{ $salary->total_sale }}টি</td>
                                <td>৳{{ $salary->salery_percentage }}/-</td>
                                <td>৳{{ $salary->expence }}/-</td>
                                <td>৳{{ $salary->present_bonus }}/-</td>
                                <td>৳{{ $salary->extra_1 }}/-</td>
                                <td>৳{{ $salary->extra_2 }}/-</td>
                                <td>৳{{ $salary->extra_3 }}/-</td>
                                <td>৳{{ $salary->basic_salary }}/-</td>
                                <td>৳{{ $salary->total_salary }}/-</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ Route('salary.print', $salary->id) }}"
                                            class="edit btn btn-sm btn-success text-yellow-500" target="_blank">
                                            <span style="display: grid; font-size: 24px;">
                                                <i class='bx bx-printer'></i>
                                            </span>
                                        </a>

                                        <a href="{{ Route('salary.edit', $salary->id) }}"
                                            class="edit btn btn-sm btn-warning text-yellow-500"><span
                                                style="display: grid; font-size: 24px;"><i
                                                    class='bx bx-edit'></i></span></a>

                                        <button type="submit" class="btn btn-sm btn-danger text-yellow-500"
                                            data-toggle="modal" data-target="#deleteModal_{{ $salary->id }}"><span
                                                style="display: grid; font-size: 24px;"><i
                                                    class='bx bx-trash'></i></span></button>
                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal_{{ $salary->id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content" style="min-width: 600px;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">বেতন ডিলিট</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form id="deleteForm"
                                                        action="{{ Route('salary.delete', $salary->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-body">
                                                            <h3 class="text-center text-danger">আপনি কি নিশ্চিত ডিলিট করতে
                                                                চাইছেন?</h3>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center">কোনো বেতন পাওয়া যাইনি</td>
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
             * Keyup Functions
             */
            $('#officer').on("change", function() {
                employee()
                setTimeout(() => {
                    total_salary()
                }, 1000);
            })

            $('#month').on('change', function() {
                employee()
                setTimeout(() => {
                    total_salary()
                }, 1000);
            })

            $('#present_bonus').on('keyup', function() {
                total_salary()
            })

            $('#extra_1').on('keyup', function() {
                total_salary()
            })

            $('#extra_2').on('keyup', function() {
                total_salary()
            })

            $('#extra_3').on('keyup', function() {
                total_salary()
            })

            $('#basic_salary').on('keyup', function() {
                total_salary()
            })

            /**
             * Dependent Data Function
             */
            function employee() {
                let officer_id = $('#officer').val()
                let month = $('#month').val()
                let url = "{{ Route('salary.store.value') }}"

                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        officer_id: officer_id,
                        month: month
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.quantity == null) {
                            $('#total_sale').val(0)
                        } else {
                            $('#total_sale').val(data.quantity)
                        }
                        $('#salery_per').val(data.percentage)
                        $('#expence').val(data.expence)
                    },
                    error: function(data) {
                        console.log(data);
                    }
                })
            }

            /**
             * Total Salary Function
             */
            function total_salary() {
                var percentage = $('#salery_per').val();
                var expence = $('#expence').val();
                var present_bonus = $('#present_bonus').val();
                var extra_1 = $('#extra_1').val();
                var extra_2 = $('#extra_2').val();
                var extra_3 = $('#extra_3').val();
                var basic_salary = $('#basic_salary').val();
                var total_salary = $('#total_salary');

                var total = parseInt(percentage) + parseInt(expence) + parseInt(present_bonus) + parseInt(extra_1) +
                    parseInt(extra_2) + parseInt(extra_3) + parseInt(basic_salary)

                total_salary.val(total)
                console.log(total)
            }
        })
    </script>
@endsection
