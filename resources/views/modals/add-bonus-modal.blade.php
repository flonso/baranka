@component('modals/modal')
  @slot('modalId')
    bonusModal
  @endslot

  @slot('title')
    Ajouter un bonus
  @endslot


  <form>
    @component('helpers/player-id-input') @endcomponent
    <div class="form-group">
      <label for="bonus">Bonus</label>
      <input type="text" class="form-control" id="bonus" placeholder="Bonus" aria-describedby="bonusHelp">
      <small id="bonusHelp" class="form-text text-muted">Entrez un nombre par ex. 35</small>
    </div>
  </form>
@endcomponent
