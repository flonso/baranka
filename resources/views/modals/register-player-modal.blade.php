@component('modals/modal')
  @slot('modalId')
    registerPlayerModal
  @endslot

  @slot('title')
    Enregistrer un joueur
  @endslot


  <form>
    <div class="form-group">
      <select id="playerRegistered"></select>
    </div>
      @component('helpers/player-id-input') @endcomponent
  </form>
@endcomponent
