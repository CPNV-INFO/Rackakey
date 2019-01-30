@switch($key)

    @case('available')
        <td>
            @include('usbActionButtons.delete')
        </td>

        <td>
            @include('usbActionButtons.download')
        </td>

        <td>
            @include('usbActionButtons.explore')
        </td>
    @break

    @case('present')
        <td>
            {{--@include('usbActionButtons.delete')--}}
        </td>

        <td>
            @include('usbActionButtons.download')
        </td>

        <td>
            @include('usbActionButtons.explore')
        </td>
    @break

    @case('used')
        <td>
            {{--@include('usbActionButtons.delete')--}}
        </td>

        <td>
            {{--@include('usbActionButtons.download')--}}
        </td>

        <td>
            {{--@include('usbActionButtons.explore')--}}
        </td>
    @break

    @case('absent')
        <td>

        </td>

        <td>
            @include('usbActionButtons.delete')
        </td>

        <td>

        </td>
    @break

    @case('not-initialized')
        <td>

        </td>

        <td>
            @include('usbActionButtons.activate')
        </td>

        <td>

        </td>
    @break

    @case('pulled-not-initialized')
        <td>

        </td>

        <td>
            @include('usbActionButtons.delete')
        </td>

        <td>

        </td>
    @break

    @case('deleted')
        <td>

        </td>

        <td>
            @include('usbActionButtons.restore')
        </td>

        <td>

        </td>
    @break

@endswitch