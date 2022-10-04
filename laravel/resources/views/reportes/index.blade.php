@extends('theme.app')
@section('titulo')
    REPORTES
@endsection
@section('content')
<div class="card">
    <div class="card-header with-border ">
      <h4 class="card-title">FACTURAS POR RANGO DE FECHAS</h4>
    </div>
    <!-- /.box-header -->
    <div class="card-body">
     <div class="row">
        <div class="col">
            <div class="table-responsive">
                <form action="" method="POST">
                    @csrf
                    <table class="table table-hover">
                        <tr>
                            <th>CATEGORIA</th>
                            <th>FECHA INICIAL</th>
                            <th>FECHA FINAL</th>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <select name="categoria_id" class="form-control">
                                    <option value="0">Seleccione</option>
                                    @foreach ($categorias as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="date" name="fecha1" class="form-control" required ></td>
                            <td><input type="date" name="fecha2" class="form-control" required ></td>
                            <td>
                                <button type="submit" class="btn btn-success">GENERAR</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
     </div>
    </div>
</div>

@endsection




