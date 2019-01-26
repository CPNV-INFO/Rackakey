<form method="post" action="usbs/{{ $actualUsb->id }}/out">
    @csrf
    <button type="submit" class="btn btn-dark">OUT</button>
</form>