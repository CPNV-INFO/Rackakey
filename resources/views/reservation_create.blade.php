@extends('layouts.app')

@section('content')
@section('title', 'Créer une réservation')
@include('top_page')


<div class="reservation-btn-container flex-row justify-content-start align-items-start mb-3 w-75">
    <a href="javascript:history.back()" class="btn btn-lg btn-dark" name="addreservation">Retour</a>
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
                               aria-describedby="sendFiles"
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
                        <button class="btn btn-outline-secondary" type="submit" id="sendFiles">Envoyer
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

@include('reservation_create_modal_error')
@endsection

