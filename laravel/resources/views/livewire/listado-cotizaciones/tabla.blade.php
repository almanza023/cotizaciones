
  <div class="row m-t-30">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">  LISTADO DE COTIZACIONES</h4><br>
                <a href="{{ route('cotizaciones') }}" class="btn btn-raised btn-primary m-t-10 m-b-10" >
                    <i class="typcn typcn-document-add"> </i>CREAR</a>
                    <button data-toggle="modal" data-target="#modalCreate"  class="btn btn-outline-info btn-sm"><i class="typcn typcn-people"></i>CLIENTES</button>
                    <button data-toggle="modal" wire:click="mostrarTodos" class="btn btn-outline-success btn-sm"><i class="typcn typcn-edit"></i>TODOS LOS CLIENTES</button><br><br>

                    <div class="w-full flex pb-10">
                        <div class="w-3/6 mx-1">
                            <input wire:model.debounce.300ms="search" type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"placeholder="Buscar">
                        </div>
                        <div class="w-1/6 relative mx-1">
                            <select wire:model="orderBy" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                <option value="id">ID</option>
                                <option value="nombre">NOMBRE</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                        <div class="w-1/6 relative mx-1">
                            <select wire:model="estado" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                <option value="">Filtrar Estado</option>
                                <option value="1">Abiertas</option>
                                <option value="2">Aprobadas</option>
                                <option value="3">Rechazadas</option>
                                <option value="4">Entregadas</option>

                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                        <div class="w-1/6 relative mx-1">
                            <select wire:model="perPage" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                <option>15</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                    <table class="table mb-0" >
                        <thead>
                            <tr>
                                <th>CLIENTE</th>
                                <th>FECHA ELABORACIÓN</th>
                                <th>FECHA APROBACIÓN</th>
                                <th>CONTACTO</th>
                                <th>PROYECTO</th>
                                <th>FORMA PAGO</th>
                                <th>TOTAL </th>
                                <th>ESTADO </th>
                                <th>ACCIONES</th>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $color='';
                            @endphp
                            @forelse ($data as $item)
                            @if($item->copiado=='SI')
                                @php
                                    $color='#EFFD78';
                                @endphp
                            @else
                            @php
                            $color='';
                                @endphp
                            @endif
                            <tr style="background-color: {{ $color }} " >
                                <td>{{ $item->cliente->nombre }}</td>
                                <td>{{ $item->fecha }}</td>
                                <td>{{ $item->fecha_aprobacion }}</td>
                                <td>{{ $item->contacto }}</td>
                                <td>{{ $item->proyecto }}</td>
                                <td>{{ $item->forma_pago }}</td>
                                <td>{{ number_format($item->total) }}</td>
                                @switch($item->estado)
                                @case(0)
                                   <td>ABIERTA</td>
                                 @break
                                @case(1)
                                <td>CREADA</td>
                                 @break
                                 @case(2)
                                 <td>APROBADA</td>
                                  @break
                                  @case(3)
                                 <td>RECHAZADA</td>
                                 @case(4)
                                 <td>ENTREGADA</td>
                                  @break
                                  <td></td>
                                @default
                            @endswitch
                            @if($item->estado==2)
                                <td>
                                    <a href="{{ route('entregas.registro', $item->id) }}" class="btn btn-success btn-sm">Generar Entrega</a>
                                </td>
                                @else
                                <td></td>
                            @endif
                               <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                     Opciones
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('cotizacion.ver', $item->id) }}">Ver</a>
                                        <a class="dropdown-item" href="{{ route('cotizacion.reporte', $item->id) }}" target="_blank">Imprimir</a>
                                        <a class="dropdown-item" wire:click="duplicar({{ $item->id }})">Duplicar</a>
                                    </div>
                                  </div>
                               </td>
                               @if($item->estado==3)
                               <td>
                                <button data-toggle="modal" data-target="#modalEstado" wire:click="editEstado({{ $item->id }})"  class="btn btn-danger btn-sm"><i class="typcn typcn-edit"></i>Anular</button>
                               </td>
                               @endif
                               @if($item->estado==4)
                               <td>
                                <a href="{{ route('proyectos')}}" class="btn btn-success btn-sm">Ver Proyecto</a>
                               </td>
                               @endif


                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6"><center>No Existen datos</center></td>
                                </tr>
                            @endforelse
                        </tbody>
                        </tbody>
                    </table>
                    {!! $data->links() !!}

            </div>
        </div>
    </div>


</div>
