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
                                <th>SUBTOTAL</th>
                                <th>IVA</th>
                            </tr>
                            @if($categoria_id<=2)
                            <tr>
                                <td>$ {{ number_format($subtotal) }}</td>
                                <td>$ {{ number_format($iva) }}</td>
                            </tr>
                            @else
                            <tr>
                                <td>$ {{ number_format($total_subtotal) }}</td>
                                <td>$ {{ number_format($total_iva) }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th colspan="4">TOTAL A FACTURAR</th>
                            </tr>
                            @if($categoria_id<=2)
                            <tr>
                                <th colspan="4">$ {{ number_format($total) }}</th>
                            </tr>
                            @else
                            <tr>
                                <th colspan="4">$ {{ number_format($total_total) }}</th>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="guardar"  class="btn btn-primary" ><i class="fa fa-check"></i> ACEPTAR</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> CERRAR</button>
            </div>
       </div>
    </div>
</div>
