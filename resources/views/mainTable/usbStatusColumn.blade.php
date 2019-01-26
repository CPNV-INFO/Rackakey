<td class="{{ $key }}">
    @switch($key)
        @case('available')
            {{ "Disponible" }}
        @break

        @case('present')
            {{ "Présente" }}
        @break

        @case('absent')
            {{ "Absente" }}
        @break

        @case('used')
            {{ "Utilisée" }}
        @break

        @case('not-initialized')
            {{ "Non initialisée" }}
        @break

        @case('deleted')
            {{ "Supprimée" }}
        @break
    @endswitch
</td>