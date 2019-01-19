<form method="post" action="/explore/{{ $actualUsb->id }}">
    @csrf
    <button type="submit" class="btn btn-dark">Explorer</button>
</form>