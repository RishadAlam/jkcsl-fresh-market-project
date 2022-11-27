@extends('layouts.main')

@section('main-content')
<div class="container-fluid">
        <h3 class="mt-4 text-bold">পদবি</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{Route('dashboard')}}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">পদবি</li>
        </ol>

        {{-- ADD Employee --}}
        <!-- Button trigger modal -->
        <div class="text-end">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
            পদবি রেজিস্ট্রেশন
            </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content" style="min-width: 600px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">পদবি রেজিস্ট্রেশন</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('roles.store') }}">
                    <div class="modal-body">
                            @csrf
                            <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputname">নাম <span class="text-danger">*</span></label>
                                    <input class="form-control py-4 @error('name') is-invalid @enderror" id="inputname" type="text" placeholder="নাম লিখুন" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus />
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    @foreach ($groups as $key => $groups)
                                        <div class="col-lg-6 border mb-3 p-0 rounded">
                                            <div class="card-header">
                                                <b class="d-flex justify-content-between">
                                                    <label for="permissions_{{$groups->group_name}}" style="cursor: pointer;">{{$groups->group_name}}</label>
                                                    <input id="permissions_{{$groups->group_name}}" value="{{$groups->group_name}}" class="headerCheked" type="checkbox"/>
                                                </b>
                                            </div>
                                            <div class="col-md-12 p-3">
                                                @foreach ($permissions as $permission)
                                                    @if ($groups->group_name == $permission->group_name)
                                                        <p class="d-flex justify-content-between">
                                                            <label class="small mb-1" for="permissions_{{$permission->id}}" style="cursor: pointer;">{{$permission->name}} </label>
                                                            <input class="{{$groups->id}}" id="permissions_{{$permission->id}}" type="checkbox" name="permissions[]" value="{{$permission->id}}"/>
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>                                  
        </div>

        {{-- Roles Table --}}
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
                        <th style="width: 60%;">অনুমতি</th>
                        <th>একশন</th>
                    </thead>
                    <tbody>
                        @foreach ($roles as $keys => $role)
                            <tr>
                                <td class="font-eng">{{++$keys}}</td>
                                <td>{{$role['name']}}</td>
                                <td>
                                    @foreach ($role->permissions as $permissions)
                                        <div class="badge badge-sm badge-success">{{$permissions->name}}</div>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{Route('roles.edit', $role->id)}}" class="edit btn btn-sm btn-warning text-yellow-500"><span style="display: grid; font-size: 24px;"><i class='bx bx-edit' ></i></span></a>
                                    </div>
                                </td>
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
            $(document).ready(function(){
                @if (session()->has('success'))
                    $.toast({
                        heading: 'Success',
                        text: '{{session("success")}}',
                        icon: 'success',
                        position: 'mid-center',
                    })
                @endif

                $("#user_status").on('change', function(){
                    $(this).parents('div').siblings('form').trigger("submit");
                })
            })
        </script>
@endsection