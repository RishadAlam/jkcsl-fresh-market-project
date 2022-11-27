@extends('layouts.main')

@section('main-content')
    <div class="container-fluid mb-5">
        <h3 class="mt-4 text-bold">পদবি ইডিট</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">পদবি ইডিট</li>
        </ol>

        <div class="d-flex align-items-center justify-content-center">
            <div class="card" style="max-width: 800px;">
                <div class="card-header text-center">
                    <strong>পদবি ইডিট</strong>
                </div>
                <form action="{{ Route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputname">নাম <span class="text-danger">*</span></label>
                                    <input class="form-control py-4 @error('name') is-invalid @enderror" id="inputname"
                                        type="text" placeholder="নাম লিখুন" name="name" value="{{ $role->name }}"
                                        required autocomplete="name" autofocus />
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">

                                    @foreach ($groups as $key => $groups)
                                        <div class="col-lg-6 border mb-3 p-0 rounded">
                                            <div class="card-header">
                                                <b class="d-flex justify-content-between">
                                                    <label for="permissions_{{ $groups->group_name }}"
                                                        style="cursor: pointer;">{{ $groups->group_name }}</label>
                                                    <input id="permissions_{{ $groups->group_name }}"
                                                        value="{{ $groups->group_name }}"
                                                        data-groupname="{{ str_replace(' ', '-', $groups->group_name) }}"
                                                        class="headerCheked" type="checkbox" />
                                                </b>
                                            </div>
                                            <div class="col-md-12 p-3">

                                                @foreach ($permissions as $permission)
                                                    @if ($groups->group_name == $permission->group_name)
                                                        <p class="d-flex justify-content-between">
                                                            <label class="small mb-1"
                                                                for="permissions_{{ $permission->id }}"
                                                                style="cursor: pointer;">{{ $permission->name }} </label>
                                                            <input class="{{ str_replace(' ', '-', $groups->group_name) }}"
                                                                id="permissions_{{ $permission->id }}" type="checkbox"
                                                                {{ $hasPermission->search($permission->id) > -1 ? 'checked' : '' }}
                                                                name="permissions[]" value="{{ $permission->id }}" />
                                                        </p>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
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
            $(".headerCheked").on('click', function() {
                var group = $(this).data('groupname')
                if ($(this).is(':checked')) {
                    $("." + group + "").prop('checked', true)
                } else {
                    $("." + group + "").prop('checked', false)
                }
            })
        })
    </script>
@endsection
