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

function bindDiscoveredItem() {
  bindFormSubmit('discoveredItemModal', (modal, form) => {
    // TODO
  })

  $('#discoveredItemModal .item-select').select2({
    placeholder: "Choisissez un objet",
    minimumInputLength: 1,
    ajax: {
      url: '/items',
      dataType: 'json',
      data: (params) => {
        return {};
      },
      processResults: (data) => {
        return {
          results: data.data
        }
      },
      cache: false
    }
  })
}

export function bindActions() {
  bindMommandLou()
}