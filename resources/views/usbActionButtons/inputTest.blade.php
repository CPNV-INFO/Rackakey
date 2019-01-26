<form method="post" action="usbs/{{ $actualUsb->id }}/in">
    @csrf
    <button type="submit" class="btn btn-info">IN</button>
</form>