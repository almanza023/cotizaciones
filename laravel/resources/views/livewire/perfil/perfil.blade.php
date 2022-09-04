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
        <div class="card-body">
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Usuario</label>
                <div class="col-sm-10">
                    <input type="text" readonly  class="form-control" value="{{ auth()->user()->name }}">

                </div>
              </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Nueva Clave</label>
                <div class="col-sm-10">
                    <input type="password" wire:model="clave1" class="form-control" >
                    @error('clave1') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Confirmar Clave</label>
                <div class="col-sm-10">
                  <input type="password" wire:model="clave2" class="form-control" >
                  @error('clave2') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
              </div>
              <div class="form-group row">
                  <button class="btn btn-primary btn-block" wire:click.prevent="update">ACTUALIZAR</button>

              </div>
        </div>
    </div>
</div>
