@component('modals/modal')
  @slot('modalId')
    mommandLouModal
  @endslot

  @slot('title')
    Mommand'lou
  @endslot


  <form>
    @component('helpers/player-id-input') @endcomponent
    <div class="form-group">
      <label for="pointsGained">Points gagnés</label>
      <input type="text" class="form-control" id="pointsGained" placeholder="Points gagnés" aria-describedby="pointsGainedHelp">
      <small id="pointsGainedHelp" class="form-text text-muted">Entrez un nombre par ex. 35</small>
    </div>
  </form>
@endcomponent