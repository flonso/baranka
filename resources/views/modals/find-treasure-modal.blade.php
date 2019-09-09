@component('modals/modal')
  @slot('modalId')
    treasureModal
  @endslot

  @slot('title')
    Trouver le trésor!
  @endslot


  <form>
    @component('helpers/player-id-input') @endcomponent
    <div class="form-group">
      <input type="hidden" class="form-control" id="treasure" value="1000" >
    </div>
  </form>
@endcomponent
