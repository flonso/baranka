@component('modals/modal')
  @slot('modalId')
    manualPointsModal
  @endslot

  @slot('title')
    Attribuer un bonus/malus
  @endslot


  <form>
    <div>Appliquer les points sur: </div>
    <div style="display: flex; justify-content: space-between">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="teamOrPlayer" id="playerPoints" value="playerPoints" checked>
        <label class="form-check-label" for="playerPoints">
          Un joueur
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="teamOrPlayer" id="teamPoints" value="teamPoints">
        <label class="form-check-label" for="teamPoints">
          Un équipage
        </label>
      </div>
    </div>

    <div id="playerInputField">
      @component('helpers/player-id-input') @endcomponent
    </div>

    <div id="teamInputField">
      @component('helpers/select') @endcomponent
    </div>

    @component('helpers/points-input')
      @slot('title') Points bonus / malus @endslot
      @slot('placeholder') Entrer un nombre @endslot
      @slot('help') Par ex. 35 pour un bonus ou -50 pour un malus @endslot
    @endcomponent
  </form>
@endcomponent
