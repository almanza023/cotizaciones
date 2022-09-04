<div>
    @if (session()->has('message'))
    <script>
        mensaje("{{ session('message') }}")
    </script>
    @endif
    @if (session()->has('advertencia'))
    <script>
        advertencia("{{ session('advertencia') }}")
    </script>
    @endif
   @if(!empty($data))
   <div class="card">
    <div class="card-header with-border ">
      <h4 class="card-title">DATOS DE ENTREGA</h4>
    </div>
    <!-- /.box-header -->
    <div class="card-body">
     <div class="row">
        <div class="col">

            <table class="table table-hover table-responsive">
                <tr>
                    <th colspan="4"><center>DATOS DE ENTREGA</center></th>
                </tr>
                <tr>
                    <th>NÚMERO ENTREGA</th>
                    <th>CONTACTO</th>
                    <th>FECHA</th>
                </tr>
                <tr>
                    <td>{{ $data->codigo }}</td>
                    <td>{{ $data->numero }}</td>
                    <td>{{ $data->fecha }}</td>
                </tr>

            </table>
            <br>
            <table class="table table-hover table-responsive">
                <tr>
                    <th colspan="7">DETALLES DE ENTREGA</th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>NOMBRE</th>
                    <th>CANTIDAD</th>
                </tr>
                @forelse ($detalles as $item)
                <tr>
                    <td width="10">{{ $loop->iteration }}</td>
                    <td>{{ $item->pieza->nombre }}</td>
                    <td>{{ $item->cantidad }}</td>
                </tr>
                @empty
                    <tr>
                        <td colspan="3">No existen datos</td>
                    </tr>
                @endforelse
            </table>




            <a href="{{ route('proyectos.opciones', $proyecto_id) }}" class="btn btn-primary btn-block">Aceptar</a>

            </table>
        </div>
     </div>
    </div>
   </div>
   @endif
</div>
