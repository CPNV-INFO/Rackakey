@if($actualUsb->absent())

    <td class=" ">
    </td>

    <td class="">
        @include('usbActionButtons.delete')
    </td>

    <td class=" ">
    </td>

@elseif($actualUsb->available() ||
        $actualUsb->notInitialized() ||
        $actualUsb->present())

    <td class=" ">
        @if($actualUsb->present())
            @include('usbActionButtons.delete')
        @endif
    </td>

    @if($actualUsb->notInitialized())
        <td class=" ">
            @include('usbActionButtons.initialize')
        </td>
    @else
        <td class=" ">
            @include('usbActionButtons.download')
        </td>
    @endif

    <td class=" ">
        @include('usbActionButtons.explore')
    </td>

@elseif($actualUsb->alreadyDeleted())

    <td class=" ">
    </td>

    <td class="">
        @include('usbActionButtons.restore')
    </td>

    <td class=" ">
    </td>

@endif
