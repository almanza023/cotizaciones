
<div>
    @if (session()->has('message'))
        <script>
            mensaje("{{ session('message') }}")
        </script>
    @endif
    @include('livewire.categorias.tabla')

    @include('livewire.categorias.create')
    @include('livewire.categorias.bloquear')
</div>

