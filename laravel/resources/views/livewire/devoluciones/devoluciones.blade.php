
<div>
    @if (session()->has('message'))
        <script>
            mensaje("{{ session('message') }}")
        </script>
    @endif
    @include('livewire.entregas.tabla')
    @include('livewire.entregas.bloquear')
</div>

