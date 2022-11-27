@extends('layouts.main')

@section('main-content')
    <div class="container-fluid">
        <h3 class="mt-4 text-bold">ক্যাটাগরি ম্যানেজমেন্ট</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">ক্যাটাগরি ম্যানেজমেন্ট</li>
        </ol>

        @if (auth()->user()->can('ক্যাটাগরি রেজিস্ট্রেশন'))
            {{-- Manage Stock --}}
            <!-- Button trigger modal -->
            <div class="text-end">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                    ক্যাটাগরি রেজিস্ট্রেশন
                </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ক্যাটাগরি রেজিস্ট্রেশন</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="addCetegory">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="name">নাম <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control py-4" id="name" type="text"
                                                placeholder="নাম লিখুন" name="name" required autocomplete="name"
                                                autofocus />
                                            <span class="text-danger" id="nameError"></span>
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
                <span><i class='bx bx-category'></i></span>
                ক্যাটাগরি
            </div>
            <div class="card-body overflow-auto overflow-lg-unset">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <th>#</th>
                        <th>নাম</th>
                        <th>বিস্তারিত</th>
                        @if (auth()->user()->can('ক্যাটাগরি ইডিট') ||
                            auth()->user()->can('ক্যাটাগরি ডিলিট'))
                            <th>একশন</th>
                        @endif
                    </thead>
                    <tbody>
                        @forelse ($categories as $key => $category)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $category->category_name }}</td>
                                <td>{!! $category->category_details !!}</td>
                                @if (auth()->user()->can('ক্যাটাগরি ইডিট') ||
                                    auth()->user()->can('ক্যাটাগরি ডিলিট'))
                                    <td>
                                        <div class="btn-group">
                                            @if (auth()->user()->can('ক্যাটাগরি ইডিট'))
                                                <button data-id="{{ $category->id }}"
                                                    class="edit btn btn-sm btn-warning text-yellow-500" data-toggle="modal"
                                                    data-target="#editModal">
                                                    <span style="display: grid; font-size: 24px;">
                                                        <i class='bx bx-edit'></i>
                                                    </span>
                                                </button>
                                            @endif
                                            @if (auth()->user()->can('ক্যাটাগরি ডিলিট'))
                                                <button type="submit" class="btn btn-sm btn-danger text-yellow-500"
                                                    data-toggle="modal" data-target="#deleteModal_{{ $category->id }}"><span
                                                        style="display: grid; font-size: 24px;"><i
                                                            class='bx bx-trash'></i></span></button>
                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal_{{ $category->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                        <div class="modal-content" style="min-width: 600px;">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">ক্যাটাগরি ডিলিট</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form id="deleteForm"
                                                                action="{{ Route('category.delete', $category->id) }}"
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
                                <td colspan="5" class="text-center">কোনো ক্যাটাগরি পাওয়া যাইনি</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @if (auth()->user()->can('ক্যাটাগরি ইডিট'))
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">ক্যাটাগরি ইডিট</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editCetegory">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="up_name">নাম <span
                                                class="text-danger">*</span></label>
                                        <input id="id" type="hidden" name="id" />
                                        <input class="form-control py-4" id="up_name" type="text"
                                            placeholder="নাম লিখুন" name="up_name" required autocomplete="up_name"
                                            autofocus />
                                        <span class="text-danger" id="up_nameError"></span>
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
             * Registration Category form submit
             */
            $("#addCetegory").on("submit", function(e) {
                e.preventDefault();

                /**
                 * form Input Store In valiabe
                 */
                var name = $("input[name=name]")

                /**
                 * Form Validation
                 */
                if (name.val() == '') {
                    name.addClass('is-invalid')
                    $('#nameError').text('ক্যাটাগরির নাম প্রয়োজন')
                }

                /**
                 * Attemp to submit
                 */
                if (name.val() != '' || name.val() != null) {
                    let url = '{{ Route('category.store') }}';
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: $("#addCetegory").serialize(),
                        dataType: "JSON",
                        beforesend: $("#formSubmit").attr('disabled', true),
                        success: function(data) {
                            console.log(data);
                            $("#formSubmit").attr('disabled', false)
                            if (data.status == true) {
                                $("#addCetegory").trigger('reset');
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
                                    text: 'ক্যাটাগরি রেজিস্ট্রেশন সম্পন্ন হয়নি আবার চেষ্টা করুন',
                                    icon: 'error',
                                    position: 'mid-center',
                                })
                            }
                        }
                    })
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

            /**
             * Edit Category Modal Show
             */
            $(".edit").on("click", function(e) {
                e.preventDefault()

                let id = $(this).data('id')
                let name = $("#up_name")
                var upid = $("#id")
                let details = $("#up_details")
                let url = '{{ Route('category.edit', ':id') }}'
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
            $("#editCetegory").on("submit", function(e) {
                e.preventDefault();

                /**
                 * form Input Store In valiabe
                 */
                var name = $("input[name=up_name]")
                var id = $("#id").val()

                /**
                 * Form Validation
                 */
                if (name.val() == '') {
                    name.addClass('is-invalid')
                    $('#up_nameError').text('ক্যাটাগরির নাম প্রয়োজন')
                }

                /**
                 * Attemp to submit
                 */
                if (name.val() != '' || name.val() != null) {
                    let url = '{{ Route('category.update', ':id') }}';
                    url = url.replace(":id", id)
                    $.ajax({
                        url: url,
                        type: "PUT",
                        data: $("#editCetegory").serialize(),
                        dataType: "JSON",
                        beforesend: $("#editFormSubmit").attr('disabled', true),
                        success: function(data) {
                            $("#editFormSubmit").attr('disabled', false)
                            if (data.status == true) {
                                $("#editCetegory").trigger('reset');
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
                            $("#formSubmit").attr('disabled', false)
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
                                console.log(data);
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
