<form method="post" action="usbs/initialize/{{ $actualUsb->id }}">
    @csrf
    <button type="submit" class="btn btn-light">Initialiser la clé</button>
</form>