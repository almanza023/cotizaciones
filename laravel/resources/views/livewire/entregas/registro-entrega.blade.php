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
      <h4 class="card-title">DATOS DE ENTREGA</h4>
    </div>
    <!-- /.box-header -->
    <div class="card-body">
     <div class="row">
        <div class="col">
            <table class="table table-hover table-responsive">
                <tr>
                    <th colspan="4"><center>INFORMACIÓN DE ENTREGA</center></th>
                </tr>
                <tr>
                    <th>Número de Entrega</th>
                    <td>{{ $numero }}</td>
                </tr>
                <tr>
                    <th>CONTACTO </th>
                    <th>DESCRIPCION</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="form-control" wire:model.defer="contacto">
                        @error('contacto') <span class="text-danger error">{{ $message }}</span>@enderror
                    </td>
                    <td>
                        <textarea  class="form-control" wire:model.defer="descripcion"></textarea>
                        @error('descripcion') <span class="text-danger error">{{ $message }}</span>@enderror
                    </td>

                </tr>
                <tr>
                    <th>FECHA</th>
                    <th>PROYECTO</th>
                </tr>
                    <td>
                        <input type="date" class="form-control" wire:model.defer="fecha">
                        @error('fecha') <span class="text-danger error">{{ $message }}</span>@enderror
                    </td>
                    <td>
                        {{ $proyecto }}
                    </td>
                </tr>
            </table>
            <br>
           @if(count($listadoPiezas)>0)
           <table class="table table-hover table-responsive">
            <tr>
                <th colspan="7">DETALLES DE PIEZAS</th>
            </tr>
            <tr>
                <th>#</th>
                <th>CODIGO </th>
                <th>NOMBRE</th>
                <th>CANTIDAD DISPONIBLE</th>
                <th>CANTIDAD SOLICITADAS</th>
            </tr>

            @forelse ($listadoPiezas as $key => $item)
            <tr>
                <td width="10">{{ $loop->iteration }}</td>
                <td>{{ $item->id}}</td>
                <td>{{ $item->nombre}}</td>
                <td>{{ $cantidad1[$key]['disponible'] }}</td>
                <td>
                    <input class="form-control" wire:model="cantidad1.{{ $key }}.can" value="{{$item->total}}" />
                </td>


            </tr>
            @empty
                <tr>
                    <td colspan="6">No existen datos</td>
                </tr>
            @endforelse
            <tr>
                <th colspan="3">TOTAL DE PIEZAS</th>
                <th>{{ $total }}</th>
            </tr>
        </table>
           @endif
            <br>
            @if(count($listadoMaterial)>0)
            <table class="table table-responsive">
                <tr class="">
                    <th colspan="7">DETALLES MATERIAL ENCOFRADO</th>
                </tr>
                <tr>
                    <td >#</td>
                    <th>NOMBRE</th>
                    <th>CANTIDAD SOLICITADAS</th>
                </tr>
                @forelse ($listadoMaterial as $item)
                <tr>
                    <td width="10">{{ $loop->iteration }}</td>
                    <td>{{ $item->pieza->nombre }}</td>
                    <td>{{ $item->cantidad }}</th>
                </tr>
                @empty
                    <tr>
                        <td colspan="6">No existen datos</td>
                    </tr>
                @endforelse
            </table>
            @endif
            <br>
            @if(count($listadoProductos)>0)
            <table class="table table-hover table-responsive">
                <tr class="">
                    <th colspan="7">DETALLES PRODUCTOS</th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>NOMBRE</th>
                    <th>CANTIDAD SOLICITADAS</th>
                </tr>
                @forelse ($listadoProductos as $item)
                <tr>
                    <td width="10">{{ $loop->iteration }}</td>
                    <td>{{ $item->pieza->nombre }}</td>
                    <td>{{ $item->cantidad }}</th>
                </tr>
                @empty
                    <tr>
                        <td colspan="6">No existen datos</td>
                    </tr>
                @endforelse
            </table>
            @endif

            <button type="button" class="btn btn-success btn-block" wire:click="store">Entregar </button>

        </div>
     </div>
    </div>
   </div>

</div>
