@component('modals/modal')
  @slot('modalId')
    adventureCompletedModal
  @endslot

  @slot('title')
    Enregistrer un certificat d'acheminement d'objet
  @endslot


  <form>
    <div class="form-group">
      <select id="itemId"></select>
    </div>
    <div class="form-group">
      <label for="playerIds">Identifiants des joueurs</label>
      <textarea class="form-control" id="playerIds" placeholder="Un identifiant par ligne" aria-describedby="playerIdsHelp"></textarea>
      <small id="playerIdsHelp" class="form-text text-muted">Un identifiant par ligne. <strong>Uniquement des joueurs d'un même équipage !</strong></small>
    </div>
  </form>
@endcomponent
