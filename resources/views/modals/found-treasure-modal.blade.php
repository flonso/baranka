@component('modals/modal')
  @slot('modalId')
    treasureModal
  @endslot

  @slot('title')
    Trouver le trésor!
  @endslot


  <form>
    @component('helpers/select') @endcomponent

    Cet équipage gagnera 1000 points de bonus.
    <div class="form-group">
      <input type="hidden" class="form-control" id="pointsInput" value="1000" >
    </div>
  </form>
@endcomponent
