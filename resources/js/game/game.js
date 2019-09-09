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
    }, (error) => {
      alert(error)
    });
  });
}

function bindDiscoveredItem() {
  console.log('binding')
  bindFormSubmit('discoveredItemModal', (modal, form) => {
    const itemId = form.find('#itemId').val()
    const playerIds = form.find('#playerIds').val().split('\n')

    Axios.patch(
      `api/items/${itemId}`,
      {
        "discoveredByPlayerIds": playerIds
      }
    ).then((response) => {
      modal.modal('hide')
    }, (error) => {
      alert(error)
    })
  })

  $('#discoveredItemModal select#itemId').select2({
    placeholder: "Choisissez un objet",
    ajax: {
      url: '/api/items',
      dataType: 'json',
      data: (params) => {
        return {
          query: params.term
        }
      },
      processResults: (data) => {
        const processed = $.map(data.data, (item) => {
          item.text = item.name

          return item
        })
        return {
          results: processed
        }
      },
      cache: false
    }
  })
}

export function bindActions() {
  bindMommandLou()
  bindDiscoveredItem()
}