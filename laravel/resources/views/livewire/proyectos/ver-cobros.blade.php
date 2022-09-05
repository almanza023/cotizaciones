<div>
   @include('theme.alertas')
   @include('livewire.proyectos.modal-detalles-cobros')
   <div class="card">
    <div class="card-header with-border ">
      <h4 class="card-title">DATOS DE COBRO</h4>
    </div>
    <!-- /.box-header -->
    <div class="card-body">
     <div class="row">
        <div class="col">
            <br>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th>Categoria</th>
                    </tr>
                  <tr>
                      <td>
                          <select class="form-control" wire:model="categoria_id">
                              <option value="0">Todas las Categorias</option>
                              @foreach ($categorias as $item)
                              <option value="{{ $item->categoria_id }}">{{ $item->categoria->nombre }}</option>
                              @endforeach
                              @error('categoria_id') <span class="text-danger error">{{ $message }}</span>@enderror
                          </select>
                  </td>
                       <td>
                          <button type="button" wire:click="consultar()" class="btn btn-info">Consultar</button>
                      </td>
                  </tr>
                </table>
              </div>

                @forelse ($data as $item)
                <table class="table table-hover table-responsive">
                    @if ($item->categoria_id <= 2)
                    <tr class="bg-info">
                        <th colspan="8">DETALLES DE COBRO N° {{ $loop->iteration }}</th>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>FECHA 1</th>
                        <th>FECHA 2</th>
                        <th>CANTIDAD DE DÍAS</th>
                        <th>CANTIDAD TOTAL</th>
                        <th>PESO TOTAL</th>
                        <th>TOTAL</th>
                        <th>VER DETALLES</th>
                    </tr>
                    @else
                    <tr class="bg-primary">
                        <th colspan="8">DETALLES DE COBRO N° {{ $loop->iteration }}</th>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>FECHA 1</th>
                        <th>FECHA 2</th>
                        <th>CANTIDAD DE DÍAS</th>
                        <th>SUBTOTAL</th>
                        <th>IVA</th>
                        <th>TOTAL</th>
                        <th>VER DETALLES</th>
                    </tr>
                    @endif
                <tr>
                    <td width="10">{{ $loop->iteration }}</td>
                    <td>{{ $item->fecha1 }}</td>
                    <td>{{ $item->fecha2 }}</td>
                    <td>{{ $item->dias }}</td>
                   @if ($item->categoria_id <= 2)
                   <td>{{ $item->cantidadtotal }}</td>
                   <td>{{ $item->pesototal }}</td>
                   <td>{{ $item->pesodiatotal }}</td>
                   @else
                   <td>$ {{ number_format($item->subtotal) }}</td>
                   <td>$ {{ number_format($item->iva) }}</td>
                   <td>$ {{ number_format($item->total) }}</td>

                   @endif
                    <td>
                        <button data-toggle="modal" data-target="#modalCreate" wire:click="ver({{ $item->id }}, {{ $item->categoria_id }})" class="btn btn-outline-info btn-sm"><i class="typcn typcn-edit"></i></button>
                    </td>

                </tr>
                @empty
                    <tr>
                        <td colspan="7">No existen datos</td>
                    </tr>
                </table>
                @endforelse
        </div>
     </div>
    </div>

   </div>



</div>
