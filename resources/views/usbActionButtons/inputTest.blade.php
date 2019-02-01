@switch($key)
    @case('used')
    @case('absent')
    @case('pulled-not-initialized')
    <form method="post" action="usbs/in/{{ $actualUsb->id }}">
        @csrf
        <button type="submit" class="btn btn-info">IN</button>
    </form>
    @break
@endswitch

