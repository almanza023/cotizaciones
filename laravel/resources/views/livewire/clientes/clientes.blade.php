
<div>
    @if (session()->has('message'))
        <script>
            mensaje("{{ session('message') }}")
        </script>
    @endif
    @include('livewire.clientes.tabla')

    @include('livewire.clientes.create')
    @include('livewire.clientes.bloquear')
</div>
