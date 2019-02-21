@extends('layouts.app')

@section('content')
@section('title', 'Mes réservations')
@include('top_page')


<div class="reservation-btn-container flex-row justify-content-start align-items-start mb-3 w-75">
    <a href="javascript:history.back()" class="btn btn-lg btn-dark" name="addreservation">Retour</a>
</div>

<table class="reservation-table mt-2">
    <thead>
    <tr>
        <th class="">Nom réservation</th>
        <th class="">Date réservation</th>
        <th class="">Date réservation clôturée</th>
        <th class="">Nombre de fichiers</th>
        <th class="">Fichiers envoyés sur la/les clé(s)</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reservations as $reservation)
        <tr>
            <td>
                {{ $reservation->name }}
            </td>
            <td>
                {{ $reservation->date_reserved }}
            </td>
            <td>
                {{ $reservation->date_returned }}
            </td>
            <td>
                <a href="/files/{{ $reservation->file->id }}">
                    {{ $reservation->file->numberOfFiles }}
                </a>
            </td>
            <td>
                @if($reservation->file()->exists())
                    <form method="get" action="/file/{{ $reservation->file->id }}">
                        @csrf
                        <button class="btn btn-dark" type="submit">Télécharger</button>
                    </form>
                @endif



            </td>
            <td>
                <button class="btn btn-dark"><a href="returnReservation" style="color: #FFFFFF;">Terminer</a></button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection

