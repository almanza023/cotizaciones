<div>
    @include('theme.alertas')
    <!-- Basic Forms -->
    <div class="card">
      <div class="card-header with-border">
        <h4 class="card-title">DETALLES DE COBRO</h4>
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
                            <input type="date" wire:model.defer="fecha1" class="form-control">
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
    @if(count($matriz)>0)
    <div class="card">
        <div class="card-header with-border bg-info">
          <h4 class="card-title ">DETALLES </h4>
        </div>
        <!-- /.box-header -->
        <div class="card-body">
          <div class="row">
            <div class="col">
                  <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>
                                Cantidad Días a cobrar
                            </th>
                            <td>
                                {{ $dias }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 8%">N°</td>
                            <th>Pieza</th>
                            <th>Fecha Entrega</th>
                            <th>Cantidad</th>
                        </tr>

                        @foreach ($matriz as $item)

                            <tr>
                                <th style="width: 8%">{{ $loop->iteration }}</th>
                                <td>{{ $item->pieza->nombre }}</td>
                                <td>{{ $item->fecha }}</td>
                                <td>{{ $item->restante }}</td>
                            </tr>

                        @endforeach
                        <tr>
                            <th colspan="2">TOTAL DE PIEZAS</th>
                            <th>{{ $total }}</th>
                        </tr>
                    </table>



                        <br>

                    <button type="button" class="btn btn-success btn-block" wire:click="guardar">Guardar</button>

                  </div>

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
      <br>

    @endif
</div>
