@extends('layouts.app')

@section('content')


    <div class="top-page container">
        <div class="row flex-row justify-content-between align-items-center">
            <div class="col-8">
                <h1>Gestion rack à clés USB</h1>
            </div>
            <div class="col-2 text-right align-content-center align-items-center">
                <h5>{{ $user }}</h5>
            </div>
            <div class="col-2 text-right align-content-center">
                <form action="logout" method="post">
                    @csrf
                    <button type="submit" class="btn btn-light">Logout</button>
                </form>
            </div>
        </div>
        <div class="roe">
            @if(Session::has('flashmessage'))
                <div class="alert alert-{{session('flashmessage')["type"]}}" role="alert">
                    {{ session('flashmessage')["message"] }}
                </div>
            @endif

        </div>
    </div>

    <table>
        @include('mainTable._header')

        <tbody>
        <!-- All table lines -->

        @foreach ($availableUsbs as $usb)

            <tr data-usbname="{{ $actualUsb->name }}"
                data-reservationusbcount="{{ $actualUsb->reservations()->count() }}"
                data-usbfreespace="{{  \App\Usb::formatFileSize( $actualUsb->freeSpaceInBytes) }}"
                data-createdat="{{ $actualUsb->created_at }}">

                {{--@include('mainTable.usbIdColumn')--}}
                @include('mainTable.usbStatusColumn')
                @include('mainTable.usbRackPortNumberColumn')
                @include('mainTable.usbNameColumn')
                {{--@if (Auth::user()->can('viewReservedFrom'))--}}
                @include('mainTable.usbReservationColumn')
                {{--@endif--}}
                @include('mainTable.usbFreeSpaceColumn')
                {{--@if (Auth::user()->can('viewActionColumn'))--}}
                @include('mainTable.usbActionsColumn')
                {{--@endif--}}
            </tr>

        @endforeach
        </tbody>
    </table>

    <a href="addreservation.html" class="flatbutton" name="addreservation">Créer une réservation</a>

    @include('modal')
@endsection

