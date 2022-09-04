@extends('theme.app')
@section('titulo')
    GENERAR ENTREGA EXTRA
@endsection
@section('content')
<livewire:entregas.generar-entrega :id="$id" />

@endsection





