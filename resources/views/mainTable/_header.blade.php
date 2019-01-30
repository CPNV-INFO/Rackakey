<!-- Table Header -->
<thead>
<tr>
    {{--<th class="">Numéro Clé</th>--}}
    <th class="">Etat</th>
    <th class="">Port rack</th>
    <th class="">Nom de la clé</th>
    {{--@if (Auth::user()->can('viewReservedFrom'))--}}
    <th class="">Réservé par</th>
    {{--@endif--}}
    <th class="">Espace libre</th>
    {{--@if (Auth::user()->can('viewActionColumn'))--}}
    <th class="" colspan="3">Actions</th>

    <th class="" colspan="2">I/O (Tests)</th>
    {{--@endif--}}
</tr>
</thead>
