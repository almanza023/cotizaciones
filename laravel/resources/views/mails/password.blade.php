<!doctype html>
<html lang="es">
<head>
    @include('theme.estilos')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Llamado de emergencia</title>
</head>
<body>
    <center>
        <img src="{{ asset('theme/assets/images/logo_medicosta.png') }}" alt="">
        <h4><b>RESTABLECER CONTRASEÑA</b></h4>
   </center>
    <p>Hola! Se ha reportado un restablecimiento de contraseña de: {{ $user->afcodigo }}.</p>
    <p>Estos son los datos del usuario:</p>
    <ul>
        <li>Nombre: {{ $user->FullName }}</li>
        <li>N° Documento: {{ $user->afcodigo }}</li>
        <li>Nueva Contraseña: <b>{{ $user->password_reset }}</b></li>
    </ul>
    <a href="{{ route('login') }}" class="btn btn-primary">INGRESAR AHORA</a>



</body>
</html>
