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
          <h4 class="card-title">MODULO DE EMPRESA</h4>
        </div>
        <!-- /.box-header -->
        <div class="card-body">
          <div class="row">
            <div class="col">
                <table class="table table-hover table-responsive">
                    <tr>
                        <th colspan="4"><center>INFORMACIÓN DE EMPRESA</center></th>
                    </tr>
                    <tr>
                        <th>NOMBRE</th>
                        <td>
                            <input type="text" class="form-control" wire:model.defer="nombre">
                            @error('nombre') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                    <tr>
                        <th>NIT</th>
                        <td>
                            <input type="text" class="form-control" wire:model.defer="nit">
                            @error('nit') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                    </tr>

                    <tr>
                        <th>CORREO</th>
                        <td>
                            <input type="email" class="form-control" wire:model.defer="correo">
                            @error('correo') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                    </tr>

                    <tr>
                        <th>TELEFONO</th>
                        <td>
                            <input type="number" class="form-control" wire:model.defer="telefono">
                            @error('telefono') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                    </tr>

                    <tr>
                        <th>DIRECCION</th>
                        <td>
                            <input type="text" class="form-control" wire:model.defer="direccion">
                            @error('direccion') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                    </tr>

                    <tr>
                        <th>PORCENTAJE IVA</th>
                        <td>
                            <input type="number" class="form-control" wire:model.defer="porcentaje_iva">
                            @error('porcentaje_iva') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                    </tr>

                    <div class="form-group" wire:loading.remove>
                </table>
                <button type="button" wire:click="store" class="btn btn-info btn-block">ACTUALIZAR </button>
            </div>
          </div>
        </div>
    </div>

</div>
