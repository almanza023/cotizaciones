<div class="left side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class="ion-close"></i>
    </button>

    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center py-2">
            <a href="{{ route('home') }}" class="logo"> <img src="{{ asset('theme/assets/images/logo-grupo.png') }}" width="180" alt="logo"></a>

            @if(!empty(auth()->user()->name))
                <p style="font-size: 11px"><b>{{ auth()->user()->name }}</b></p>
            @endif
        </div>
    </div>

    <div class="sidebar-inner slimscrollleft">

        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Opciones</li>
                <li>
                    <a href="{{ route('home') }}" class="waves-effect"><i class="mdi mdi-calendar"></i><span> Inicio </span></a>
                </li>
                <li>
                    <a href="{{ route('andamios') }}" class="waves-effect"><i class="mdi mdi-calendar"></i><span> Andamios </span></a>
                </li>
                <li>
                    <a href="{{ route('clientes') }}" class="waves-effect"><i class="mdi mdi-account-multiple-plus "></i><span> Clientes </span></a>
                </li>

                <li>
                    <a href="{{ route('cotizaciones.listado') }}" class="waves-effect"><i class="mdi mdi-calculator "></i><span> Cotizaciones </span></a>
                </li>
                <li>
                    <a href="{{ route('proyectos') }}" class="waves-effect"><i class="mdi mdi-account-box"></i><span> Proyectos </span></a>
                </li>


                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-table"></i><span> Configuraciones </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li>
                            <a href="{{ route('categorias') }}" class="waves-effect"><i class="mdi mdi-calendar"></i><span> Categorias </span></a>
                        </li>
                        <a href="{{ route('piezas') }}" class="waves-effect"><i class="mdi mdi-calendar"></i><span> Piezas </span></a>
                    </li>
                    <li>
                        <a href="{{ route('usuarios') }}" class="waves-effect"><i class="mdi mdi-account-circle"></i><span> Usuarios </span></a>
                    </li>
                    <li>
                        <a href="{{ route('empresa') }}" class="waves-effect"><i class="mdi mdi-account-box"></i><span> Empresa </span></a>
                    </li>
                    </ul>
                </li>
                <li>
                    <li>
                        <a href="{{ route('reportes') }}" class="waves-effect"><i class=" mdi mdi-chart-bar "></i><span> Reportes </span></a>
                    </li>
                <li>
                    <a href="{{ route('importar.index') }}" class="waves-effect"><i class="mdi mdi-arrow-top-right"></i><span> Importar Inventario </span></a>
                </li>
                <li>
                    <a data-target='#salirModal' data-toggle='modal' class="waves-effect"><i class="mdi mdi-close"></i><span> Cerrar Sesión </span></a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
