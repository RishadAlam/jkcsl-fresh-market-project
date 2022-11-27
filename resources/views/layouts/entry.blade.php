<!DOCTYPE html>
<html lang="bn">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Page Title - SB Admin</title>
        <!--Toster-->
        <link href="{{asset('admin/css/jquery.toast.css')}}" rel="stylesheet">  
        <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet" />
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    @yield('main-body')
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Rishad Alam</div>
                            <div>
                                <span>{{ config('app.name', 'Laravel') }}</span>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!--Jquery-->
        <script src="{{asset('admin/js/jquery-3.6.0.min.js')}}"></script>
        <!--Toster-->
        <script src="{{asset('admin/js/jquery.toast.js')}}"></script>
        <script src="{{asset('admin/js/scripts.js')}}"></script>
        @yield('customJS')
    </body>
</html>