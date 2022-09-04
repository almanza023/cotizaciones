
  <div class="row m-t-30">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title"> FOCALIZACIONES</h4><br>

                    <div class="w-full flex pb-10">
                        <div class="w-3/6 mx-1">
                            <input wire:model.debounce.300ms="search" type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"placeholder="Buscar">
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
                   <div class="table-responsive">
                    <table class="table mb-0" >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID FOCALIZACION</th>
                                <th>TIPO ACOMPAÑAMIENTO</th>
                                <th>FUENTE</th>
                                <th>DIRECCION</th>
                                <th>TELEFONOS</th>
                                <th>DOCUMENTO JEFE HOGAR</th>
                                <th>JEFE DEL HOGAR</th>
                                <th>DOCUMENTO BENEFICIARIO</th>
                                <th>BENEFICIARIO</th>
                                <th>ACEPTO PERTENER AL PROGRAMA</th>
                                <th>FECHA VINCULACION</th>
                                <th>PROFESIONAL</th>
                                <th>ESTADO</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                            @php
                                $class='';
                            @endphp

                            <tr>
                                <td >{{ $loop->iteration }}</td>
                                <td >{{ $item->id_focalizacion }}</td>
                                <td>{{ $item->tipoacom }}</td>
                                <td>{{ $item->fuente }}</td>
                                <td>{{ $item->Direcciones }}</td>
                                <td>{{ $item->Telefonos }}</td>
                                <td>{{ $item->tipo_docj.' '.$item->num_docj }}</td>
                                <td>{{ $item->JefeHogar }}</td>
                                <td>{{ $item->tipo_docb.' '.$item->num_docb }}</td>
                                <td>{{ $item->Beneficiario }}</td>
                                <td>
                                    @if($item->programa=="SI")
                                    <span class="badge badge-success"> {{ $item->programa }}</span>
                                    @else
                                    <span class="badge badge-danger"> {{ $item->programa }}</span>
                                    @endif


                                </td>
                                <td >{{ $item->fechavin }}</td>
                                <td >{{ $item->profesional }}</td>
                                @if($item->docpro==auth()->user()->documento)
                                <td>
                                    <button data-toggle="modal" data-target="#modalCreate" wire:click="edit({{ $item->id }})" class="btn btn-outline-info btn-sm"><i class="typcn typcn-edit"></i></button>
                                </td>
                                @else
                                <td></td>
                                @endif

                            </tr>
                            @empty
                                <tr>
                                    <td colspan="10"><center>No Existen datos</center></td>
                                </tr>
                            @endforelse
                            <tr>
                                <th>Total Registros:{{ count($data) }}</th>
                            </tr>
                        </tbody>
                        </tbody>
                    </table>
                    {!! $data->links() !!}
                   </div>

            </div>
        </div>
    </div>
</div>
