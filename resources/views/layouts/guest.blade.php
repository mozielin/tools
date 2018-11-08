<!DOCTYPE html>

<html lang="en">

    <!-- BEGIN HEAD -->

    <head>
        <title>Metronic Admin RTL Theme #1 | eCommercen Dashboard</title>

        @include('layouts.meta')
        @include('layouts.css')
        
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                @include('layouts.header')
            </div>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                @include('layouts.navi')
            </div>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE-->
                        @yield('content')
                        <!-- END PAGE-->
                    </div>
                <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-login"></i>
                </a>
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <div class="page-footer">
                @include('layouts.footer')
            </div>
            <!-- END FOOTER -->
        </div>
            @include('layouts.js')
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })


            $(document).ready( function () {
                $('#table_12').DataTable();
                $('#table_13').DataTable();
            });

            

            

        </script>
    </body>

</html>