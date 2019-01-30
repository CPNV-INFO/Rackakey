<form method="post" action="usbs/out/{{ $actualUsb->id }}">
    @csrf
    <button type="submit" class="btn btn-dark">OUT</button>
</form>