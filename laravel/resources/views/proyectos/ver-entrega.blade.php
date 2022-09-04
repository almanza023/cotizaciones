@extends('theme.app')
@section('titulo')
    VER DE ENTREGA PROYECTOS
@endsection
@section('content')
<livewire:proyectos.ver-entrega-proyecto :id="$id" />

@endsection
