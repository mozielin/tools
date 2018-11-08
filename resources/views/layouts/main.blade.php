<!DOCTYPE html>
<html lang="en">

    <!-- BEGIN HEAD -->

    <head>
        <title>Tools| ECFit</title>

        @include('layouts.meta')
        @include('layouts.css')

    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-wrapper">
            @include('layouts.header')
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    @include('layouts.navi');
                </div>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                       
                       @yield('content')
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                
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
             $(function() { 
                $('#mytable tbody').sortable({ 
               opacity: 0.6, 
               cursor: 'move', 
              axis:'y', 
                  update: function(event, ui) { 
                     var productOrder = $('#mytable tbody').sortable('toArray').toString(); 
                    $("#mydata").text (productOrder); 
                  } 
               }); 
            });

            $('table_13').dataTable({
                
            });
         </script> 

    </body>

</html>