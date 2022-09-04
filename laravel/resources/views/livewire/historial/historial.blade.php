<div>
    @include('livewire.historial.detalles')
    @if (session()->has('message'))
    <script>
        mensaje("{{ session('message') }}");
    </script>
    @endif

    @if (session()->has('error'))
    <script>
        error("{{ session('error') }}");
    </script>
    @endif
    @include('livewire.historial.tabla')
</div>
