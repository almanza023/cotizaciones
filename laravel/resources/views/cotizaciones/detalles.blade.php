@extends('theme.app')
@section('titulo')
    DETALLES COTIZACIONES
@endsection
@section('content')
<livewire:cotizaciones.detalles-cotizacion :id="$id" />
<script >
    window.addEventListener('cerrarModal', event => {
        alert('Name updated to: ' + event.detail.newName);
    })
</script>
@endsection





