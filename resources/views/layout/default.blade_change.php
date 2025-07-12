<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Acom TV | @yield('mytitle')</title>
    
    <link href="{{asset('layouts/modern-light-menu/css/light/loader.css')}}" rel="stylesheet" type="text/css" />
   <link href="{{asset('layouts/modern-light-menu/css/dark/loader.css')}}" rel="stylesheet" type="text/css" />
   <script src="{{asset('layouts/modern-light-menu/loader.js')}}"></script>
   <!-- BEGIN GLOBAL MANDATORY STYLES -->
   <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
   <link href="{{asset('src/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
   <link href="{{asset('layouts/modern-light-menu/css/light/plugins.css')}}" rel="stylesheet" type="text/css" />
   <link href="{{asset('layouts/modern-light-menu/css/dark/plugins.css')}}" rel="stylesheet" type="text/css" />
   <!-- END GLOBAL MANDATORY STYLES -->
   <!-- BEGIN PAGE LEVEL PLUGINS -->
   <link href="{{asset('src/plugins/src/animate/animate.css')}}" rel="stylesheet" type="text/css" />
   <!-- END PAGE LEVEL PLUGINS -->
   <!--  BEGIN CUSTOM STYLE FILE  -->
   <link href="{{asset('src/assets/css/light/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
   <link href="{{asset('src/assets/css/light/components/carousel.css')}}" rel="stylesheet" type="text/css">
   <link href="{{asset('src/assets/css/light/components/modal.css')}}" rel="stylesheet" type="text/css" />
   <link href="{{asset('src/assets/css/light/components/tabs.css')}}" rel="stylesheet" type="text/css">
   <link href="{{asset('src/assets/css/dark/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
   <link href="{{asset('src/assets/css/dark/components/carousel.css')}}" rel="stylesheet" type="text/css">
   <link href="{{asset('src/assets/css/dark/components/modal.css')}}" rel="stylesheet" type="text/css" />
   <link href="{{asset('src/assets/css/dark/components/tabs.css')}}" rel="stylesheet" type="text/css">
   <link rel="stylesheet" href="{{asset('src/plugins/src/filepond/filepond.min.css')}}">
   <link rel="stylesheet" href="{{asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.css')}}">
   <link href="{{asset('src/plugins/css/light/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />
   <link href="{{asset('src/plugins/css/dark/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />

   <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
   <!-- Font Awesome -->
   <!-- <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}"> -->
   <!-- Ionicons -->
   <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
   <!-- Tempusdominus Bootstrap 4 -->
   <!-- <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}"> -->
   <!-- iCheck -->
   <!-- <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}"> -->
   <!-- JQVMap -->
   <!-- <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}"> -->
   <!-- Theme style -->
   <!-- <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}"> -->
   <!-- overlayScrollbars -->
   <!-- <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}"> -->
   <!-- Daterange picker -->
   <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
   <!-- summernote -->
   <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('admin-light/assets/css/forms/switches.css')}}">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css" />
   <!-- old file scriots -->
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

   <!-- dash css -->

   <link rel="stylesheet" href="{{asset('dash_css/inter.css')}}">
   <!-- <link rel="stylesheet" href="{{asset('dash_css/all.min.css')}}"> -->
   <!-- <link rel="stylesheet" href="{{asset('dash_css/style.min.css')}}"> -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNp3pC6j6PTNxGoGr/+c86p+r/sC/sU1uER1I1aUZPt+ekgzdzT1G" crossorigin="anonymous"> -->


    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->


