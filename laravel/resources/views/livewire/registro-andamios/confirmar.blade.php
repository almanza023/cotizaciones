<div wire:ignore.self class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CONFIRMAR OPERACIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
               @if(!empty($data))
               <P>¿Está seguro de Anular el Registro del ID: <b>{{ $data->id_focalizacion }}</b> ?</P>
               @endif
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="update"  class="btn btn-primary" ><i class="fa fa-check"></i> ACEPTAR</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> CERRAR</button>
            </div>
       </div>
    </div>
</div>
