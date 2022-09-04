@extends('theme.app')
@section('titulo')
    GENERAR FACTURA
@endsection
@section('content')
<livewire:facturas.generar-factura :id="$id" />

@endsection





