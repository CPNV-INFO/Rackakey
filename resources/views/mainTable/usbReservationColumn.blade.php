<td class=" ">
    @switch($key)
        @case('present')
        @case('used')

        {{ $actualUsb->reservation->first()->user->firstName }}
        .
        {{ strtoupper($actualUsb->reservation->first()->user->lastName) }}
        -
        {{ $actualUsb->reservation->first()->name }}
    @endswitch
</td>