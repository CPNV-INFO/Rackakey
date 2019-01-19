<td class=" ">
    @if ($actualUsb->reservation()->exists())
        {{ $actualUsb->reservation()->first()->user->firstName }}
        .
        {{ strtoupper($actualUsb->reservation()->first()->user->lastName) }}
        -
        {{ $actualUsb->reservation()->first()->name }}
    @endif
</td>