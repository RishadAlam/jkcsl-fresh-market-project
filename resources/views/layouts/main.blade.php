<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $setting->name }}</title>
    <!-- kalpurush Font -->
    <link href="https://fonts.maateen.me/kalpurush/font.css" rel="stylesheet" />
    <!--Icon-->
    <link href='{{ asset('admin/css/boxicons.min.css') }}' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!--style-->
    <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet" />
    <!--Bootstrap-->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <!--date Range picker-->
    <link href="{{ asset('admin/css/daterangepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/mdtimepicker.min.css') }}" rel="stylesheet">
    <!--Select2-->
    <link href="{{ asset('admin/css/tail.select-light.css') }}" rel="stylesheet">
    <!--Toster-->
    <link href="{{ asset('admin/css/jquery.toast.css') }}" rel="stylesheet">
    <!--Meterial Date Range Picker-->
    <link href="{{ asset('admin/css/duDatepicker.min.css') }}" rel="stylesheet">
    <!--summernote-->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <!--Bootstrap Toggle Switch-->
    <link href="{{ asset('admin/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <!--font Aowsome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"
        integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/js/all.min.js" crossorigin="anonymous"></script>
    <!--main CSS-->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ $setting->name }}
        </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group d-none">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search"
                    aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="img d-inline-block" style="width: 40px">
                        <img class="rounded-circle"
                            src="{{ auth()->user()->image != null ? asset('storage/images/' . auth()->user()->image . '') : 'https://avatars.dicebear.com/api/initials/' . auth()->user()->name . '.svg' }}"
                            alt="User">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ Route('user.profile') }}">প্রোফাইল</a>
                    <a class="dropdown-item" href="{{ Route('user.password.reset') }}">পাসওয়ার্ড পরিবর্তন করুন</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">লগ-আউট</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading"></div>
                        <a class="nav-link" href="{{ Route('dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            ড্যাশবোর্ড
                        </a>
                        @if (auth()->user()->can('সার্ভিস বিক্রয়') ||
                            auth()->user()->can('কার্ড বিক্রয়'))
                            <div class="sb-sidenav-menu-heading">বিক্রয়</div>
                            <a class="nav-link {{ request()->routeIs('sales.card') || request()->routeIs('sales.package') ? '' : 'collapsed' }}"
                                href="#" data-toggle="collapse" data-target="#sales" aria-expanded="false"
                                aria-controls="sales">
                                <div class="sb-nav-link-icon"><i class='bx bx-cart-download'></i></div>
                                বিক্রয়
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse {{ request()->routeIs('sales.card') || request()->routeIs('sales.package') ? 'show' : '' }}"
                                id="sales" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    @if (auth()->user()->can('কার্ড বিক্রয়'))
                                        <a class="nav-link" href="{{ Route('sales.card') }}">
                                            <div class="sb-nav-link-icon"><i class='bx bxs-credit-card-front'></i>
                                            </div>
                                            কার্ড বিক্রয়
                                        </a>
                                    @endif
                                    @if (auth()->user()->can('সার্ভিস বিক্রয়'))
                                        <a class="nav-link" href="{{ Route('sales.package') }}">
                                            <div class="sb-nav-link-icon"><i class='bx bx-cart-add'></i></div>
                                            সার্ভিস বিক্রয়
                                        </a>
                                    @endif
                                </nav>
                            </div>
                        @endif
                        @if (auth()->user()->can('কার্ড বিক্রয় প্রতিবেদন') ||
                            auth()->user()->can('সার্ভিস বিক্রয় প্রতিবেদন'))
                            <div class="sb-sidenav-menu-heading">বিক্রয় প্রতিবেদন</div>
                        @endif
                        @if (auth()->user()->can('কার্ড বিক্রয় প্রতিবেদন'))
                            <a class="nav-link" href="{{ Route('sales.report') }}">
                                <div class="sb-nav-link-icon"><i class='bx bxs-report'></i></div>
                                কার্ড বিক্রয় প্রতিবেদন
                            </a>
                        @endif
                        @if (auth()->user()->can('সার্ভিস বিক্রয় প্রতিবেদন'))
                            <a class="nav-link" href="{{ Route('sales.totalReport') }}">
                                <div class="sb-nav-link-icon"><i class='bx bx-terminal'></i></div>
                                সার্ভিস বিক্রয় প্রতিবেদন
                            </a>
                        @endif
                        @if (auth()->user()->can('কার্ড বিক্রয় তামাদি'))
                            <a class="nav-link" href="{{ Route('sales.card.tamadi') }}">
                                <div class="sb-nav-link-icon"><i class='bx bx-spreadsheet'></i></div>
                                তামাদি কার্ড বিক্রয়
                            </a>
                        @endif
                        @if (auth()->user()->can('স্টক') ||
                            auth()->user()->can('ক্যাটাগরি'))
                            <div class="sb-sidenav-menu-heading">স্টক/ক্যাটাগরি ম্যানেজমেন্ট</div>
                        @endif
                        @if (auth()->user()->can('স্টক'))
                            <a class="nav-link" href="{{ Route('stock.management') }}">
                                <div class="sb-nav-link-icon"><i class='bx bxs-store'></i></div>
                                স্টক ম্যানেজমেন্ট
                            </a>
                        @endif
                        @if (auth()->user()->can('ক্যাটাগরি'))
                            <a class="nav-link" href="{{ Route('category.management') }}">
                                <div class="sb-nav-link-icon"><i class='bx bx-category'></i></div>
                                ক্যাটাগরি ম্যানেজমেন্ট
                            </a>
                        @endif
                        @if (auth()->user()->can('হিসাব') ||
                            auth()->user()->can('সেটিংস') ||
                            auth()->user()->can('পদবি এবং অনুমতি') ||
                            auth()->user()->can('ব্যয়') ||
                            auth()->user()->can('অফিসার দৈনিক ব্যয়') ||
                            auth()->user()->can('অফিসার') ||
                            auth()->user()->can('কার্ড বিক্রয় রিপোর্ট') ||
                            auth()->user()->can('বেতন ফরম'))
                            <div class="sb-sidenav-menu-heading">কন্ট্রোল প্যানেল</div>
                        @endif
                        @if (auth()->user()->can('ব্যয়'))
                            <a class="nav-link" href="{{ Route('expenece') }}">
                                <div class="sb-nav-link-icon"><i class='bx bx-money-withdraw'></i></div>
                                ব্যয়
                            </a>
                        @endif
                        @if (auth()->user()->can('অফিসার দৈনিক ব্যয়'))
                            <a class="nav-link" href="{{ Route('expenece.officer') }}">
                                <div class="sb-nav-link-icon"><i class='bx bx-money'></i></div>
                                অফিসার দৈনিক ব্যয়
                            </a>
                        @endif
                        @if (auth()->user()->can('অফিসার'))
                            <a class="nav-link" href="{{ Route('employee.all') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                অফিসার
                            </a>
                        @endif
                        @if (auth()->user()->can('পদবি এবং অনুমতি'))
                            <a class="nav-link" href="{{ Route('roles') }}">
                                <div class="sb-nav-link-icon"><i class='bx bx-command'></i></div>
                                পদবি এবং অনুমতি
                            </a>
                        @endif
                        @if (auth()->user()->can('কার্ড বিক্রয় রিপোর্ট') ||
                            auth()->user()->can('বেতন ফরম'))
                            <a class="nav-link {{ request()->routeIs('salary.salesReport') || request()->routeIs('salary.form') ? '' : 'collapsed' }}"
                                href="#" data-toggle="collapse" data-target="#salary_sheet"
                                aria-expanded="false" aria-controls="salary_sheet">
                                <div class="sb-nav-link-icon"><i class='bx bx-spreadsheet'></i></div>
                                বেতন শীট
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse {{ request()->routeIs('salary.salesReport') || request()->routeIs('salary.form') ? 'show' : '' }}"
                                id="salary_sheet" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    @if (auth()->user()->can('কার্ড বিক্রয় রিপোর্ট'))
                                        <a class="nav-link" href="{{ Route('salary.salesReport') }}">
                                            <div class="sb-nav-link-icon"><i class='bx bx-credit-card-alt'></i>
                                            </div>
                                            কার্ড বিক্রয় রিপোর্ট
                                        </a>
                                    @endif
                                    @if (auth()->user()->can('বেতন ফরম'))
                                        <a class="nav-link" href="{{ Route('salary.form') }}">
                                            <div class="sb-nav-link-icon"><i
                                                    class='bx bxs-objects-horizontal-left'></i>
                                            </div>
                                            বেতন
                                        </a>
                                    @endif
                                </nav>
                            </div>
                        @endif
                        @if (auth()->user()->can('শেয়ার হিসাব'))
                            <a class="nav-link" href="{{ Route('accounts.calculations.share') }}">
                                <div class="sb-nav-link-icon"><i class='bx bxs-pie-chart-alt-2'></i></div>
                                শেয়ার হিসাব
                            </a>
                        @endif
                        @if (auth()->user()->can('হিসাব'))
                            <a class="nav-link" href="{{ Route('accounts.calculations') }}">
                                <div class="sb-nav-link-icon"><i class='bx bx-calculator'></i></div>
                                হিসাব
                            </a>
                        @endif
                        @if (auth()->user()->can('সেটিংস'))
                            <a class="nav-link" href="{{ Route('settings') }}">
                                <div class="sb-nav-link-icon"><i class='bx bx-command'></i></div>
                                সেটিংস
                            </a>
                        @endif
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    {{ auth()->user()->name }}
                    <div class="small">{{ auth()->user()->roles[0]->name }}</div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                @yield('main-content')
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted font-eng">Copyright &copy; Rishad Alam</div>
                        <div>
                            <span>{{ $setting->name }}</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!--Jquery-->
    <script src="{{ asset('admin/js/jquery-3.6.0.min.js') }}"></script>
    <!--Bootstrap-->
    <script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
    <!--Icon-->
    <script src="{{ asset('admin/js/boxicons.js') }}"></script>
    <!--Date Range Picker-->
    <script src="{{ asset('admin/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('admin/js/mdtimepicker.min.js') }}"></script>
    <script src="{{ asset('admin/js/moment.min.js') }}"></script>
    <!--Select2-->
    <script src="{{ asset('admin/js/tail.select.min.js') }}"></script>
    <!--Sweet Alert-->
    <script src="{{ asset('admin/js/sweetalert2@11.js') }}"></script>
    <!--summerNote-->
    <script src="{{ asset('admin/js/summernote.min.js') }}"></script>
    <!--Toster-->
    <script src="{{ asset('admin/js/jquery.toast.js') }}"></script>
    <!--Meterial Date Range Picker-->
    <script src="{{ asset('admin/js/duDatepicker.min.js') }}"></script>
    <!--Bootstrap Toggle Switch-->
    <script src="{{ asset('admin/js/bootstrap4-toggle.min.js') }}"></script>
    <!--JS-->
    <script src="{{ asset('admin/js/scripts.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> --}}
    {{-- <script src="assets/demo/chart-area-demo.js"></script> --}}
    {{-- <script src="assets/demo/chart-bar-demo.js"></script> --}}
    {{-- <script src="assets/demo/datatables-demo.js"></script> --}}
    {{-- Main Js --}}
    <script src="{{ asset('admin/js/main.js') }}"></script>
    @yield('customJS')
</body>

</html>
