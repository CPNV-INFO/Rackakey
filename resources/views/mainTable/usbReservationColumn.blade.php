<td class=" ">
    @switch($key)
        @case('present')
        @case('used')
        {{ $actualUsb->reservation()->latest()->first()->user->firstName }}
        .
        {{ strtoupper($actualUsb->reservation()->latest()->first()->user->lastName) }}
        -
        {{ $actualUsb->reservation()->latest()->first()->name }}
    @endswitch
</td>