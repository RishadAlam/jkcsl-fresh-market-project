@extends('layouts.main')

@section('main-content')
    <div class="container-fluid">
        <h3 class="mt-4 text-bold">তামাদি কার্ড বিক্রয়</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">তামাদি কার্ড বিক্রয়</li>
        </ol>

        <!--Stock Table-->
        <div class="card mb-4">
            <div class="card-header">
                <span><i class='bx bx-category'></i></span>
                তামাদি কার্ড বিক্রয় প্রতিবেদন
                <div class="dateRange text-end">
                    <form action="{{ Route('sales.card.tamadi') }}" method="GET">
                        <div class="form-group m-0">
                            @if (auth()->user()->can('কার্ড অফিসার নির্বাচন'))
                                <label class="small mb-1" for="officer_id">অফিসার</label>
                                <select name="officer_id" id="officer_id">
                                    <option value="" {{ request()->has('daterange') ? '' : 'selected' }}>সকল অফিসার
                                    </option>
                                    @forelse ($officers as $officer)
                                        <option value="{{ $officer->id }}"
                                            {{ request()->get('officer_id') == $officer->id ? 'selected' : '' }}>
                                            {{ $officer->name }}</option>
                                    @empty
                                        <option disabled>কোনো অফিসার পাওয়া যাইনি</option>
                                    @endforelse
                                </select>
                            @endif
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
                        @if (auth()->user()->can('কার্ড অফিসার নির্বাচন'))
                            <th>অফিসার</th>
                        @endif
                        <th>মূল্য দর</th>
                        <th>বিক্রয় সংখ্যা</th>
                        <th>সর্বমোট মূল্য </th>
                        <th style="width: 300px;">বিস্তারিত</th>
                        @if (auth()->user()->can('কার্ড ইডিট') ||
                            auth()->user()->can('কার্ড ডিলিট'))
                            <th class="text-center">একশন</th>
                        @endif
                        @if (auth()->user()->can('কার্ড অনুমোদন'))
                            <th class="text-center">
                                অনুমোদন
                                <input type="checkbox" data-toggle="toggle" id="allCheck" data-on="YES" data-off="NO"
                                    data-onstyle="success" data-offstyle="danger">
                            </th>
                        @endif
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                            $totalQuantity = 0;
                        @endphp
                        @forelse ($solds as $key => $sold)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $sold->created_at }}</td>
                                @if (auth()->user()->can('কার্ড অফিসার নির্বাচন'))
                                    <td>{{ $sold->User->name }}</td>
                                @endif
                                <td>{{ $sold->net_price }}</td>
                                <td>{{ $sold->quantity }}</td>
                                <td>{{ $sold->total_price }}</td>
                                <td>{!! $sold->details !!}</td>
                                @if (auth()->user()->can('কার্ড ইডিট') ||
                                    auth()->user()->can('কার্ড ডিলিট'))
                                    <td class="text-center">
                                        <div class="btn-group">
                                            @if (auth()->user()->can('কার্ড ইডিট'))
                                                <a href="{{ Route('sales.card.edit', $sold->id) }}"
                                                    class="edit btn btn-sm btn-warning text-yellow-500">
                                                    <span style="display: grid; font-size: 24px;">
                                                        <i class='bx bx-edit'></i>
                                                    </span>
                                                </a>
                                            @endif
                                            @if (auth()->user()->can('কার্ড ডিলিট'))
                                                <button type="submit" class="btn btn-sm btn-danger text-yellow-500"
                                                    data-toggle="modal"
                                                    data-target="#deleteModal_{{ $sold->id }}"><span
                                                        style="display: grid; font-size: 24px;"><i
                                                            class='bx bx-trash'></i></span></button>

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal_{{ $sold->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                        <div class="modal-content" style="min-width: 600px;">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">কার্ড ডিলিট</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form id="deleteForm"
                                                                action="{{ Route('sales.card.delete', $sold->id) }}"
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
                                @if (auth()->user()->can('কার্ড অনুমোদন'))
                                    <td class="text-center">
                                        <input type="checkbox" data-toggle="toggle" value="{{ $sold->id }}"
                                            name="status[]" id="user_status" data-on="YES" data-off="NO"
                                            data-onstyle="success" data-offstyle="danger">
                                    </td>
                                @endif
                            </tr>
                            @php
                                $total += $sold->total_price;
                                $totalQuantity += $sold->quantity;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">কোনো বিক্রয় পাওয়া যাইনি</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            @if (auth()->user()->can('কার্ড অফিসার নির্বাচন'))
                                <td></td>
                            @endif
                            <td colspan="3" class="text-end"><b>সর্বমোটঃ</b></td>
                            <td><b>৳{{ $totalQuantity }}/-</b></td>
                            <td colspan="3"><b>৳{{ $total }}/-</b></td>
                            <td id="approvalBtn" class="text-center d-none"><button
                                    class="btn btn-primary btn-md">save</button></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('customJS')
    <script>
        $(document).ready(function() {
            /**
             * Approval Check
             */
            $('input[name="status[]"]').on('change', function() {
                checked()
            })

            /**
             * ALL Approval Check
             */
            $("#allCheck").on("change", function() {
                if ($(this).is(':checked')) {
                    // alert("kasjdk")
                    $('input:checkbox').not(this).prop('checked', this.checked);
                    $('.toggle').removeClass('off')
                    $('.toggle').addClass('on')
                } else {
                    $('input[name="status[]"]:checked').prop('checked', false);
                    $('.toggle').removeClass('on')
                    $('.toggle').addClass('off')
                }

                checked()
            })

            /**
             * Approval Check function
             */
            function checked() {
                totalCheck = $("input[name='status[]']").length;
                totalChecked = $("input[name='status[]']:checked").length;
                if (totalCheck == totalChecked) {
                    $("#allCheck").prop('checked', true);
                    $("#allCheck").parent('.toggle').removeClass('off');
                    $("#allCheck").parent('.toggle').addClass('on');
                } else {
                    $("#allCheck").prop('checked', false);
                    $("#allCheck").parent('.toggle').removeClass('off');
                    $("#allCheck").parent('.toggle').addClass('off');
                }

                if (totalChecked > 0) {
                    $("#approvalBtn").removeClass("d-none");
                } else {
                    $("#approvalBtn").addClass("d-none");
                }
            }

            /**
             * Approval Check IDs Submit
             */
            $("#approvalBtn").on('click', function(e) {
                e.preventDefault();
                /**
                 * Get Approval Check IDs
                 */
                var id = [];
                $("input[name='status[]']:checked").each(function() {
                    id.push(this.value);
                });
                var url = '{{ Route('sales.card.approve') }}'
                $.ajax({
                    url: url,
                    type: "POST",
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    beforSend: $("#approvalBtn").attr('disable', true),
                    success: function(data) {
                        $("#approvalBtn").attr('disable', false)
                        if (data.status == true) {
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
                                text: 'অনুমোদন সম্পন্ন হয়নি',
                                icon: 'error',
                                position: 'mid-center',
                            })
                        }
                    },
                    error: function(data) {
                        $("#approvalBtn").attr('disable', false)
                        /**
                         * Error message print
                         */
                        $.toast({
                            heading: 'Error',
                            text: 'অনুমোদন সম্পন্ন হয়নি',
                            icon: 'error',
                            position: 'mid-center',
                        })
                    }
                })
            })
        })
    </script>
@endsection