</head>
<body>
    <style type="text/css">
        .error{
            color: red;
        }
    </style>
    <div id="loader-screen" style="display:none;position: fixed;top: 0;left: 0;height: 100vh;width: 100vw;z-index: 99;">
        <div class="loader_2" style="margin: auto;"></div>
    </div>
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div>
      @include('layout.header')
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">
            @include('layout.sidebar')
        </div>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            @yield('content')

            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © 2020 <a target="_blank" href="https://designreset.com">DesignReset</a>, All rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
                </div>
            </div>
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->


    <!-- <script src="{{asset('theme/plugins/flatpickr/flatpickr.js')}}"></script> -->
    <!-- <script src="{{asset('theme/plugins/flatpickr/custom-flatpickr.js')}}"></script> -->
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>    
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script>
        $(document).ready(function() {
            App.init();
            // var f1 = document.getElementById('basicFlatpickr');
            // var f2 = document.getElementById('basicFlatpickr1');
            // f1.flatpickr({
            //     dateFormat: "d-m-Y",
            //     defaultDate: ["01-06-2022"],
            //     minDate: '01-06-2022'
            // });
            // f2.flatpickr({
            //     dateFormat: "d-m-Y",
            //     defaultDate: "today",
            //     minDate: '01-06-2022',
            //     maxDate: 'today',
            // });
        });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        flatpickr(".flat_picker", {
            enableTime: true,
            enableSeconds: true,
            noCalendar: true,
            dateFormat: "H:i:s",  // e.g., 13:45
            time_24hr: true,
        });
    });
</script>

