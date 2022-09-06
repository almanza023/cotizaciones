<div wire:ignore.self id="modalCreados" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <h5 class="modal-title" id="exampleModalform">ANDAMIOS EN SISTEMA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-1" class="control-label">Buscar</label>
                            <input type="text" wire:model="search2" class="form-control"  required>
                            @error('search') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                @if(count($list_andamios)>0)
                <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th>Nombre</th>
                                <th>Cantidad de Piezas</th>
                                <th>Peso Kg</th>
                                <th>N° Días</th>
                                <th>Cantidad</th>
                                <th>Precio Kg</th>
                            </tr>
                            @foreach ($list_andamios as $item)
                                <tr>
                                    <td>{{ $item->nombre }}</td>
                                    <td>{{ $item->piezas }}</td>
                                    <td>{{ $item->peso }}</td>
                                    <td>
                                        <input type="number" min="1" class="form-control" wire:model.defer="dias">
                                    </td>
                                    <td>
                                        <input type="number" min="1" class="form-control" wire:model.defer="cantidad">
                                    </td>
                                    <td>
                                        <input type="number" min="1" class="form-control" wire:model.defer="precio">
                                    </td>
                                    <td>
                                        <button type="button" wire:click="addAndamio({{ $item->id }}, {{ $item->peso }})" class="btn btn-success">+</button>
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                        {{ $list_andamios->links() }}
                      </div>
                    </div>
                </div>
                @endif


            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




