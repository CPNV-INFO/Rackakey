<td class="
{{ ($actualUsb->notActive()) ? "not-initialized" : ""}}
{{ ($actualUsb->absent()) ? "absent" : ""}}
{{ ($actualUsb->alreadyDeleted()) ? "deleted" : ""}}
        ">{{ $actualUsb->status->name }}</td>
