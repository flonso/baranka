@component('modals/modal')
  @slot('modalId')
    levelDownPlayerModal
  @endslot

  @slot('title')
    Annuler l'augmentation de niveau d'un joueur
  @endslot


  <form>
      @component('helpers/player-id-input') @endcomponent
  </form>
@endcomponent
