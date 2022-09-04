@extends('theme.app')
@section('titulo')
    IMPORTAR INVENTARIO
@endsection

@section('content')

<div class="card bg-light mt-3">
    <div class="card-header">
        Cargue Inventario Inicial
    </div>
    <div class="card-body">
        <form action="{{ route('import-inventario') }}" method="POST" enctype="multipart/form-data">
            @csrf
           <div class="row">
                <div class="col-md-6">
                    <label for="">Archivo</label>
                    <input type="file" name="file" class="form-control">
                </div>
                <div class="col-md-6">
                   <label for="">Categoria</label>
                    <select name="categoria_id" class="form-control">
                        <option value="">Seleccione</option>
                      @foreach ($categorias as $item)
                          <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                      @endforeach
                    </select>
                </div>
           </div>
            <br>
            <button class="btn btn-success">Importar Datos</button>

        </form>
    </div>
</div>

@if (session()->has('message'))
        <script>
            mensaje("{{ session('message') }}")
        </script>
    @endif

@endsection




