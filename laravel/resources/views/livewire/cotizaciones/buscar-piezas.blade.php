<div wire:ignore.self id="modalPiezas" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <h5 class="modal-title" id="exampleModalform">DETALLES PIEZA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-1" class="control-label">Buscar</label>
                            <input type="text" wire:model="search" class="form-control"  required>
                            @error('search') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        @if ($categoria_id<4)
                        <table class="table table-hover">
                            <tr>
                                <th>Nombre</th>
                                <th>Disponibles</th>
                                <th>Peso Kg</th>
                                @if ($categoria_id>1)
                                   <th>Precio</th>
                                @endif
                                <th>Cantidad</th>
                                @if($categoria_id==3 || $categoria_id==4)
                                    <th>N° Días</th>
                                @endif
                            </tr>
                            @foreach ($piezas as $item)
                                <tr>
                                    <td>{{ $item->nombre }}</td>
                                    <td>{{ $item->cantidad }}</td>
                                    <td>{{ $item->peso }}</td>
                                    <td>$ {{ number_format($item->precio) }}</td>
                                    <td>
                                        <input type="number" class="form-control" wire:model.defer="cantidad">
                                    </td>
                                    @if($categoria_id==3 || $categoria_id==4)
                                    <td>
                                        <input type="number" class="form-control" wire:model.defer="dias3">
                                    </td>
                                     @endif
                                    @if($item->cantidad>0)
                                    <td>
                                        <button type="button" wire:click="add({{ $item->id }})" class="btn btn-info">+</button>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                        @else
                        <table class="table table-hover">
                            <tr>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Valor</th>
                                <th>N° Días</th>
                                <th>Total</th>
                            </tr>
                            @foreach ($piezas as $item)
                                <tr>
                                    <td>{{ $item->nombre }}</td>
                                    <td>
                                        <input type="number" class="form-control" wire:model.defer="cantidad2">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" wire:model.defer="valor2">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" wire:model.defer="dias2">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" wire:model.defer="total2" readonly>
                                    </td>
                                    <td>
                                        <button type="button" wire:click="add2({{ $item->id }})" class="btn btn-info">Agregar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        @endif
                      </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




