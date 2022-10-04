<div wire:ignore.self id="modalDetPiezas" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <h5 class="modal-title" id="exampleModalform">DETALLES DE PIEZAS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                @if(count($detPiezas)>0)
                <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Peso (Kg)</th>
                            </tr>
                            @foreach ($detPiezas as $item)
                                <tr>
                                    <td>{{ $item->pieza->nombre }}</td>
                                    <td>{{ $item->cantidad }}</td>
                                    <td>{{ $item->peso }}</td>
                              </tr>
                            @endforeach
                        </table>
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




