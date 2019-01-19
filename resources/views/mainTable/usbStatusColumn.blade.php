<td class="
{{ ($actualUsb->status->id == \App\Status::notInitialized()) ? "not-initialized" : ""}}
{{ ($actualUsb->status->id == \App\Status::absent()) ? "absent" : ""}}
{{ ($actualUsb->status->id == \App\Status::alreadyDeleted()) ? "deleted" : ""}}
        ">{{ $actualUsb->status->name }}</td>