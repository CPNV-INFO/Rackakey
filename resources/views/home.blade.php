@extends('layouts.app')

@section('content')

@section('title', 'Gestion rack à clés USB')
@include('top_page')


<div class="reservation-btn-container flex-row justify-content-end align-items-end mb-3">
    <a href="reservation_show" class="btn btn-lg btn-dark" name="addreservation">Mes réservations</a>
</div>

<div class="reservation-btn-container flex-row justify-content-end align-items-end mb-3">
    <a href="reservation_create" class="btn btn-lg btn-dark" name="addreservation">Créer une réservation</a>
</div>

<table>
    @include('mainTable._header')

    <tbody>
    <!-- All table lines -->

    @foreach ($usbsWithTypes as $key => $usbs)
        @foreach($usbs as $actualUsb)

            <tr data-usbname="{{ $actualUsb->name }}"
                data-reservationusbcount="{{ $actualUsb->reservation()->withTrashed()->count() }}"
                data-usbfreespace="{{  \App\Usb::formatFileSize( $actualUsb->freeSpaceInBytes) }}"
                data-createdat="{{ $actualUsb->created_at }}">

{{--                @include('mainTable.usbIdColumn')--}}
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
                @include('mainTable.usbInputOutputTests')
            </tr>
        @endforeach

    @endforeach
    </tbody>
</table>

@include('modal')
@endsection


