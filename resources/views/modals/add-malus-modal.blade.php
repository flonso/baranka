@component('modals/modal')
  @slot('modalId')
    malusModal
  @endslot

  @slot('title')
    Ajouter un malus
  @endslot


  <form>
    @component('helpers/player-id-input') @endcomponent
    <div class="form-group">
      <label for="malus">Malus</label>
      <input type="text" class="form-control" id="malus" placeholder="Malus" aria-describedby="malusHelp">
      <small id="malusHelp" class="form-text text-muted">Entrez un nombre par ex. 35</small>
    </div>
  </form>
@endcomponent
