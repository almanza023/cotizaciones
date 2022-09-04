
<!DOCTYPE html>
<html>
    <head>
        @include('theme.estilos')
        @livewireStyles
        @yield('estilos')
        <title>@yield('titulo')</title>
    </head>
    <body class="fixed-left">
        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>
        <!-- Begin page -->
        <div id="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
           @include('theme.sidebar')
            <!-- Left Sidebar End -->
            <!-- Start right Content here -->
            @include('theme.msalir')
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <!-- Top Bar Start -->
                   @include('theme.topbar')
                    <!-- Top Bar End -->
                    <div class="page-content-wrapper ">
                        <div class="container-fluid">
                            @yield('content')
                        </div><!-- container -->
                    </div> <!-- Page content Wrapper -->
                </div> <!-- content -->
                @include('theme.footer')
            </div>
            <!-- End Right content here -->
        </div>
        <!-- END wrapper -->
       @include('theme.scripts')
       @livewireScripts
       <script type="text/javascript">
        window.livewire.on('closeModal', () => {
            $('#exampleModal').modal('hide');
            $('#detallesModal').modal('hide');
            $('#modalCreate').modal('hide');
            $('#modalEstado').modal('hide');
        });

        window.livewire.on('notificacion', () => {
            $('#notificacionModal').modal('show');
        });
    </script>
    <script>
       function mensaje(valor){
        swal(
            {
                title: 'GRUPO HE SAS',
                text: valor,
                type: 'success',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger m-l-10'
            }
        )
       }
       function advertencia(valor){
        swal(
            {
                title: 'GRUPO HE SAS',
                text: valor,
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger m-l-10'
            }
        )
       }
       function error(valor){
        swal(
            {
                title: 'GRUPO HE SAS',
                text: valor,
                type: 'error',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger m-l-10'
            }
        )
       }
    </script>


       @yield('scripts')
    </body>
</html>
