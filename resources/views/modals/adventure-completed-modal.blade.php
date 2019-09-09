@component('modals/modal')
  @slot('modalId')
    adventureCompletedModal
  @endslot

  @slot('title')
    Enregistrer un certificat d'acheminement d'objet
  @endslot


  <form>
    <div class="form-group">
      <select id="itemCompletedId"></select>
    </div>
    <div class="form-group">
      <label for="playerCompletedIds">Identifiants des joueurs</label>
      <textarea class="form-control" id="playerCompletedIds" placeholder="Un identifiant par ligne" aria-describedby="playerCompletedIdsHelp"></textarea>
      <small id="playerCompletedIdsHelp" class="form-text text-muted">Un identifiant par ligne. <strong>Uniquement des joueurs d'un même équipage !</strong></small>
    </div>
  </form>
@endcomponent
