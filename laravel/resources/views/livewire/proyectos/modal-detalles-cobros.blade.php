<div wire:ignore.self id="modalCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <h5 class="modal-title" id="exampleModalform">DETALLES DE COBRO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th>Pieza</th>
                                <th>N° Días</th>
                                <th>Cantidad</th>
                                <th>Peso (Kg)</th>
                                <th>Peso Día</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                            </tr>
                            @foreach ($detalles as $item)
                                <tr>
                                    <td>{{ $item->pieza->nombre }}</td>
                                    <td>{{ $item->dias }}</td>
                                    <td>{{ $item->cantidad }}</td>
                                    <td>{{ $item->peso }}</td>
                                    <td>{{ $item->pesodia }}</td>
                                    <td>{{ $item->fecha1 }}</td>
                                    <td>{{ $item->fecha2 }}</td>
                                </tr>
                            @endforeach
                        </table>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>






