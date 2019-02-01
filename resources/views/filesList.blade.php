@extends('layouts.app')

@section('content')
@section('title', 'Liste des fichiers')
@include('top_page')


<div class="reservation-btn-container flex-row justify-content-start align-items-start mb-3 w-75">
    <a href="/" class="btn btn-lg btn-dark" name="addreservation">Retour</a>
</div>

<table class="reservation-table mt-2">
    <thead>
    <tr>
        <th class=""></th>
        <th class="">Nom du fichier</th>
    </tr>
    </thead>
    <tbody>
    @foreach($filesList as $index =>  $file)
        <tr>
            <td>
                {{ $index+1 }}
            </td>
            <td>
                {{ $file }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection

