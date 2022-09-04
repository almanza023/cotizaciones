@extends('theme.app')
@section('titulo')
   ENTREGAS
@endsection

@section('content')
<livewire:entregas.entregas :id="$id" />

@endsection




