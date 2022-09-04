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
        <h4 class="card-title">GENERACIÓN DE COTIZACIONES</h4>
        <h6 class="card-subtitle">Ingrese todos los datos</h6>
      </div>
      <!-- /.box-header -->
      <div class="card-body">
        <div class="row">
          <div class="col">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tr>
                        <td>Número</td>
                        <td>Cliente</td>
                        <td>Documento</td>
                    </tr>
                    <tr>
                        <td>
                           {{ $numero }}
                        </td>
                        <td>
                            {{ $nombre_cliente }}
                        </td>
                        <td>
                            {{ $documento_cliente }}
                        </td>
                        <td>
                            <button type="button" data-toggle="modal" data-target="#modalCreate" class="btn btn-success">Clientes</button>

                        </td>
                    </tr>
                    <tr>
                        <td>Solicitado Por</td>
                        <td>Correo</td>
                        <td>Teléfono</td>
                        <td>Proyecto</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="form-control" wire:model.defer="solicitado">
                            @error('solicitado') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                        <td>
                            <input type="text" class="form-control" wire:model.defer="correo">
                        </td>
                        <td>
                            <input type="number" class="form-control" wire:model.defer="telefono">
                            @error('telefono') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                        <td>
                            <input type="text" class="form-control" wire:model.defer="proyecto">
                            @error('proyecto') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Descripción</td>
                        <td >Fecha</td>
                        <td >Forma de Pago</td>
                    </tr>
                    <tr>
                        <td colspan="2"><textarea wire:model.defer="descripcion" cols="5" rows="2" class="form-control"></textarea>
                            @error('descripcion') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                        <td>
                            <input type="date" class="form-control" wire:model.defer="fecha">
                            @error('fecha') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                        <td>
                           <select class="form-control" wire:model.defer="forma_pago">
                               <option value="">Seleccione</option>
                               <option value="CREDITO">CREDITO</option>
                               <option value="CONTADO">CONTADO</option>
                           </select>
                           @error('forma_pago') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                    </tr>
                  </table>
                </div>
                @if ($isStore)
                <td>
                    <a href="{{ route('cotizaciones') }}" class="btn btn-warning">Nuevo</a>
                 </td>
                <td>
                    <button type="button" data-toggle="modal" data-target="#modalCreate1" class="btn btn-success">Agregar</button>

                </td>

                @else
                <td>
                    <a href="{{ route('cotizaciones') }}" class="btn btn-warning">Nuevo</a>
                 </td>
               <td>
                <button type="button" wire:click="store()" class="btn btn-info">Guardar</button>
               </td>

                @endif
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
    </div>
    @include('livewire.cotizaciones.buscar-cliente')
    <!-- /.box -->
    <!-- /.box -->
</div>
