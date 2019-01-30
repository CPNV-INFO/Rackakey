@extends('layouts.app')

@section('content')
@section('title', 'Reservation')
@include('top_page')


<div class="reservation-btn-container flex-row justify-content-start align-items-start mb-3 w-75">
    <a href="/" class="btn btn-lg btn-dark" name="addreservation">Retour</a>
</div>

<form method="post" action="reservation" enctype="multipart/form-data">
    <table class="reservation-table">
        <thead>
        <tr>
            <th class="">Nombre de clé</th>
            <th class="">Nom réservation</th>
            <th class="">Contenu</th>
            <th class=""></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div class="input-group flex-nowrap">
                    <input type="number" name="number_keys" class="form-control" placeholder="Nombre de clé"
                           aria-label="Nombre de clé"
                           aria-describedby="addon-wrapping">
                </div>
                @if ($errors->any())
                    {{ $errors->first('number_keys') }}
                @endif
            </td>
            <td>
                <div class="input-group flex-nowrap">
                    <input type="text" name="reservation_name" class="form-control" placeholder="Nom réservation"
                           aria-label="Nom réservation"
                           aria-describedby="addon-wrapping">

                </div>
                @if ($errors->any())
                    {{ $errors->first('reservation_name') }}
                @endif
            </td>
            <td>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="files[]" id="fileInput" class="custom-file-input" id="inputGroupFile04"
                               aria-describedby="inputGroupFileAddon04"
                               webkitdirectory mozdirectory msdirectory odirectory directory multiple="multiple">
                        <label class="custom-file-label" for="inputGroupFile04">Choisir les fichiers</label>

                    </div>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <input type="checkbox" id="checkboxFolderFileInput" aria-label="Dossier" checked>
                            &nbsp; Dossier
                        </div>


                    </div>


                    @csrf
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04">Envoyer
                        </button>
                    </div>

                </div>
                @if ($errors->any())
                    @foreach($errors->all() as $error)
                        {{ $error }}<br />
                    @endforeach
                @endif
            </td>
        </tr>
        </tbody>
    </table>
</form>

<div class="container">
    <div class="row flex-row justify-content-between align-items-center">
        <div class="col-8">
            <h1 class="mt-5">Mes réservations</h1>
        </div>
    </div>
</div>


<table class="reservation-table mt-2">
    <thead>
    <tr>
        <th class="">Nom réservation</th>
        <th class="">Date réservation</th>
        <th class="">Date réservation clôturée</th>
        <th class="">Fichiers envoyés sur la/les clé(s)</th>
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
                @if($reservation->file()->exists())
                    <form method="get" action="/file/{{ $reservation->file->id }}">
                        @csrf
                        <button class="btn btn-dark" type="submit">Télécharger</button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection

