@extends('theme.app')
@section('titulo')
    OPCIONES PROYECTO
@endsection
@section('content')
<livewire:proyectos.opciones-proyecto :id="$id" />

@endsection
