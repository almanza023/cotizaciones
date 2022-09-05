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
      <h4 class="card-title">DATOS DE DEVOLUCIONES</h4>
    </div>
    <!-- /.box-header -->
    <div class="card-body">
     <div class="row">
        <div class="col">
            <table class="table table-hover table-responsive">
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
           @if(count($listadoPiezas)>0)
           <table class="table table-hover table-responsive">
            <tr>
                <th colspan="2">FECHA</th>
                <th colspan="2">
                    <input type="date" class="form-control" wire:model="fecha">
                    @error('fecha') <span class="text-danger error">{{ $message }}</span>@enderror
                </th>
            </tr>
            <tr>
                <th colspan="2">FECHA INICIO</th>
                <th colspan="2">
                    {{ $fecha_corte }}
                </th>
            </tr>
            <tr>
                <th colspan="2">N° DIAS</th>
                <th colspan="2">
                    {{ $dias }}
                </th>
            </tr>
            <tr>
                <th colspan="6">DETALLES DE ELEMENTOS ENTREGADOS</th>
            </tr>

            <tr>
                <th>#</th>
                <th>NOMBRE</th>
                <th>CANTIDAD ENTREGADA</th>
                <th >CANTIDAD A DEVOLVER</th>
            </tr>
            @forelse ($listadoPiezas as $key => $item)
            <tr>
                <td width="10">{{ $loop->iteration }}</td>
                <td>{{ $item->pieza->nombre}}</td>
                <td >{{ $item->entregadas }}</td>
                @if($item->entregadas!=0)
                <td >
                    <input class="form-control" wire:model="cantidad1.{{ $key }}.can"  />
                </td>

                @endif
           </tr>
            @empty
                <tr>
                    <td colspan="6">No existen datos</td>
                </tr>
            @endforelse
            <tr>
                <th colspan="2">TOTAL DE PIEZAS</th>
                <th>{{ $total }}</th>
            </tr>
        </table>
        <br>
            <button type="button" class="btn btn-success btn-block" wire:click="store">Guardar Devolución </button>
           @endif

        </div>
     </div>
    </div>
   </div>

</div>
