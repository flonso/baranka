@component('modals/modal')
  @slot('modalId')
    discoveredItemModal
  @endslot

  @slot('title')
    Enregistrer un certificat de découverte d'objet
  @endslot


  <form>
    @component('helpers/select') select-item-id @endcomponent
    @component('helpers.player-ids-textarea') @endcomponent
  </form>
@endcomponent
