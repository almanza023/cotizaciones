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
   @if(!empty($data))
   <div class="card">
    <div class="card-header with-border ">
      <h4 class="card-title">DATOS DE COTIZACIÓN</h4>
    </div>
    <!-- /.box-header -->
    <div class="card-body">
     <div class="row">
        <div class="col">
            <table class="table table-hover table-responsive">
                <tr>
                    <th colspan="3">FECHA</th>
                    <th colspan="2">
                        <input type="date" class="form-control" wire:model="fecha">
                        @error('fecha') <span class="text-danger error">{{ $message }}</span>@enderror
                    </th>
                </tr>
                <tr>
                    <th colspan="4"><center>DATOS DE CLIENTE</center></th>
                </tr>
                <tr>
                    <th>CLIENTE</th>
                    <th>CONTACTO</th>
                    <th>TELEFONO</th>
                    <th>CORREO</th>
                </tr>
                <tr>
                    <td>{{ $data->cliente->nombre }}</td>
                    <td>
                        <input type="text" class="form-control" wire:model.defer="contacto" value="{{ $contacto }}">
                    </td>
                    <td>{{ $data->telefono }}</td>
                    <td>{{ $data->correo }}</td>
                </tr>
                <tr>
                    <th>PROYECTO</th>
                    <th>FECHA</th>
                    <th>FORMA DE PAGO</th>
                    <th>ESTADO</th>
                </tr>
                <tr>
                    <td>{{ $data->proyecto }}</td>
                    <td>{{ $data->fecha }}</td>
                    <td>{{ $data->forma_pago }}</td>
                   @switch($data->estado)
                       @case(0)
                          <td>ABIERTA</td>
                        @break
                       @case(1)
                       <td>CREADA</td>
                        @break
                        @case(2)
                        <td>APROBADA</td>
                         @break
                         @case(3)
                        <td>RECHAZADA</td>
                         @break
                         <td></td>
                       @default

                   @endswitch
                </tr>
            </table>
            <br>
           @if (count($listadoAndamios) >0)
           <table class="table table-hover table-responsive">
            <tr>
                <th colspan="7">DETALLES ANDAMIOS</th>
            </tr>
            <tr>
                <th>#</th>
                <th>NOMBRE</th>
                <th>CANTIDAD</th>
                <th>PESO</th>
                <th>DÍAS</th>
                <th>SUBTOTAL</th>
                <th>IVA</th>
                <th>TOTAL</th>
            </tr>
            @forelse ($listadoAndamios as $item)
            <tr>
                <td width="10">{{ $loop->iteration }}</td>
                <td>{{ $item->andamio->nombre }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>{{ $item->andamio->peso }}</td>
                <td>{{ $item->andamio->dias }}</td>
                <td>{{ number_format($item->subtotal) }}</td>
                <td>{{ number_format($item->iva) }}</td>
                <td>{{ number_format($item->total) }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="6">No existen datos</td>
                </tr>
            @endforelse
        </table>
           @endif
            <br>
           @if (count($listadoMaterial) > 0)
           <table class="table table-responsive">
            <tr class="">
                <th colspan="7">DETALLES MATERIAL ENCOFRADO</th>
            </tr>
            <tr>
                <td >#</td>
                <th>NOMBRE</th>
                <th>CANTIDAD</th>
                <th>N° DÍAS</th>
                <th>PRECIO</th>
                <th>SUBTOTAL</th>
                <th>IVA</th>
                <th>TOTAL</th>
            </tr>
            @forelse ($listadoMaterial as $item)
            <tr>
                <td width="10">{{ $loop->iteration }}</td>
                <td>{{ $item->pieza->nombre }}</td>
                <td>{{ $item->cantidad }}</th>
                <td> {{ number_format($item->dias) }}</td>
                <td>$ {{ number_format($item->precio) }}</td>
                <td>$ {{ number_format($item->subtotal) }}</td>
                <td>$ {{ number_format($item->iva) }}</td>
                <td>$ {{ number_format($item->total) }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="6">No existen datos</td>
                </tr>
            @endforelse
        </table>
           @endif
            <br>
          @if (count($listadoProductos) > 0)
          <table class="table table-hover table-responsive">
            <tr class="">
                <th colspan="7">DETALLES PRODUCTOS</th>
            </tr>
            <tr>
                <th>#</th>
                <th>NOMBRE</th>
                <th>CANTIDAD</th>
                <th>PRECIO</th>
                <th>SUBTOTAL</th>
                <th>IVA</th>
                <th>TOTAL</th>
            </tr>
            @forelse ($listadoProductos as $item)
            <tr>
                <td width="10">{{ $loop->iteration }}</td>
                <td>{{ $item->pieza->nombre }}</td>
                <td>{{ $item->cantidad }}</th>
                <td>{{ number_format($item->precio) }}</td>
                <td>{{ number_format($item->subtotal) }}</td>
                <td>{{ number_format($item->iva) }}</td>
                <td>{{ number_format($item->total) }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="6">No existen datos</td>
                </tr>
            @endforelse
        </table>
          @endif
            @if (count($listadoServicios) > 0)
            <table class="table table-hover table-responsive">
                <tr class="">
                    <th colspan="7">DETALLES SERVICIOS</th>
                </tr>
                <tr>
                    <td>#</td>
                    <th>NOMBRE</th>
                    <th>CANTIDAD</th>
                    <th>DIAS</th>
                    <th>PRECIO</th>
                    <th>TOTAL</th>
                </tr>
                @forelse ($listadoServicios as $item)
                <tr>
                    <td width="10">{{ $loop->iteration }}</td>
                    <td>{{ $item->pieza->nombre }}</td>
                    <td>{{ $item->cantidad }}</th>
                    <td>{{ ($item->dias) }}</td>
                    <td>{{ number_format($item->precio) }}</td>
                    <td>{{ number_format($item->total) }}</td>
                </tr>
                @empty
                    <tr>
                        <td colspan="6"><center>No existen datos</center></td>
                    </tr>
                @endforelse
            </table>
            @endif
            <table class="table table-hover table-responsive">
                <tr>
                    <th>SUBTOTAL 1</th>
                    <th>SUBTOTAL 2</th>
                    <th>IVA</th>
                </tr>
                <tr>
                    <td>$ {{ number_format($data->subtotal )}}</td>
                    <td>$ {{ number_format($data->subtotal2) }}</td>
                    <td>$ {{ number_format($data->iva) }}</td>
                </tr>
                <tr>
                    <th colspan="2"><center>TOTAL COTIZACIÓN</center></th>
                </tr><tr>
                    <th colspan="2"><center>$ {{ number_format($data->total) }}</center></th>
                </tr>
                <tr>
                    <td colspan="2">
                        <textarea class="form-control"  wire:model.defer="observaciones"></textarea>
                    </td>
                </tr>
                @if ($data->estado==1)
                <tr>
                    <td colspan="2">
                        <button type="button" wire:click="aprobar" class="btn btn-success btn-block">APROBAR</button>
                    </td>
                    <td colspan="2">
                        <button type="button" wire:click="rechazar"  class="btn btn-danger btn-block">RECHAZAR</button>
                    </td>
                </tr>
                @else
                <tr>
                    <td>
                        <a href="{{ route('cotizaciones.listado') }}" class="btn btn-primary btn-block">Aceptar</a>
                    </td>
                </tr>
                @endif
            </table>
        </div>
     </div>
    </div>
   </div>
   @endif
</div>
