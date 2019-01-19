@if($actualUsb->status->id == \App\Status::absent())

    <td class=" ">
    </td>

    <td class="">
        @include('usbActionButtons.delete')
    </td>

    <td class=" ">
    </td>

@elseif($actualUsb->status->id == \App\Status::available() ||
        $actualUsb->status->id == \App\Status::notInitialized() ||
        $actualUsb->status->id == \App\Status::present())

    <td class=" ">
        @if($actualUsb->status->id != \App\Status::present())
            @include('usbActionButtons.delete')
        @endif
    </td>

    @if($actualUsb->status->id == \App\Status::notInitialized())
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

@elseif($actualUsb->status->id == \App\Status::alreadyDeleted())

    <td class=" ">
    </td>

    <td class="">
        @include('usbActionButtons.restore')
    </td>

    <td class=" ">
    </td>

@endif