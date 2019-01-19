<form method="post" action="/explore/{{ $actualUsb->id }}">
    @csrf
    <button type="submit">Explorer</button>
</form>