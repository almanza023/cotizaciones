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
    <!-- Basic Forms -->
    <div class="card">
      <div class="card-header with-border">
        <h4 class="card-title">DETALLES DE COTIZACION</h4>
        <h6 class="card-subtitle">Ingrese todos los datos</h6>
      </div>
      <!-- /.box-header -->
      <div class="card-body">
        <div class="row">
          <div class="col">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tr>

                        <td>Categría</td>
                        @if (!empty($categoria_id) && $categoria_id<=2)
                        <td>Nombre</td>
                        <td>N° Días</td>
                        <td>Cantidad</td>
                        @endif
                    </tr>
                    <tr>
                        <td>
                            <select class="form-control"  wire:model="categoria_id">
                                <option value="">Seleccione</option>
                                @foreach ($categorias as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                             </select>
                              @error('categoria_id') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                       @if (!empty($categoria_id) && $categoria_id<=2)
                    </td>
                       <td>
                        <input type="text" class="form-control" wire:model.defer="nombre">
                        @error('nombre') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                        <td>
                            <input type="number" class="form-control" wire:model.defer="ndias">
                            @error('ndias') <span class="text-danger error">{{ $message }}</span>@enderror
                            </td>
                        <td>
                            <input type="number" class="form-control" wire:model.defer="cantidad_andamio">
                            @error('cantidad_andamio') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                       @endif

                    </tr>
                    <tr>
                        @if (!empty($categoria_id) && $categoria_id>2)
                        <td>
                            <button type="button" data-toggle="modal" data-target="#modalPiezas" class="btn btn-success">Agregar</button>
                        </td>
                        @endif
                        @if (!empty($categoria_id) && $isStore && $categoria_id<=2)
                        <td>
                            <a href="{{ route('cotizacion.detalles', $cotizacion_id) }}" class="btn btn-warning">Nuevo Andamio</a>
                         </td>
                        <td>
                            <button type="button" data-toggle="modal" data-target="#modalPiezas" class="btn btn-success">Agregar Piezas</button>
                        </td>

                        @else
                        @if ($categoria_id<=2 && !empty($categoria_id))
                            <td>
                            <a href="{{ route('cotizacion.detalles', $cotizacion_id) }}" class="btn btn-warning">Nuevo Andamios</a>

                         </td>
                        @endif
                         @if (!empty($categoria_id) && ($categoria_id<=2))
                         <td>
                            <button type="button" wire:click="store()" class="btn btn-info">Agregar Piezas</button>
                         </td>
                         <td>
                            <button type="button" data-toggle="modal" data-target="#modalCreados"  class="btn btn-info">Andamios Creados</button>
                         </td>
                         @endif

                        @endif
                    </tr>
                  </table>
                </div>

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
    </div>
    <br>
    @include('livewire.cotizaciones.modal-creados')
    @include('livewire.cotizaciones.buscar-piezas')

    @include('livewire.cotizaciones.confirmar')
    @if($categoria_id!='')
    @if(!empty($listado_andamios) && $categoria_id<=2)
    @include('livewire.cotizaciones.modal-detalles-piezas')
    <div class="card">
        <div class="card-header with-border">
          <h4 class="card-title">ANDAMIOS AGREGADOS A COTIZACION</h4>
        </div>
        <!-- /.box-header -->
        <div class="card-body">
          <div class="row">
            <div class="col">
                  <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <td>Nombre</td>
                            <td>Cantidad</td>
                            <td>Total de Piezas</td>
                            <td>N° Días</td>
                            <td>Peso Total Kg</td>
                            <td>Peso Total KgxDia</td>
                            <td>Acciones</td>
                        </tr>
                        @php
                            $subta=0;
                            $ivaa=0;
                            $tota=0;
                        @endphp
                        @forelse ($listado_andamios as $item)
                        @if (!empty($item->andamio->nombre))
                        @php
                            $subta+=$item->subtotal;
                            $ivaa+=$item->iva;
                            $tota+=$item->total;
                        @endphp
                           <tr>
                            <td>{{ $item->andamio->nombre }}</td>
                            <td>{{ $item->andamio->cantidad }}</td>
                            <td>{{ $item->andamio->piezas }}</td>
                            <td>{{ $item->andamio->dias }}</td>
                            <td>{{ $item->andamio->peso }}</td>
                            <td>{{ $item->andamio->kgdias }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalDetPiezas" wire:click="verPiezas({{ $item->andamio_id }})">Ver Piezas</button>
                                <button class="btn btn-danger btn-sm" wire:click="quitar({{ $item->id }})">Quitar</button>
                            </td>
                        </tr>
                        @endif
                        @empty
                        @endforelse
                        <tr>
                            <th colspan="2">SUBTOTAL</th>
                            <th colspan="2">IVA</th>
                            <th colspan="2">TOTAL</th>
                        </tr>
                        <tr>
                            <th colspan="2">{{ $subta }}</th>
                            <th colspan="2">{{ $ivaa }}</th>
                            <th colspan="2" >{{ $tota }}</th>
                        </tr>
                    </table>
                  </div>

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>

    @endif
    @endif
    <br>
      @if(!empty($detalles))
      <div class="card" >
        <div class="card-header with-border">
          @if ($categoria_id<=2)
          <h4 class="card-title">PIEZAS DE ANDAMIO</h4>
          @else
          <h4 class="card-title">PRODUCTOS/SERVICIOS</h4>
          @endif
        </div>
        <!-- /.box-header -->
        <div class="card-body no-padding">
            <div class="table-responsive">
              <table class="table table-hover">
               <tr class="bg-warning">
                   <th colspan="8"><center>DETALLES ELEMENTOS AGREGADOS</center></th>
               </tr>
               <tr>
                <th>#</th>
                <th>NOMBRE</th>
                @if ($categoria_id<=2)
                <th>CANTIDAD ANDAMIOS</th>
                @endif
                <th>CANTIDAD</th>
                <th>PESO KG</th>
                <th>PESO TOTAL KG</th>
                @if ($categoria_id>2)
                <th>NUMERO DÍAS</th>
                <th>PRECIO</th>
                <th>SUBTOTAL</th>
                @endif
              </tr>
              @php
              $totalp=0;
              $totalkg=0;
              $nrdias=0;
          @endphp
              @foreach ($detalles as $item)
              @if (!empty($item->andamio->nombre))
                 @php
                 $nrdias=$item->andamio->dias;
                 @endphp
              @endif
              @if (!empty($item->pieza->nombre))
              @php
                  $totalp+=$item->cantidad;
                  $totalkg+=$item->peso_total;
                @endphp

                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $item->pieza->nombre }}</td>
                    @if ($categoria_id<=2)
                    <th>{{ $item->andamio->cantidad }}</th>
                    @endif
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ $item->peso }}</td>
                    <td>{{ $item->peso_total }}</td>
                    @if ($categoria_id>2)
                    <td>{{ $item->dias }}</td>
                    <td>$ {{ number_format($item->precio) }}</td>
                    <td>$ {{ number_format($item->subtotal) }}</td>
                    <td>
                        <button type="button" wire:click="quitar({{ $item->id }})" class="btn btn-danger">Quitar</button>
                    </td>
                    @else
                    <td>
                        <button type="button" wire:click="quitarAndamio({{ $item->id }})" class="btn btn-danger">Eliminar</button>
                    </td>
                    @endif

                </tr>
                @endif

              @endforeach
              @if($categoria_id<=2)
              <tr>
                <th> CANTIDAD DE PIEZAS</th>
                <td>{{ $totalp }}</td>
             </tr>
             <tr>
                 <th> TOTAL KG</th>
                 <td> {{ $totalkg }}</td>
              </tr>

              <tr>
                <th> TOTAL KGxDias</th>
                <td> {{ $totalkg * $nrdias  }}</td>
              </tr>
              @endif
              </table>
              <div wire:loading>
                Procesando...
            </div>
              <div class="form-group" wire:loading.remove>

            </div>
           @if ($categoria_id<=2)
           <tr>
            <td colspan="4">
                <button type="button" wire:click="guardar()" class="btn btn-success btn-block">Guardar Andamio</button>
            </td>
        </tr>
           @endif
            </table>
            </div>
        </div>
        <!-- /.box-body -->
      </div>
      @endif
      <br>
      @if (!empty($categoria_id))
      <div class="card">
        <div class="card-header with-border">
          <h4 class="card-title">ESTADISTICAS</h4>
        </div>
        <!-- /.box-header -->
        <div class="card-body">
          <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>Cantidad de Piezas</th>
                            <th>Total Kg</th>
                           @if ($categoria_id<=2)
                           <th>Total KgxDia</th>
                           @endif
                            <th>Valor Kg</th>
                        </tr>
                        <tr>
                            <td>{{ $canPiezas }}</td>
                            <td>{{ $pesototal }}</td>
                         @if ($categoria_id<=2)
                         <td>{{  $totalkgdia }}</td>
                         <td>
                            <input type="number" class="form-control" wire:model="valor">
                            @error('valor') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                         @endif
                        </tr>
                        <tr>
                            <th>Subtotal</th>
                            <th>Iva</th>
                            <th>Total</th>
                        </tr>
                        <tr>
                            <td>
                                {{  !empty($subtotal) ? number_format($subtotal) : 0 }}
                            </td>
                            <td>
                                {{!empty($iva) ? number_format($iva) : 0 }}
                            </td>
                            <td>
                                {{ !empty($total) ? number_format($total) : 0 }}
                            </td>
                           @if ($categoria_id<=2)
                           <td colspan="2">
                            <button class="btn btn-danger btn-block" wire:click="agregarCot">AGREGAR A COTIZACION</button>
                           </td>
                           @endif
                        </tr>
                        <tr>
                            <td colspan="4">
                                <button type="button" data-toggle="modal" data-target="#modalConfirmar" class="btn btn-success btn-block">Finalizar Cotización</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
          </div>
        </div>
      </div>
      @endif
      <br>
        <!-- /.box -->
        <script >
            window.addEventListener('abrirModal', event => {
                $('#modalPiezas').modal('show');
            })
            window.addEventListener('cerrarModal', event => {
                $('#modalCreados').modal('hide');
            })
        </script>

    <!-- /.box -->
</div>
