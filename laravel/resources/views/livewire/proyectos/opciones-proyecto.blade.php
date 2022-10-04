<div>
    @include('theme.alertas')
    <div class="card">
     <div class="card-header with-border ">
       <h4 class="card-title">DATOS DE PROYECTO</h4>
     </div>
     <!-- /.box-header -->
     <div class="card-body">
      <div class="row">
         <div class="col">
             <br>
                 <table class="table table-hover table-responsive">
                     <tr>
                         <th colspan="7">DETALLES DE COBRO</th>
                     </tr>
                     <tr>
                         <th>NOMBRE</th>
                        <td>{{ $data->nombre }}</td>
                     </tr>
                      <tr>
                         <th>CLIENTE</th>
                        <td>{{ $data->cotizacion->cliente->nombre }}</td>
                     </tr>
                     <tr>
                        <th>FECHA CREACIÓN</th>
                       <td>{{ $data->fecha }}</td>
                    </tr>
                    <tr>
                        <th>FECHA ULTIMA MODIFICACION</th>
                       <td>{{ $data->ultima_fecha }}</td>
                    </tr>
                    <tr>
                        <td>
                            <a class="btn btn-info btn-sm" href="{{ route('entregas.generar', $this->proyecto_id) }}">Nueva Entrega</a>
                            <a class="btn btn-info btn-sm" href="{{ route('devoluciones.registro', $this->proyecto_id) }}">Devolución</a>
                            <a class="btn btn-info btn-sm" href="{{ route('devoluciones.ver', $this->proyecto_id) }}">Detalles Devolucón</a>
                            <a class="btn btn-info btn-sm" href="{{ route('proyectos.servicios', $this->proyecto_id) }}">Agregar Servicios</a>
                        </td>
                        <td>
                            <a href="{{ route('entregas', $this->proyecto_id) }}" class="btn btn-primary btn-sm">Ver Entregas</a>
                            <a href="{{ route('cobros.ver', $this->proyecto_id) }}" class="btn btn-info btn-sm">Ver Cobros</a>
                            <a href="{{ route('proyectos.ver-entrega', $this->proyecto_id) }}" class="btn btn-info btn-sm">Piezas en Terreno</a>


                            <a href="{{ route('cobros.registro', $this->proyecto_id) }}" class="btn btn-warning btn-sm">Cobrar</a>
                            <a href="{{ route('facturas.generar', $this->proyecto_id) }}" class="btn btn-success btn-sm">Generar Factura</a>
                            <button type="button" class="btn btn-raised btn-primary" data-toggle="modal" data-target="#modalOpciones">Imprimir </button>

                      </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="{{ route('soportes', $this->proyecto_id) }}" class="btn btn-primary btn-sm">Soportes</a>
                            <a href="{{ route('liquidaciones.registro', $this->proyecto_id) }}" class="btn btn-success btn-sm">Cerrar Proyecto</a>

                        </td>
                    </tr>
                 </table>
         </div>
      </div>
     </div>
    </div>
    @include('livewire.proyectos.modal-opciones')
 </div>
