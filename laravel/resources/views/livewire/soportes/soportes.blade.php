
<div>
    @if (session()->has('message'))
        <script>
            mensaje("{{ session('message') }}")
        </script>
    @endif
    @include('livewire.soportes.create')
    @include('livewire.soportes.tabla')
    @include('livewire.soportes.bloquear')
</div>

