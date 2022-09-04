
<div>
    @if (session()->has('message'))
        <script>
            mensaje("{{ session('message') }}")
        </script>
    @endif
    @include('livewire.andamios.tabla')

    @include('livewire.andamios.create')
    @include('livewire.andamios.bloquear')
</div>

