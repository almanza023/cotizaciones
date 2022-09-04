<div wire:ignore.self class="modal fade" id="modalConfirmar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CONFIRMAR OPERACIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <table class="table table-responsive">
                            <tr>
                                <th>CATEGORIA</th>
                                <th>SUBTOTAL</th>
                                <th>IVA</th>
                                <th>TOTAL</th>
                            </tr>
                            @if ($totales_cot['subcat1'] > 0)
                            <tr>
                                <td>{{ $totales_cot['nomcat1'] }}</td>
                                <td>$ {{ number_format($totales_cot['subcat1']) }}</td>
                                <td>$ {{ number_format($totales_cot['ivacat1']) }}</td>
                                <td>$ {{ number_format($totales_cot['totcat1']) }}</td>
                            </tr>
                            @endif

                            @if ($totales_cot['subcat2'] > 0)
                            <tr>
                                <td>{{ $totales_cot['nomcat2'] }}</td>
                                <td>{{ number_format($totales_cot['subcat2']) }}</td>
                                <td>{{ number_format($totales_cot['ivacat2']) }}</td>
                                <td>{{ number_format($totales_cot['totcat2']) }}</td>
                            </tr>
                            @endif
                            @if ($totales_cot['subcat3'] > 0)

                            <tr>
                                <td>{{ $totales_cot['nomcat3']  }}</td>
                                <td>$ {{ number_format($totales_cot['subcat3']) }}</td>
                                <td>$ {{ number_format($totales_cot['ivacat3']) }}</td>
                                <td>$ {{ number_format($totales_cot['totcat3']) }}</td>
                            </tr>
                            @endif
                            @if ($totales_cot['subcat4'] > 0)
                            <tr>
                                <td>{{ $totales_cot['nomcat4'] }}</td>
                                <td>$ {{ number_format($totales_cot['subcat4']) }}</td>
                                <td>$ {{ number_format($totales_cot['ivacat4']) }}</td>
                                <td>$ {{ number_format($totales_cot['totcat4']) }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th colspan="4">TOTALES</th>
                            </tr>
                            <tr>
                                <th>SUBTOTAL1</th>
                                <th>SUBTOTAL2</th>
                                <th>IVA</th>
                            </tr>
                            <tr>
                                <td>$ {{ number_format($totales_cot['subtotal1']) }}</td>
                                <td>$ {{ number_format($totales_cot['subtotal2']) }}</td>
                                <td>$ {{ number_format($totales_cot['iva']) }}</td>
                            </tr>
                            <tr>
                                <th colspan="4">TOTAL COTIZACION</th>
                            </tr>
                            <tr>
                                <th colspan="4">$ {{ number_format($totales_cot['total']) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="finalizar"  class="btn btn-primary" ><i class="fa fa-check"></i> ACEPTAR</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> CERRAR</button>
            </div>
       </div>
    </div>
</div>
