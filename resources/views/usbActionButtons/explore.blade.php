@if($user->can('viewExploreUsbButton', $actualUsb))

    <form method="post" action="/explore/{{ $actualUsb->id }}">
        @csrf
        <button type="submit" class="btn btn-dark" disabled>Explorer</button>
    </form>

@endif