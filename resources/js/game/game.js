/**
 * Definitions of functions used in game.blade.php
 */
import Axios from 'axios';

function bindFormSubmit(containerId, onSubmitCallback) {
  const modal = $(`#${containerId}`)
  const form = modal.find('.modal-body form')

  const submitButton = modal.find('.modal-footer button:not([data-dismiss])')
  console.log(submitButton, modal)

  submitButton.click(() => {
    form.submit()
  })

  form.submit((event) => {
    event.preventDefault()
    onSubmitCallback(modal, form)
  })
}

function bindMommandLou() {
  bindFormSubmit('mommandLouModal', (modal, form) => {
    const playerId = form.find('#playerId').val()
    const pointsGained = form.find('#pointsGained').val()

    if (typeof playerId === undefined || typeof pointsGained === undefined) {
      // Display error message
    }

    Axios.patch(
      `/api/players/${playerId}`,
      {
        "gainedBoardPoints": pointsGained
      }
    ).then((response) => {
      modal.modal('hide')
    }, (response) => {
      alert(response)
    });
  });
}

export function bindActions() {
  bindMommandLou()
}