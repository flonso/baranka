@component('modals/modal')
  @slot('modalId')
    levelUpPlayerModal
  @endslot

  @slot('title')
    Augmenter le niveau d'un joueur
  @endslot


  <form>
      @component('helpers/player-id-input') @endcomponent
  </form>
@endcomponent
