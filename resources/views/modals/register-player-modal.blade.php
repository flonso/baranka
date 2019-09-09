@component('modals/modal')
  @slot('modalId')
    registerPlayerModal
  @endslot

  @slot('title')
    Enregistrer un joueur
  @endslot


  <form>
    @component('helpers/select') select-player-id @endcomponent
    @component('helpers/player-id-input') @endcomponent
  </form>
@endcomponent
