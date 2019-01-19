<form method="post" action="/download/{{ $actualUsb->id }}">
    @csrf
    <button type="submit" class="btn btn-primary">Télécharger les données</button>
</form>