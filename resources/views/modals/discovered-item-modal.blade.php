@component('modals/modal')
  @slot('modalId')
    discoveredItemModal
  @endslot

  @slot('title')
    Enregistrer un certificat d'objet
  @endslot


  <form>
    @component('helpers/item-select') @endcomponent
    <div class="form-group">
      <label for="playerIds">Identifiants des joueurs</label>
      <textarea class="form-control" id="playerIds" placeholder="Un identifiant par ligne" aria-describedby="playerIdsHelp"></textarea>
      <small id="playerIdsHelp" class="form-text text-muted">Un identifiant par ligne. <strong>Uniquement des joueurs d'un même équipage !</strong></small>
    </div>
  </form>
@endcomponent