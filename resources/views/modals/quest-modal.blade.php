@component('modals/modal')
  @slot('modalId')
    questModal
  @endslot

  @slot('title')
    Quest
  @endslot


  <form>
    @component('helpers/player-id-input') @endcomponent
    <div class="form-group">
      <label for="pointsGainedQuest">Points gagnés</label>
      <input type="text" class="form-control" id="pointsGainedQuest" placeholder="Points gagnés" aria-describedby="pointsGainedHelp">
      <small id="pointsGainedHelp" class="form-text text-muted">Entrez un nombre par ex. 35</small>
    </div>
  </form>
@endcomponent
