@extends('theme.app')
@section('titulo')
    DETALLES COTIZACIONES
@endsection
@section('content')
<livewire:cotizaciones.detalles-cotizacion :id="$id" />

@endsection





