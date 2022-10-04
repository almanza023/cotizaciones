<div>
    @include('theme.alertas')
    @include('livewire.proyectos.modal-detalles-cobros')
    <!-- Basic Forms -->
    <div class="card">
      <div class="card-header with-border">
        <h4 class="card-title">DETALLES DE FACTURA</h4>
        <h6 class="card-subtitle">Ingrese todos los datos</h6>
      </div>
      <!-- /.box-header -->
      <div class="card-body">
        <div class="row">
          <div class="col">
                <div class="table-responsive">
                  <table class="table table-hover">
                      <tr>
                            <th>Categoria</th>
                          <th>Fecha Inicial</th>
                          <th>Fecha Final</th>
                      </tr>
                    <tr>
                        <td>
                            <select class="form-control" wire:model="categoria_id">
                                <option value="">Seleccione</option>
                                @foreach ($categorias as $item)
                                <option value="{{ $item->categoria_id }}">{{ $item->categoria->nombre }}</option>
                                @endforeach
                                @error('categoria_id') <span class="text-danger error">{{ $message }}</span>@enderror
                            </select>
                    </td>
                        <td>
                            <input type="date" wire:model="fecha1" class="form-control">
                              @error('fecha1') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                        <td>
                            <input type="date" wire:model="fecha2" class="form-control">
                              @error('fecha2') <span class="text-danger error">{{ $message }}</span>@enderror
                        </td>
                         <td>
                            <button type="button" wire:click="consultar()" class="btn btn-info">Consultar</button>
                        </td>
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
    @if(!empty($data))
    <div class="card">
        <div class="card-header with-border">
          <h4 class="card-title">RESULTADO</h4>
        </div>
        <!-- /.box-header -->
        <div class="card-body">
          <div class="row">
            <div class="col">
                @forelse ($data as $item)
                <table class="table table-hover table-responsive">
                    @if ($item->categoria_id <= 2)
                    <tr class="bg-warning">
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
                    <tr class="bg-warning">
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

                @if($categoria_id <=2 )
                <table class="table table-hover">
                    <tr>
                        <th>VALOR KG</th>
                        <td>
                           <input type="number" class="form-control" wire:model="valor">
                        </td>
                    </tr>
                    <tr>
                        <th>TOTAL PESO KG</th>
                        <td>
                            {{ number_format($pesototal, 0) }}
                        </td>
                    </tr>
                    <tr>
                        <th>SUBTOTAL</th>
                        <td>
                            {{ number_format($subtotal, 0) }}
                        </td>
                    </tr>
                    <tr>
                        <th>IVA</th>
                        <td>
                            {{ number_format($iva, 0) }}
                        </td>
                    </tr>
                    <tr>
                        <th>TOTAL</th>
                        <td>
                            {{ number_format($total,0) }}
                        </td>
                    </tr>
                </table>
                <table class="table">
                    <tr>
                        <td>
                            <button type="button" data-toggle="modal" data-target="#modalConfirmar"
                            class="form-control btn btn-success btn-block">REGISTRAR FACTURA
                            </button>
                        </td>
                    </tr>
                </table>
                @else
                <table class="table">
                    <tr>
                        <td>
                            <button type="button" data-toggle="modal" data-target="#modalConfirmar"
                            class="form-control btn btn-success btn-block">REGISTRAR FACTURA
                            </button>
                        </td>
                    </tr>
                </table>
                @endif


            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
      <br>

    @endif
    @include('livewire.facturas.confirmar')
</div>
