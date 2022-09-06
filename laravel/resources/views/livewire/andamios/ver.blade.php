<div wire:ignore.self id="modalVer" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <h5 class="modal-title" id="exampleModalform">DETALLE DE ANDAMIOS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>PIEZA</th>
                            <th>CANTIDAD</th>
                            <th>PESO UNIDAD</th>
                            <th>PESO TOTAL</th>
                        </tr>

                        @foreach ($detalles as $item)
                            <tr>
                                <td>{{ $item->pieza->nombre }}</td>
                                <td>{{ $item->cantidad }}</td>
                                <td>{{ $item->peso }}</td>
                                <td>{{ $item->peso_total }}</td>
                            </tr>
                        @endforeach

                    </table>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-raised btn-danger ml-2" data-dismiss="modal"><i class="mdi mdi-close-octagon
                    "></i> CANCELAR</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




