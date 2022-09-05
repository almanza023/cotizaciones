<div>
    @if (session()->has('message'))
    <script>
        mensaje("{{ session('message') }}")
    </script>
    @endif
    @if (session()->has('advertencia'))
    <script>
        advertencia("{{ session('advertencia') }}")
    </script>
    @endif

   <div class="card">
    <div class="card-header with-border ">
      <h4 class="card-title">DATOS DE ENTREGA PROYECTO</h4>
    </div>
    <!-- /.box-header -->
    <div class="card-body">
     <div class="row">
        <div class="col">
            <table class="table table-hover table-responsive" id="table">
                <tr>
                    <th>CATEGORIA</th>
                        <td>
                            <select class="form-control" wire:model="categoria_id">
                                <option value="">Seleccione</option>
                                @foreach ($categorias as $item)
                                <option value="{{ $item->categoria_id }}">{{ $item->categoria->nombre }}</option>
                                @endforeach
                                @error('categoria_id') <span class="text-danger error">{{ $message }}</span>@enderror
                            </select>
                    </td>
                </tr>
            </table>
           @if(!empty($detalles))
           <button onclick="htmlExcel('tblData', 'Reporte_Puntos_Canjeados')">Exportar reporte</button>
           <table class="table table-hover table-responsive" id="tblData">
            <tr>
                <th colspan="7">DETALLES DE ENTREGA</th>
            </tr>

            <tr>
                <th>#</th>
                <th>NOMBRE</th>
                <th>CANTIDAD</th>
                <th>FECHA ENTREGA</th>
            </tr>

            @forelse ($detalles as $item)
            <tr>
                <td width="10">{{ $loop->iteration }}</td>
                <td>{{ $item->pieza->nombre }}</td>
                <td>{{ $item->restante }}</td>
                <td>{{ $item->fecha }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="3">No existen datos</td>
                </tr>
            @endforelse
            <tr>
                <th colspan="2">TOTAL DE PEIZAS</th>
                <th>{{ $total }}</th>
            </tr>
        </table>
        <a href="{{ route('proyectos') }}" class="btn btn-primary btn-block">Aceptar</a>

        </table>
           @endif
        </div>
     </div>
    </div>
   </div>




</div>
