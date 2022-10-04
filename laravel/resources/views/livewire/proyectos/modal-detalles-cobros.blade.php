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
                              @if($sel_categoria <= 2)
                              <th>Peso (Kg)</th>
                              <th>Peso Día</th>
                              @else
                              <th>Precio</th>
                              <th>Subtotal</th>
                              <th>Iva</th>
                              <th>Total</th>
                              @endif
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Reposicion de Material</th>
                            </tr>
                            @foreach ($detalles as $item)
                                <tr>
                                    <td>{{ $item->pieza->nombre }}</td>
                                    <td>{{ $item->dias }}</td>
                                    <td>{{ $item->cantidad }}</td>
                                    @if($sel_categoria <= 2)
                                    <td>{{ $item->peso }}</td>
                                    <td>{{ $item->pesodia}}</td>
                                  @else
                                  @if($item->reposicion==0)
                                       <td>$ {{ number_format($item->pieza->precio) }}</td>
                                       @else
                                       <td>$ {{ number_format($item->valor) }}</td>
                                       @endif
                                       <td>$ {{ number_format($item->subtotal) }}</td>
                                       <td>$ {{ number_format($item->iva) }}</td>
                                       <td>$ {{ number_format($item->total) }}</td>
                                  @endif
                                    <td>{{ $item->fecha1 }}</td>
                                    <td>{{ $item->fecha2 }}</td>
                                   @if($item->reposicion==1)
                                   <td>SI</td>
                                   @else
                                   <td>NO</td>
                                   @endif

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






