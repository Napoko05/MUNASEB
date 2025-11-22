<td class="text-center">
    <a href="{{ route('adherant.carte.create', $adherant->id) }}" 
       class="btn btn-sm btn-primary">
       Créer carte
    </a>

    <a href="{{ route('adherant.carte.generate', $adherant->id) }}" 
       class="btn btn-sm btn-success">
       Télécharger PDF
    </a>
</td>
