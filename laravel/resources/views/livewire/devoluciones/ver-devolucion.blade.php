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
      <h4 class="card-title">DATOS DE DEVOLUCION</h4>
    </div>
    <!-- /.box-header -->
    <div class="card-body">
     <div class="row">
        <div class="col">

            <br>
            <table class="table table-hover table-responsive" id="table">
                <tr>
                    <th colspan="7">DETALLES DE DEVOLUCION</th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>NOMBRE</th>
                    <th>CANTIDAD DEVUELTA</th>
                    <th>FECHA DEVOLUCION</th>
                </tr>
                @forelse ($data as $item)
                <tr>
                    <td width="10">{{ $loop->iteration }}</td>
                    <td>{{ $item->pieza->nombre }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ $item->fecha }}</td>
                </tr>
                @empty
                    <tr>
                        <td colspan="4">No existen datos</td>
                    </tr>
                @endforelse
            </table>




            <a href="{{ route('proyectos') }}" class="btn btn-primary btn-block">Aceptar</a>

            </table>
        </div>
     </div>
    </div>
   </div>
   @endif
</div>
