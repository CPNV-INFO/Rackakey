@if($user->can('viewDownloadUsbDataButton', $actualUsb))

    <form method="post" action="/download/{{ $actualUsb->id }}">
        @csrf
        <button type="submit" class="btn btn-primary" disabled>Télécharger les données</button>
    </form>

@endif