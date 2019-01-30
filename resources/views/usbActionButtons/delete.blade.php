@if($user->can('viewDeleteUsbButton'))

    <form method="post" action="/usbs/{{ $actualUsb->id }}" class="usbDelete">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Supprimer</button>
    </form>

@endif