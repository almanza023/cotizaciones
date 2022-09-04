
<!DOCTYPE html>
<html>
    <head>
        @include('theme.estilos')
        <title>INICIO DE SESIÓN</title>
    </head>
    <body class="fixed-left" >
        <!-- Begin page -->
        <div class="wrapper-page">
            <div class="card">
                <div class="card-body">
                        <center>
                            <img src="{{ asset('theme/assets/images/logo-grupo.png') }}" alt="" width="180" height="120">
                            <h2><b>INICIO DE SESIÓN<h2><b></b></h2>
                            <h2><b>GRUPO HE SAS<h2><b></b></h2>
                        </center>
                    <div class="p-3">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <form class="form-horizontal m-t-20" autocomplete="off" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="">Usuario</label>
                                    <input class="form-control" type="number"  name="usuario" placeholder=" ">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="">Contraseña</label>
                                    <input class="form-control" type="password"  name="password" placeholder="Contraseña">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Recordarme</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center row m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">INGRESAR <i class="mdi mdi-arrow-right-bold-circle"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('theme.scripts')
    </body>
</html>
