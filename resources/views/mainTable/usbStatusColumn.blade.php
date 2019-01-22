<td class="
{{ ($actualUsb->notInitialized()) ? "not-initialized" : ""}}
{{ ($actualUsb->absent()) ? "absent" : ""}}
{{ ($actualUsb->alreadyDeleted()) ? "deleted" : ""}}
        ">{{ $actualUsb->status->name }}</td>
