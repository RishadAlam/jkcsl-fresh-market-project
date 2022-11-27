@extends('layouts.main')

@section('main-content')
    <div class="container-fluid">
        <h3 class="mt-4 text-bold">প্রোফাইল</h3>
        <ol class="breadcrumb mb-4 py-1 ps-2">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">ড্যাশবোর্ড</a></li>
            <li class="breadcrumb-item active">প্রোফাইল</li>
        </ol>


        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-12 bg-gary p-0 px-3 py-3 pt-0">
                        <div class="d-flex flex-column align-items-center">
                            <img class="photo shadow border p-3"
                                style="height: 450px; width: 350px; border-radius: 20px; object-fit: cover;"
                                src="{{ asset('storage/images/' . auth()->user()->image ?? auth()->user()->image . '') }}"
                                alt="Profile Image">
                            <p class="fw-bold h4 mt-3"><span
                                    class="badge 
                        @if (auth()->user()->status == 1) badge-success
                        @else
                            badge-danger @endif ">
                                    @if (auth()->user()->status == 1)
                                        ACTIVE
                                    @else
                                        DEACTIVE
                                    @endif
                                </span></p>
                            <p class="fw-bold h4 mt-1 mb-0">{{ auth()->user()->name }}</p>
                            <p class="text-muted">{{ auth()->user()->roles[0]->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 ps-md-4">
                <div class="row">
                    <div class="profile-heading text-center py-4"
                        style="background-color: #e9ecef !important; border-top-left-radius: 20px; border-top-right-radius: 20px;">
                        <h3>প্রফাইল তথ্য</h3>
                    </div>
                    <div class="col-12 bg-white mb-3 p-4 border shadow-inner"
                        style="border-radius: 20px; border-top-left-radius: 0; border-top-right-radius: 0;">
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <p class="py-2">পিতা</p>
                            <p class="py-2 text-muted">{{ auth()->user()->father_name }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <p class="py-2">ইমেল</p>
                            <p class="py-2 text-muted">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <p class="py-2">জাতীয় পরিচয় পত্র নং</p>
                            <p class="py-2 text-muted">{{ auth()->user()->nid }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <p class="py-2">মোবাইল</p>
                            <p class="py-2 text-muted">{{ auth()->user()->phone }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <p class="py-2">মোবাইল-২</p>
                            <p class="py-2 text-muted">{{ auth()->user()->phone2 }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <p class="py-2">জন্ম তারিখ</p>
                            <p class="py-2 text-muted">{{ auth()->user()->dob }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <p class="py-2">রক্তের গ্রুপ</p>
                            <p class="py-2 text-muted">{{ auth()->user()->blood }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="py-2">যোগদান তারিখ</p>
                            <p class="py-2 text-muted">{{ auth()->user()->created_at }}</p>
                        </div>
                        <button class="form-control btn btn-warning rounded" data-toggle="modal"
                            data-target="#exampleModal">ইডিট</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">প্রফাইল ইডিট</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('user.profile.update', auth()->user()->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputname">নাম <span class="text-danger">*</span></label>
                                    <input class="form-control py-4 @error('name') is-invalid @enderror" id="inputname"
                                        type="text" placeholder="নাম লিখুন" name="name"
                                        value="{{ auth()->user()->name }}" required autocomplete="name" autofocus />
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="fatherName">পিতা</label>
                                    <input class="form-control py-4 @error('fatherName') is-invalid @enderror"
                                        id="fatherName" type="text" placeholder="পিতার নাম লিখুন" name="fatherName"
                                        value="{{ auth()->user()->father_name }}" autocomplete="fatherName" />
                                    @error('fatherName')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="mobile">মোবাইল</label>
                                    <input class="form-control py-4 @error('mobile') is-invalid @enderror" id="mobile"
                                        type="number" placeholder="মোবাইল নং লিখুন" name="mobile"
                                        value="{{ auth()->user()->phone }}" autocomplete="mobile" />
                                    @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="mobile_2">মোবাইল২</label>
                                    <input class="form-control py-4 @error('mobile_2') is-invalid @enderror"
                                        id="mobile_2" type="number" placeholder="মোবাইল নং লিখুন" name="mobile_2"
                                        value="{{ auth()->user()->phone2 }}" autocomplete="mobile_2" />
                                    @error('mobile_2')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="nid">জাতীয় পরিচয় পত্র নং</label>
                                    <input class="form-control py-4 @error('nid') is-invalid @enderror" id="nid"
                                        type="number" placeholder="জাতীয় পরিচয় পত্র নং লিখুন" name="nid"
                                        value="{{ auth()->user()->nid }}" autocomplete="nid" />
                                    @error('nid')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="dob">জন্ম তারিখ</label>
                                    <input class="form-control py-4 @error('dob') is-invalid @enderror" id="dob"
                                        type="date" placeholder="জন্ম তারিখ লিখুন" name="dob"
                                        value="{{ auth()->user()->dob }}" autocomplete="dob" />
                                    @error('dob')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="blood">রক্তের গ্রুপ</label>
                                    <select class="form-control @error('blood') is-invalid @enderror"
                                        style="height: 50px;" id="blood" name="blood">
                                        <option disabled selected>রক্তের গ্রুপ নির্বাচন করুন</option>
                                        <option {{ auth()->user()->blood == 'এ পজিটিভ (A+)' ? 'selected' : '' }}
                                            value="এ পজিটিভ (A+)">এ পজিটিভ (A+)</option>
                                        <option {{ auth()->user()->blood == 'এ নেগেটিভ (A-)' ? 'selected' : '' }}
                                            value="এ নেগেটিভ (A-)">এ নেগেটিভ (A-)</option>
                                        <option {{ auth()->user()->blood == 'বি পজিটিভ (B+)' ? 'selected' : '' }}
                                            value="বি পজিটিভ (B+)">বি পজিটিভ (B+)</option>
                                        <option {{ auth()->user()->blood == 'বি নেগেটিভ (B-)' ? 'selected' : '' }}
                                            value="বি নেগেটিভ (B-)">বি নেগেটিভ (B-)</option>
                                        <option {{ auth()->user()->blood == 'এবি পজিটিভ (AB+)' ? 'selected' : '' }}
                                            value="এবি পজিটিভ (AB+)">এবি পজিটিভ (AB+)</option>
                                        <option {{ auth()->user()->blood == 'এবি নেগেটিভ (AB-)' ? 'selected' : '' }}
                                            value="এবি নেগেটিভ (AB-)">এবি নেগেটিভ (AB-)</option>
                                        <option {{ auth()->user()->blood == 'ও পজিটিভ (O+)' ? 'selected' : '' }}
                                            value="ও পজিটিভ (O+)">ও পজিটিভ (O+)</option>
                                        <option {{ auth()->user()->blood == 'ও নেগেটিভ (O-)' ? 'selected' : '' }}
                                            value="ও নেগেটিভ (O-)">ও নেগেটিভ (O-)</option>
                                    </select>
                                    @error('blood')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="img">ছবি</label>
                                    <input type="hidden" name="old_img" value="{{ auth()->user()->image }}" />
                                    <input class="form-control py-4 @error('img') is-invalid @enderror" id="img"
                                        type="file" name="img" accept="image/png, image/jpg, image/jpeg" />

                                    @error('img')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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
@endsection
