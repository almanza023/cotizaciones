<div wire:ignore.self id="modalCreate1" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <h5 class="modal-title" id="exampleModalform">DETALLES ANDAMIOS</h5>
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
                        <table class="table table-hover">
                            <tr>
                                <th>Nombre</th>
                                <th>Piezas</th>
                                <th>Peso</th>
                                <th>Cantidad</th>
                            </tr>
                            @foreach ($andamios as $item)
                                <tr>
                                    <td>{{ $item->nombre }}</td>
                                    <td>{{ $item->piezas }}</td>
                                    <td>{{ $item->peso }}</td>
                                    <td>
                                        <input type="number" class="form-control" wire:model.defer="cantidad">
                                    </td>
                                    <td>
                                        <button type="button" wire:click="add({{ $item->id }}, {{ $item->peso }})" class="btn btn-info">Seleccionar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $andamios->links() !!}
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




