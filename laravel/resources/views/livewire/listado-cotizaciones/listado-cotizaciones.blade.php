
<div>
    @if (session()->has('message'))
        <script>
            mensaje("{{ session('message') }}")
        </script>
    @endif
    @include('livewire.listado-cotizaciones.tabla')
    @include('livewire.listado-cotizaciones.bloquear')
    @include('livewire.listado-cotizaciones.buscar-cliente')
</div>

