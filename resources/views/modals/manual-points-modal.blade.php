@component('modals/modal')
  @slot('modalId')
    manualPointsModal
  @endslot

  @slot('title')
    Attribuer un bonus/malus
  @endslot


  <form>
    @component('helpers/player-id-input') @endcomponent
    @component('helpers/points-input')
      @slot('title') Points bonus / malus @endslot
      @slot('placeholder') Entrer un nombre @endslot
      @slot('help') Par ex. 35 pour un bonus ou -50 pour un malus @endslot
    @endcomponent
  </form>
@endcomponent
