<div>
    <div class="card">
        <div class="card-header with-border">
          <h4 class="card-title">ENTREGA SERVICIO</h4>
          <h6 class="card-subtitle">Ingrese todos los datos</h6>
        </div>
        <!-- /.box-header -->
        <div class="card-body">
          <div class="row">
            <div class="col">
                <table class="table table-hover table-responsive">
                    <tr>
                        <th colspan="4"><center>INFORMACIÓN DE PROYECTO</center></th>
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
                            {{ $proyecto->nombre }}
                        </td>
                    </tr>
                </table>

                <button type="button" data-toggle="modal" data-target="#modalCreate" class="btn btn-info btn-block">Agregar </button>


    @if(!empty($detalles))
      <div class="card" >
        <div class="card-header with-border">
          <h4 class="card-title">PIEZAS</h4>
        </div>
        <!-- /.box-header -->
        <div class="card-body no-padding">
            <div class="table-responsive">
              <table class="table table-hover">
               <tr class="bg-warning">
                   <th colspan="7"><center>DETALLES SERVICIOS AGREGADOS</center></th>
               </tr>
               <tr>
                <th>#</th>
                <th>NOMBRE</th>
                <th>CANTIDAD</th>
                <th>DIAS</th>
                <th>PRECIO</th>
                <th>TOTAL</th>
              </tr>

              @foreach ($detalles as $item)
                 <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $item->pieza->nombre }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ $item->dias }}</td>
                    <td>${{ number_format($item->precio) }}</td>
                    <td>${{ number_format($item->total) }}</td>
                    <td>
                        <button type="button" wire:click="quitar({{ $item->id }})" class="btn btn-danger">Quitar</button>
                    </td>
                </tr>

              @endforeach
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
