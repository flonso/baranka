@component('modals/modal')
  @slot('modalId')
    adventureCompletedModal
  @endslot

  @slot('title')
    Enregistrer un certificat d'acheminement d'objet
  @endslot


  <form>
    @component('helpers/select') select-item-id @endcomponent
    @component('helpers.player-ids-textarea') @endcomponent
  </form>
@endcomponent
