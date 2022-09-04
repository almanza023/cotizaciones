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
        <h4 class="card-title">CREACIÓN DE ANDAMIOS</h4>
        <h6 class="card-subtitle">Ingrese todos los datos</h6>
      </div>
      <!-- /.box-header -->
      <div class="card-body">
        <div class="row">
          <div class="col">
                <div class="table-responsive">
                  <table class="table table-hover">
                      <tr>
                          <th>CODIGO</th>
                          <td>
                            <input type="text" class="form-control" wire:model.defer="codigo_andamio" wire:keydown.enter="buscar">
                        </td>
                      </tr>
                    <tr>
                        <td>Código</td>
                        <td>Nombre</td>
                        <td>Longitud</td>
                        <td>Descripción</td>
                    </tr>
                    <tr>
                        <td>
                            {{ $codigo }}
                        </td>

                        <td>
                            <input type="text" class="form-control" wire:model.defer="nombre">
                            @error('nombre') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                        <td>
                            <input type="text" class="form-control" wire:model.defer="longitud">
                            @error('longitud') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                        <td>
                            <textarea class="form-control" cols="3" rows="3" wire:model.defer="descripcion"></textarea>
                        </td>
                    </tr>
                    <tr>
                        @if ($isStore)
                        <td>
                            <a href="{{ route('andamios.create') }}" class="btn btn-warning">Nuevo</a>
                         </td>
                        <td>
                            <button type="button" data-toggle="modal" data-target="#modalCreate" class="btn btn-success">Agregar Piezas</button>
                        </td>

                        @else
                        <td>
                            <a href="{{ route('andamios.create') }}" class="btn btn-warning">Nuevo</a>
                         </td>
                       <td>
                        <button type="button" wire:click="store()" class="btn btn-info">Guardar</button>
                       </td>

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
    @include('livewire.registro-andamios.buscar-piezas')
    <br>
      @if(!empty($detalles))
      <div class="card" >
        <div class="card-header with-border">
          <h4 class="card-title">PIEZAS DE ANDAMIO</h4>
        </div>
        <!-- /.box-header -->
        <div class="card-body no-padding">
            <div class="table-responsive">
              <table class="table table-hover">
               <tr class="bg-warning">
                   <th colspan="6"><center>DETALLES PIEZAS AGREGADAS</center></th>
               </tr>
               <tr>
                <th>#</th>
                <th>NOMBRE</th>
                <th>CANTIDAD</th>
                <th>PESO KG</th>
                <th>PESO TOTAL KG</th>
              </tr>
              @php
              $totalp=0;
              $totalkg=0;
          @endphp
              @foreach ($detalles as $item)
              @php
                  $totalp+=1;
                  $totalkg+=$item->peso_total
              @endphp
                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $item->pieza->nombre }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ $item->peso }}</td>
                    <td>{{ $item->peso_total }}</td>
                    <td>
                        <button type="button" wire:click="quitar({{ $item->id }})" class="btn btn-danger">Quitar</button>
                    </td>
                </tr>

              @endforeach
              <tr>
                <th> CANTIDAD DE PIEZAS</th>
                <td>{{ $totalp }}</td>
             </tr>
             <tr>
                 <th> TOTAL KG</th>
                 <td> {{ $totalkg }}</td>
              </tr>
              </table>
              <div wire:loading>
                Procesando...
            </div>
              <div class="form-group" wire:loading.remove>

            </div>
            </table>
            </div>
        </div>
        <!-- /.box-body -->
      </div>

      @endif
        <!-- /.box -->


    <!-- /.box -->
</div>
