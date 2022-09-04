<div wire:ignore.self id="modalCreate" class="modal fade bd-example-modal-form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <h5 class="modal-title" id="exampleModalform">DETALLES DE REGISTRO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

               @if(!empty($detalle))
               <div class="table-responsive">
                <table class="table table-hover">

                   @if($detalle->programa=="NO")
                   <tr>
                    <td colspan="4">OBSERACION 1</td>

                </tr>
                <tr>
                    <td colspan="4">
                        <select class="form-control" wire:model="obs1">
                            <option value="">Seleccione</option>
                            @foreach ($observaciones as $item)
                            <option value="{{ $item->descripcion }}">{{ $item->descripcion }}</option>
                            @endforeach
                        </select>
                        @error('obs1') <span class="text-danger error">{{ $message }}</span>@enderror
                    </td>
                </tr>
                @if($visible)
                <tr>
                    <td colspan="4">OBSERVACION 2</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <textarea class="form-control" wire:model.defer="obs2" cols="3" rows="4"></textarea>

                         @error('obs2') <span class="text-danger error">{{ $message }}</span>@enderror
                     </td>
                </tr>
                @endif
                @else
                <tr>
                    <th colspan="4" class="bg-info">DATOS DE ACTUALIZACION <b>{{ $detalle->id_focalizacion }}</b></th>
                </tr>
                <tr>
                    <th>TIPO DOCUMENTO</th>
                    <th>NUMERO DOCUMENTO</th>
                    <th>PRIMER NOMBRE</th>
                    <th>PRIMER APELLIDO</th>
                   </tr>
                   <tr>
                    <td >
                        <select class="form-control" wire:model.defer="tipodocj">
                            <option value="">Seleccione</option>
                            <option value="RC">RC</option>
                            <option value="TI">TI</option>
                            <option value="CC">CC</option>
                            <option value="CE">CE</option>
                            <option value="PA">PA</option>
                            <option value="PEP">PEP</option>
                            <option value="TMF">TMF</option>
                            <option value="VISA">VISA</option>
                        </select>
                        @error('tipodocj') <span class="text-danger error">{{ $message }}</span>@enderror
                    </td>
                    <td>
                        <input type="number" class="form-control" wire:model.defer="numdocj">
                        @error('numdocj') <span class="text-danger error">{{ $message }}</span>@enderror
                    </td>
                       <td>
                           <input type="text" class="form-control" wire:model.defer="primernomj">
                           @error('primernomj') <span class="text-danger error">{{ $message }}</span>@enderror
                       </td>
                       <td>
                        <input type="text" class="form-control" wire:model.defer="primerapej">
                        @error('primerapej') <span class="text-danger error">{{ $message }}</span>@enderror
                    </td>
                    <tr>
                    <th>DIRECCION</th>
                    <th>TELEFONO</th>
                    <th>INTEGRANTES NUCLEO FAMILIA</th>
                    <th>FECHA VINCULACION</th>
                    </tr>
                    <tr>
                    <td>
                        <input type="text" class="form-control" wire:model.defer="direccion">
                        @error('direccion') <span class="text-danger error">{{ $message }}</span>@enderror
                    </td>
                    <td>
                        <input type="number" class="form-control" wire:model.defer="telefono">
                        @error('telefono') <span class="text-danger error">{{ $message }}</span>@enderror
                    </td>
                    <td>
                        <input type="number" class="form-control" wire:model.defer="integrantes">
                        @error('integrantes') <span class="text-danger error">{{ $message }}</span>@enderror
                    </td>
                    <td>
                        <input type="date" class="form-control" wire:model.defer="fechavin">
                        @error('fechavin') <span class="text-danger error">{{ $message }}</span>@enderror
                    </td>
                   </tr>
                   @endif
                   <tr>
                    <td>PROFESIONAL</td>
                </tr>
                <tr>
                    <th colspan="4">{{ $detalle->profesional }}</th>
                </tr>
                </table>
            </div>
               @endif

            </div>
            <div class="modal-footer">
                <button type="button" wire:click="update" class="btn btn-raised btn-success ml-2"><i class="mdi mdi-content-save-all">
                </i> ACTUALIZAR</button>
                <button type="button" class="btn btn-raised btn-danger ml-2" data-dismiss="modal"><i class="mdi mdi-close-octagon
                    "></i> CANCELAR</button>
            </div>
        </div>
    </div>
</div>
