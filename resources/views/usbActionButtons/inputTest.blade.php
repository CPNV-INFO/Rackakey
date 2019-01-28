<form method="post" action="usbs/in/{{ $actualUsb->id }}">
    @csrf
    <button type="submit" class="btn btn-info">IN</button>
</form>