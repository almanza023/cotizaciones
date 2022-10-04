
<div>
    @if (session()->has('message'))
        <script>
            mensaje("{{ session('message') }}")
        </script>
    @endif
    @include('livewire.usuarios.tabla')

    @include('livewire.usuarios.create')
    @include('livewire.usuarios.bloquear')
</div>
