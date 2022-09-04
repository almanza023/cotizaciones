@if (session()->has('message'))
<script>
    mensaje("{{ session('message') }}")
</script>
@endif
@if (session()->has('advertencia'))
<script>
    advertencia("{{ session('advertencia') }}")
</script>
@endif
