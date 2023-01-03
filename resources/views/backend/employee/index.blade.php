@extends('layouts.main')

@section('main-content')
    <div class="container-fluid">
        <h3 class="mt-4 text-bold">অফিসার</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">অফিসার</li>
        </ol>

        @if (auth()->user()->can('অফিসার রেজিস্ট্রেশন'))
            {{-- ADD Employee --}}
            <!-- Button trigger modal -->
            <div class="text-end">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                    অফিসার রেজিস্ট্রেশন
                </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">অফিসার রেজিস্ট্রেশন</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('employee.add') }}">
                            <div class="modal-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputname">নাম <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control py-4 @error('name') is-invalid @enderror"
                                                id="inputname" type="text" placeholder="নাম লিখুন" name="name"
                                                value="{{ old('name') }}" required autocomplete="name" autofocus />
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmailAddress">ইমেইল <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control py-4 @error('email') is-invalid @enderror"
                                                id="inputEmailAddress" type="email" placeholder="ইমেইল অ্যাড্রেস দিন"
                                                name="email" value="{{ old('email') }}" required autocomplete="email"
                                                autofocus />
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="role">পদবি <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select" style="height: 50px;" name="role"
                                                id="role">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label class="small mb-1" for="password">পাসওয়ার্ড <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control py-4 @error('password') is-invalid @enderror"
                                                id="password" type="password" placeholder="পাসওয়ার্ড দিন" name="password"
                                                value="{{ old('password') }}" required autocomplete="password" autofocus />
                                            <span id="lock" class="lockIcon"><i class='bx bxs-lock'></i></span>
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        {{-- Employee Table --}}
        <div class="card mb-4">
            <div class="card-header">
                <span><i class="fas fa-users"></i></span>
                সকল অফিসার
            </div>
            <div class="card-body overflow-auto overflow-lg-unset">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <th>#</th>
                        <th>নাম</th>
                        <th>ইমেল</th>
                        <th>পদবি</th>
                        <th>মোবাইল</th>
                        <th>ছবি</th>
                        <th>স্ট্যাটাস</th>
                        @if (auth()->user()->can('অফিসার স্ট্যাটাস পরিবর্তন'))
                            <th>একশন</th>
                        @endif
                        @if (auth()->user()->can('অফিসার ইডিট'))
                            <th>ইডিট</th>
                        @endif
                    </thead>
                    <tbody>
                        @foreach ($user as $keys => $row)
                            <tr>
                                <td class="font-eng">{{ ++$keys }}</td>
                                <td>{{ $row['name'] }}</td>
                                <td class="font-eng">{{ $row['email'] }}</td>
                                <td>
                                    @foreach ($row['roles'] as $role)
                                        {{ $role->name }}
                                    @endforeach
                                </td>
                                <td>{{ $row['phone'] }}</td>
                                <td>
                                    <img class="photo shadow border p-2"
                                        style="height: 100px; width: 90px; border-radius: 15px; object-fit: cover;"
                                        src="{{ $row['image'] != null ? asset('storage/images/' . $row['image'] . '') : 'https://avatars.dicebear.com/api/initials/' . $row['name'] . '.svg' }}"
                                        alt="User">
                                </td>
                                <td>
                                    @if ($row['status'] == 1)
                                        <span class="badge badge-pill badge-success font-eng">ACTIVE</span>
                                    @elseif ($row['status'] == 2)
                                        <span class="badge badge-pill badge-warning font-eng">PANDING</span>
                                    @else
                                        <span class="badge badge-pill badge-danger font-eng">DEACTIVE</span>
                                    @endif
                                </td>
                                @if (auth()->user()->can('অফিসার স্ট্যাটাস পরিবর্তন'))
                                    <td>

                                        <input type="checkbox"
                                            @if ($row['status'] == 1) checked 
                                        @elseif ($row['status'] == 2)
                                            disabled @endif
                                            data-toggle="toggle" class="user_status" data-on="Active"
                                            data-off="Deactive" data-onstyle="success" data-offstyle="danger">
                                        {{-- <a href="" id="status"></a> --}}
                                        <form action="{{ Route('employee.status', $row->id) }}" method="POST">
                                            @csrf
                                        </form>
                                    </td>
                                @endif
                                @if (auth()->user()->can('অফিসার ইডিট'))
                                    <td>
                                        <a href="{{ Route('employee.edit', $row->id) }}"
                                            class="edit btn btn-sm btn-warning text-yellow-500"><span
                                                style="display: grid; font-size: 24px;"><i
                                                    class='bx bx-edit'></i></span></a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
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

            @if (session()->has('success'))
                $.toast({
                    heading: 'Success',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    position: 'mid-center',
                })
            @endif

            $(".user_status").on('change', function() {
                $(this).parents('div').siblings('form').trigger("submit");
            })
        })
    </script>
@endsection
