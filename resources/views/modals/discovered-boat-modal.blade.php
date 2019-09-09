@component('modals/modal')
  @slot('modalId')
    discoveredBoatModal
  @endslot

  @slot('title')
    Enregistrer une pièce de bateau
  @endslot


  <form>
    @component('helpers/item-select') @endcomponent
        @component('helpers/player-id-input') @endcomponent

  </form>
@endcomponent
