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
    <title>Dashboard - SB Admin</title>
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
    <link rel="stylesheet" href="{{ asset('admin/css/print.css') }}" media="print">
</head>

<body>

    {{-- Print Header --}}
    <section id="printHeader">
        <div class="conatiner-fluid">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8 text-center">
                    <h5>বিসমিল্লাহির রাহমানির রাহীম</h5>
                    <h1>{{ $card_percentage[0]->name }}</h1>
                    <h3>(একটি কল্যাণমূখী আর্থ-সামাজিক সংগঠন)</h3>
                    <h4>প্রধান কার্যালয়ঃ কালামিয়া বাজার, বাকলিয়া, চট্রগ্রাম</h4>
                </div>
                <div class="col-2"></div>
            </div>
        </div>
    </section>
    <hr>

    <section id="print_content">
        <div class="conatiner-fluid">
            @yield('printContent')
        </div>
    </section>

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
    <script>
        window.print();
    </script>
</body>

</html>
