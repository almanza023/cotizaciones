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
        <div class="card-header with-border">
          <h4 class="card-title">ENTREGA EXTRA</h4>
          <h6 class="card-subtitle">Ingrese todos los datos</h6>
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
                        <th>NÚMERO DE ENTREGA </th>
                        <td>{{ $numero }}</td>
                    </tr>
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
                    <tr>
                        <th>FECHA ULTIMA ENTREGA </th>
                        <td>{{ $fechaUtlima }}</td>
                    </tr>
                    <tr>
                        <th>FECHA</th>
                        <td>
                            <input type="date" class="form-control" wire:model="fecha">
                            @error('fecha') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>

                    </tr>
                    <tr>
                        <th>N° DIAS </th>
                        <td>{{ $dias }}</td>
                    </tr>
                    <th>PROYECTO</th>
                        <td>
                            {{ $proyecto->nombre }}
                        </td>
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


                </table>
                @if ($registrado)
                <button type="button" data-toggle="modal" data-target="#modalCreate" class="btn btn-info btn-block">Agregar Piezas</button>
                @else
                <button type="button" class="btn btn-success btn-block" wire:click="store">Entregar </button>
                @endif

    @if(!empty($detalles))
    <br>
      <div class="card" >
        <div class="card-header with-border">
          <h4 class="card-title">PIEZAS</h4>
        </div>
        <!-- /.box-header -->
        <div class="card-body no-padding">
            <div class="table-responsive">
              <table class="table table-hover">
               <tr class="bg-warning">
                   <th colspan="7"><center>DETALLES PIEZAS AGREGADAS</center></th>
               </tr>
              @if($categoria_id <= 2)
              <tr>
                <th>#</th>
                <th>NOMBRE</th>
                <th>CANTIDAD</th>
                <th>PESO KG</th>
              </tr>
              @else
              <tr>
                <th>#</th>
                <th>NOMBRE</th>
                <th>CANTIDAD</th>
                <th>PRECIO</th>
                <th>SUBTOTAL</th>
              </tr>
              @endif

              @foreach ($detalles as $item)
                 <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $item->pieza->nombre }}</td>
                    <td>{{ $item->cantidad }}</td>
                    @if($categoria_id <= 2)
                    <td>{{ $item->pieza->peso }}</td>
                    @else
                    <td>${{ number_format($item->pieza->precio) }}</td>
                    <td>${{ number_format($item->pieza->precio * $item->cantidad) }}</td>
                    @endif
                    <td>
                        <button type="button" wire:click="quitar({{ $item->id }})" class="btn btn-danger">Quitar</button>
                    </td>
                </tr>

              @endforeach
             <tr>
                    <th>CANTIDAD DE PIEZAS</th>
                    <td>{{ $canpiezas }}</td>
                </tr>

              </table>
              <div wire:loading>
                Procesando...
            </div>
              <div class="form-group" wire:loading.remove>

            </div>

           <tr>
            <td colspan="4">
                <button type="button" wire:click="finalizar" class="btn btn-success btn-block">Finalizar Entrega</a>
            </td>
             </tr>

            </table>
            </div>
        </div>
        <!-- /.box-body -->
      </div>
      @endif


            </div>
          </div>
        </div>
    </div>
    @include('livewire.entregas.buscar-piezas')
</div>
