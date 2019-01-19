<form method="post" action="/delete/{{ $actualUsb->id }}" class="usbDelete">
    @csrf
    <button type="submit">Supprimer</button>
</form>