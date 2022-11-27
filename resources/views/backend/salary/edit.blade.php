@extends('layouts.main')

@section('main-content')
    <div class="container-fluid mb-5">
        <h3 class="mt-4 text-bold">বেতন ইডিট</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">বেতন</li>
        </ol>

        <div class="d-flex align-items-center justify-content-center">
            <div class="card" style="max-width: 800px;">
                <div class="card-header text-center">
                    <strong>বেতন ইডিট</strong>
                </div>
                <form action="{{ Route('salary.update', $salary->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="officer">অফিসার <span
                                            class="text-danger">*</span></label>
                                    <input type="text" style="height: 50px;" class="form-control" id="officer"
                                        name="officer" value="{{ $salary->User->name }}" readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="month">মাস <span class="text-danger">*</span></label>
                                    <input type="month" style="height: 50px;" class="form-control" id="month"
                                        name="month" value="{{ date('Y-m', strtotime($salary->month)) }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="total_sale">সর্বমোট বিক্রয় <span
                                            class="text-danger">*</span></label>
                                    <input type="text" style="height: 50px;" class="form-control" id="total_sale"
                                        name="total_sale" value="{{ $salary->total_sale }}" readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="salery_per">কমিশন <span
                                            class="text-danger">*</span></label>
                                    <input type="text" style="height: 50px;" class="form-control" id="salery_per"
                                        name="salery_per" value="{{ $salary->salery_percentage }}" readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="expence">খরচ<span class="text-danger">*</span></label>
                                    <input type="number" style="height: 50px;" class="form-control" id="expence"
                                        name="expence" value="{{ $salary->expence }}" readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="present_bonus">উপস্থিতি বোনাস<span
                                            class="text-danger">*</span></label>
                                    <input type="number" style="height: 50px;" class="form-control" id="present_bonus"
                                        name="present_bonus" value="{{ $salary->present_bonus }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="extra_1">চা-নাস্তা<span
                                            class="text-danger">*</span></label>
                                    <input type="number" style="height: 50px;" class="form-control" id="extra_1"
                                        name="extra_1" value="{{ $salary->extra_1 }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="extra_2">গাড়ি ভাড়া<span
                                            class="text-danger">*</span></label>
                                    <input type="number" style="height: 50px;" class="form-control" id="extra_2"
                                        name="extra_2" value="{{ $salary->extra_2 }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="extra_3">মোবাইল বিল<span
                                            class="text-danger">*</span></label>
                                    <input type="number" style="height: 50px;" class="form-control" id="extra_3"
                                        name="extra_3" value="{{ $salary->extra_3 }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="basic_salary">বেসিক বেতন<span
                                            class="text-danger">*</span></label>
                                    <input type="number" style="height: 50px;" class="form-control" id="basic_salary"
                                        name="basic_salary" value="{{ $salary->basic_salary }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="total_salary">সর্বমোট বেতন<span
                                            class="text-danger">*</span></label>
                                    <input type="number" style="height: 50px;" class="form-control" id="total_salary"
                                        name="total_salary" value="{{ $salary->total_salary }}" readonly />
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
             * Keyup Functions
             */

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
                        $('#total_sale').val(data.quantity)
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
