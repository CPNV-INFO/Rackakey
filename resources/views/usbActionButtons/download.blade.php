<form method="post" action="/download/{{ $actualUsb->id }}">
    @csrf
    <button type="submit">Télécharger les données</button>
</form>