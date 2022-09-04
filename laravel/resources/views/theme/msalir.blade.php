<div wire:ignore.self class="modal fade" id="salirModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CERRAR SESION</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('logout') }}" method="POST">
                @csrf
               <P>¿Está seguro de salir del Aplicativo?</P>
            </div>
            <div class="modal-footer">
                <button type="submit"  class="btn btn-primary" ><i class="fa fa-check"></i> ACEPTAR</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> CERRAR</button>

            </form>
            </div>
       </div>
    </div>
</div>
