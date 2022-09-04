<div wire:ignore.self id="modalCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <h5 class="modal-title" id="exampleModalform">DATOS DE CATEGORIA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-1" class="control-label">Nombre (*)</label>
                            <input type="text" wire:model.defer="nombre" class="form-control"  required>
                            @error('nombre') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-1" class="control-label">Descripción</label>
                           <textarea class="form-control" cols="3" rows="2" wire:model.defer="descripcion">

                           </textarea>

                        </div>
                    </div>


                </div>




            </div>
            <div class="modal-footer">
                <button type="button" wire:click="store" class="btn btn-raised btn-primary ml-2"><i class="mdi mdi-content-save-all">
                </i> GUARDAR</button>
                <button type="button" class="btn btn-raised btn-danger ml-2" data-dismiss="modal"><i class="mdi mdi-close-octagon
                    "></i> CANCELAR</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




