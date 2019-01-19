@extends('layouts.app')


@section('content')
    <div>
        <h5 style="text-align: right; margin-right: 5%;">{{ $user }}</h5></div>
    <div>
        <br>
        <h1 style="margin-left: 5%;">Gestion rack à clés USB</h1><br>
    </div>
    <form action="logout" method="post">
        @csrf
        <button type="submit">Logout</button>
    </form>
    <div class="wrap-table100">
        <div class="table100 ver1 m-b-110">

            <!-- Table Header -->
            <div class="table100-head">
                <table>
                    <thead>
                    <tr class="row100 head">
                        <th class="cell100 column1">Numéro Clé</th>
                        <th class="cell100 column2">Etat</th>
                        <th class="cell100 column3">Port rack</th>
                        @if (Auth::user()->can('viewReservedFrom'))
                            <th class="cell100 column4">Réservé par</th>
                        @endif
                        <th class="cell100 column5">Espace libre</th>
                        @if (Auth::user()->can('viewActionColumn'))
                            <th class="cell100 column6">Actions</th>
                            <th class="cell100 column6"></th>
                            <th class="cell100 column6"></th>
                        @endif
                    </tr>
                    </thead>
                </table>
            </div>

            <!-- All table lines -->

            @foreach ($usbs as $actualUsb)
                @if (Auth::user()->can('view', $actualUsb))
                    <div class="table100-body js-pscroll">
                        <table>
                            <tbody>
                            <tr class="row100 body
                                        {{ ($actualUsb->status->id == \App\Status::notInitialized()) ? "not-initialized" : ""}}
                                        {{ ($actualUsb->status->id == \App\Status::absent()) ? "absent" : ""}}"
                                data-usbname="{{ $actualUsb->name }}"
                                data-reservationusbcount="{{ 0 }}"
                                data-usbfreespace="{{  \App\Usb::formatFileSize( $actualUsb->freeSpaceInBytes) }}">

                                <td class="cell100 column1"> {{ $actualUsb->id }}</td>
                                <td class="cell100 column2">{{ $actualUsb->status->name }}</td>
                                <td class="cell100 column3">
                                    Rack {{ $actualUsb->rack_number }}
                                    -
                                    Port {{ $actualUsb->port_number }}
                                </td>

                                @if (Auth::user()->can('viewReservedFrom'))
                                    <td class="cell100 column4">
                                        @if ($actualUsb->reservation()->exists())
                                            {{ $actualUsb->reservation()->first()->user->firstName }}
                                            .
                                            {{ strtoupper($actualUsb->reservation()->first()->user->lastName) }}
                                            -
                                            {{ $actualUsb->reservation()->first()->name }}
                                        @endif
                                    </td>
                                @endif

                                <td class="cell100 column5">
                                    {{  \App\Usb::formatFileSize( $actualUsb->freeSpaceInBytes) }}
                                </td>

                                @if (Auth::user()->can('viewActionColumn'))

                                    @if($actualUsb->status->id == \App\Status::absent())
                                        <td class="cell100 column6">

                                        </td>
                                        <td class="cell100 column7">
                                            @include('usbActionButtons.delete')
                                        </td>
                                        <td class="cell100 column8">

                                        </td>
                                    @elseif($actualUsb->status->id == \App\Status::available() || $actualUsb->status->id == \App\Status::notInitialized())
                                        <td class="cell100 column6">
                                            {{--<a href="#">--}}
                                            {{--<img src="images/icons/delete.png" height="40px">--}}
                                            {{--</a>--}}
                                            @include('usbActionButtons.delete')
                                        </td>
                                        @if($actualUsb->status->id == \App\Status::notInitialized())
                                            <td class="cell100 column7">
                                                @include('usbActionButtons.initialize')
                                            </td>
                                        @else
                                            <td class="cell100 column7">
                                                {{--<a href="#">--}}
                                                {{--<img src="images/icons/download.png"--}}
                                                {{--title="Télécharger toutes les données en local"--}}
                                                {{--height="40px"--}}
                                                {{--style="margin-right:25px;"--}}
                                                {{--style="margin-right:25px;"/>--}}
                                                {{--</a>--}}
                                                @include('usbActionButtons.download')
                                            </td>
                                        @endif

                                        <td class="cell100 column8">
                                            {{--<a href="./encode_explorer/index.php?usbRack=1&usbKeyPort=1">--}}
                                            {{--<img src="images/icons/folder.png" title="Explorer" height="40px" />--}}
                                            {{--</a>--}}
                                            @include('usbActionButtons.explore')
                                        </td>
                                    @endif
                                @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            @endforeach

            <a href="addreservation.html" class="flatbutton" name="addreservation">Créer une réservation</a>
        </div>
    </div>
    <br><br>

    @include('modal')
@endsection

