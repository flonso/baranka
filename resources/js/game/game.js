/**
 * Definitions of functions used in game.blade.php
 */

import 'jquery-ui/ui/widgets/dialog.js';

function buildDialog(containerId, callback) {
  const container = $(`#${containerId}`)
  const dialog = container.dialog({
      autoOpen: false,
      modal: true,
      buttons: {
          "Valider": () => callback(dialog),
          "Annuler": () => dialog.dialog("close")
      },
      close: () => {

      }
  })

  container.find('form').submit((event) => {
    event.preventDefault()
    callback(dialog)
  })

  return dialog
}

export function bindButtons() {
  const mommandLouDialog = buildDialog('mommand-lou-form', (dialog) => {
    const form = $('#mommand-lou-form').find('form')
    const playerId = form.find('#playerId').val()
    const pointsGained = form.find('#pointsGained').val()

    alert(`Le joueur ${playerId} gagne ${pointsGained}`)
    dialog.dialog("close")
  })

  $('#mommand-lou').click(() => {
    mommandLouDialog.dialog("open")
  })
}