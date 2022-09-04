<div wire:ignore.self id="modalOpciones" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <h5 class="modal-title" id="exampleModalform">OPCIONES</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                   <table class="table table-hover">
                        <tr>
                            <th>Fecha Inicio</th>
                            <th>Fecha Final</th>
                        </tr>
                        <tr>
                            <td>
                                <input type="date" wire:model.defer="fecha1" class="form-control">
                                @error('fecha1') <span class="text-danger error">{{ $message }}</span>@enderror
                            </td>
                            <td>
                                <input type="date" wire:model.defer="fecha2" class="form-control">
                                @error('fecha2') <span class="text-danger error">{{ $message }}</span>@enderror
                            </td>
                            <td>
                                <button type="button" wire:click="consultar({{ $proyecto_id }})" class="btn btn-info btn-sm">Consultar</button>
                            </td>
                        </tr>
                   </table>

                  @if(!empty($detalles))
                  <table class="table table-responsive">
                    <tr>
                        <th>Fecha Factura</th>
                        <th>Periodo facturado</th>
                    </tr>

                    @foreach ($detalles as $item)
                        <tr>
                            <td>{{ $item->fecha_gen }}</td>
                            <td>{{ $item->fecha1.'-'.$item->fecha2 }}</td>
                            <td>
                                <a href="{{ route('facturas.imprimir', $item->id) }}" class="btn btn-success">Imprimir</a>
                            </td>
                        </tr>
                    @endforeach

               </table>
                  @endif
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




