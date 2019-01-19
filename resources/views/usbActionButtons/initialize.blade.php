<form method="post" action="/initialize/{{ $actualUsb->id }}">
    @csrf
    <button type="submit">Initialiser la clé</button>
</form>