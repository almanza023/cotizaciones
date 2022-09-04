
<div>
    @if (session()->has('message'))
        <script>
            mensaje("{{ session('message') }}")
        </script>
    @endif
    @include('livewire.piezas.tabla')

    @include('livewire.piezas.create')
    @include('livewire.piezas.bloquear')
</div>
