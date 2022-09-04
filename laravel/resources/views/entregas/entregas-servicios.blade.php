@extends('theme.app')
@section('titulo')
    PROYECTOS SERVICIOS
@endsection
@section('content')
<livewire:entregas.entrega-servicio :id="$id" />

@endsection