<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
   <!-- jQuery UI 1.11.4 -->
   <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
   <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
   <script>
      $.widget.bridge('uibutton', $.ui.button)
   </script>
   <!-- Bootstrap 4 -->
   <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
   <!-- ChartJS -->
   <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
   <!-- Sparkline -->
   <!-- <script src="{{asset('plugins/sparklines/sparkline.js')}}"></script> -->
   <!-- JQVMap -->
   <script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
   <script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
   <!-- jQuery Knob Chart -->
   <script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
   <!-- daterangepicker -->
   <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
   <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
   <!-- Tempusdominus Bootstrap 4 -->
   <script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
   <!-- Summernote -->
   <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
   <!-- overlayScrollbars -->
   <script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
   <!-- AdminLTE App -->
   <script src="{{asset('dist/js/adminlte.js')}}"></script>


   <script src="{{asset('admin-light/plugins/table/datatable/datatables.js')}}"></script>
   <!-- <script type="text/javascript" src="{{asset('admin_assets/js/plugins/bootstrap-notify.min.js')}}"></script> -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.js"></script>
   <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">
   <script src="{{asset('src/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
   <script src="{{asset('src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
   <script src="{{asset('src/plugins/src/mousetrap/mousetrap.min.js')}}"></script>
   <script src="{{asset('src/plugins/src/waves/waves.min.js')}}"></script>
   <script src="{{asset('layouts/modern-light-menu/app.js')}}"></script>
   <script src="{{asset('src/plugins/src/highlight/highlight.pack.js')}}"></script>
   <!-- END GLOBAL MANDATORY STYLES -->
   <!--  BEGIN CUSTOM SCRIPT FILE  -->
   <!-- <script src="{{asset('src/assets/js/scrollspyNav.js')}}"></script> -->
   <script src="{{asset('src/plugins/src/filepond/filepond.min.js')}}"></script>
   <script src="{{asset('src/plugins/src/filepond/FilePondPluginFileValidateType.min.js')}}"></script>
   <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
   <script src="{{asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.js')}}"></script>
   <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageCrop.min.js')}}"></script>
   <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageResize.min.js')}}"></script>
   <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageTransform.min.js')}}"></script>
   <script src="{{asset('src/plugins/src/filepond/filepondPluginFileValidateSize.min.js')}}"></script>
   <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


   <!-- dash js  -->

   <script src="{{asset('dash_js/demo_configurator.js')}}"></script>
   <script src="{{asset('dash_js/bootstrap.bundle.min.js')}}"></script>
   <!-- <script src="{{asset('dash_js/d3.min.js')}}"></script> -->
   <!-- <script src="{{asset('dash_js/d3_tooltip.js')}}"></script> -->
   <!-- <script src="{{asset('dash_js/app.js')}}"></script> -->
   <!-- <script src="{{asset('dash_js/dashboard.js')}}"></script> -->
   <!-- <script src="{{asset('dash_js/streamgraph.js')}}"></script> -->
   <!-- <script src="{{asset('dash_js/sparklines.js')}}"></script> -->
   <!-- <script src="{{asset('dash_js/lines.js')}}"></script> -->
   <!-- <script src="{{asset('dash_js/areas.js')}}"></script> -->
   <!-- <script src="{{asset('dash_js/donuts.js')}}"></script> -->
   <!-- <script src="{{asset('dash_js/bars.js')}}"></script> -->
   <!-- <script src="{{asset('dash_js/progress.js')}}"></script> -->
   <!-- <script src="{{asset('dash_js/heatmaps.js')}}"></script> -->
   <!-- <script src="{{asset('dash_js/pies.js')}}"></script> -->
   <!-- <script src="{{asset('dash_js/bullets.js')}}"></script> -->


   <!-- Include the CanvasJS library -->
   <!-- <script src="https://canvasjs.com/assets/script/jquery-1.11.1.mi   n.js"></script> -->
   <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
   <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>


    <!-- END PAGE LEVEL SCRIPTS -->

    <div class="modal fade" id="delete_blog_modal">
        <div class="modal-dialog action-modal">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="d_title"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p id="delete_user_deletemsg">Do you want to delete this <span id="d_body"></span>?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
              <button type="button" class="btn btn-danger" onclick="ajax_delete_item();" >Yes, Delete</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <script type="text/javascript">
        // ['d_title','d_body','url_enpoint']
        var allPages = {
            "role" : ['Role','role','role'],
            "admin" : ['Admin','admin','admin'],
            "user" : ['User','user','user'],
            "language" : ['Language','language','language'],
            "genre" : ['Genre','genre','genre'],
            "channel" : ['Channel','channel','channel'],
            "movie" : ['Movie','movie','movie'],
            "movieLink" : ['Movie Link','movie Link','movieLink'],
            "sadminPlan" : ['Plan','plan','sadminPlan'],
            "adminPlan" : ['Plan','plan','adminPlan'],
            "slider" : ['Slider','slider','slider'],
            "reseller" : ['Reseller','reseller','reseller'],
            "resellerPlan" : ['Plan','resellerPlan','resellerPlan'],
            "netadmin" : ['NetAdmin','netadmin','netadmin'],
            "network" : ['Network','network','network'],
            
        }
        //Delete building using ajax
        window.bd_id = 0;
        window.url_enpoint = '';
        function delete_item(id,page){
            
            bd_id = id;
            url_enpoint = allPages[page][2];
            $('#d_title').text(allPages[page][0])
            $('#d_body').text(allPages[page][1])
            $("#delete_blog_modal").modal('show');
        }

        function ajax_delete_item(){                    
            var request = $.ajax({
                            url: url_enpoint+"/destroy",
                            method: "POST",
                            data: { "_token": "{{ csrf_token() }}", id : bd_id }
                          });

            request.done(function( val ) {
                
                var data = jQuery.parseJSON(val);
                $("#delete_blog_modal").modal('hide');
                $( "#delete_bd_ms" ).html(data.message);
                $('#multi-column-ordering').DataTable().ajax.reload();
                // setTimeout(function(){location.reload(true);}, 2000);

            });
        }

        function updateStatus(url) {
            // body...
            // alert(id)
            var request = $.ajax({
                            url: url,
                            method: "GET"
                          });

            request.done(function( val ) {
                console.log(val);
                var data = jQuery.parseJSON(val);
                $("#delete_blog_modal").modal('hide');
                $( "#delete_bd_ms" ).html(data.message);
                $('#multi-column-ordering').DataTable().ajax.reload();
                // setTimeout(function(){location.reload(true);}, 2000);

            });
        }

        $(function(){
          $('#user-form').validate(

          ); //valdate end
        });
    </script>

    <script type="text/javascript">

        function updateIcon() {
            // alert('')
            $('li.previous > a').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>')

            $('li.next > a').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>')
        }

        $(document).ready(function() {
            $('.select').select2();
        });

        $(document).ready(function() {


            $('#undo_redo').multiselect({
                search: {
                    left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                }
            })
            $('#undo_redo_rightSelected').click()
        });

    </script>
    
    @yield('footer')
</body>
</html>
