@if($user->can('viewInitializeUsbButton', $actualUsb))

    <form method="post" action="/usbs/restore/{{ $actualUsb->id }}">
        @csrf
        <button type="submit" class="btn btn-warning">Restaurer</button>
    </form>

@endif