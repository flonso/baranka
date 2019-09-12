/**
 * Definitions of functions used in game.blade.php
 */
import Axios from 'axios';

function resetForm(form) {
  form.find('select').val([]).trigger('change')
  form.trigger('reset')
}

export function handleError(error) {
  if (error.response) {
    const data = error.response.data
    const message = `[${data.code}] ${data.message}`

    toast('Une erreur est survenue', message, 'alert')

    const errors = data.errors
    if (typeof errors !== 'undefined') {
      Object.keys(errors).forEach((key) => {
        const error = errors[key]
        toast(`Une erreur est survenue`, error.join(','), 'alert')
      })
    }
  } else if (error.request) {
    // The request was made but no response was received
    // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
    // http.ClientRequest in node.js
    toast('Une erreur est survenue', 'Impossible de contacter le serveur', 'alert')
  } else {
    // Something happened in setting up the request that triggered an Error
    toast('Une erreur inattendue est survenue', error.message, 'alert')
  }
  console.error('#### Error with request ####')
  console.error(error.config);
}

export function handleSuccess(response, modal, message) {
  if (typeof modal !== 'undefined') {
    modal.modal('hide')
  }
  toast('Information', (message) ? message : 'Données sauvegardées', 'success')
}

export function toast(title, message, type) {
  let clazz;
  if (type === 'alert') {
    clazz = 'text-danger'
  } else if (type === 'info') {
    clazz = 'text-info'
  } else if (type === 'warn') {
    clazz = 'text-warn'
  } else if (type == 'success') {
    clazz = 'text-success'
  }

  const toast = $(
    '<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">' +
      '<div class="toast-header">' +
        `<strong class="mr-auto">${title}</strong>` +
        `<small class="text-muted">À l'instant</small>` +
        `<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Fermer">` +
          '<span aria-hidden="true">&times;</span>' +
        '</button>' +
      '</div>' +
      '<div class="toast-body">' +
        `<span class="${clazz}">${message}</span>` +
      '</div>' +
    '</div>'
  )

  $('#toastContainer').append(toast)
  toast.toast({
    delay: 5000
  })

  toast.toast('show')

  toast.on('hidden.bs.toast', () => {
    toast.remove()
  })
}

function bindFormSubmit(containerId, onSubmitCallback) {
  const modal = $(`#${containerId}`)
  const form = modal.find('.modal-body form')

  const submitButton = modal.find('.modal-footer button:not([data-dismiss])')

  // For submit on enter press
  form.append(
    '<input type="submit" style="position: absolute; left: -9999px"/>'
  )
  submitButton.click(() => form.submit())

  modal.on('hidden.bs.modal', () => {
    resetForm(form)
  })

  form.submit((event) => {
    event.preventDefault()
    onSubmitCallback(modal, form)
  })
}

function bindMommandLouModal() {
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
    ).then(
      (r) => handleSuccess(r, modal)
    ).catch(handleError)
  });
}

function bindItemSelect2(selector, filters) {
  $(selector).select2({
    placeholder: "Chercher un objet",
    width: '100%',
    allowClear: true,
    ajax: {
      url: '/api/items',
      dataType: 'json',
      data: (params) => {
        let finalParams = {
          query: params.term
        }

        Object.assign(finalParams, filters)

        return finalParams
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

function bindPlayerSelect2(selector, filters) {
  $(selector).select2({
    placeholder: "Chercher un joueur",
    width: '100%',
    allowClear: true,
    ajax: {
      url: '/api/players',
      dataType: 'json',
      data: (params) => {
        let finalParams = {
          query: params.term
        }

        Object.assign(finalParams, filters)

        return finalParams
      },
      processResults: (data) => {
        const processed = $.map(data.data, (player) => {
          player.text = `${player.first_name} ${player.last_name.toUpperCase()} (${player.group})`

          return player
        })
        return {
          results: processed
        }
      },
      cache: false
    }
  })
}

function bindDiscoveredItem() {
  bindFormSubmit('discoveredItemModal', (modal, form) => {
    const itemId = form.find('select.select-item-id').val()
    const playerIds = form.find('#playerIds').val().split('\n')

    Axios.patch(
      `api/items/${itemId}`,
      {
        "discoveredByPlayerIds": playerIds
      }
    ).then(
      (r) => handleSuccess(r, modal)
    ).catch(handleError)
  })

  bindItemSelect2(
    '#discoveredItemModal form select.select-item-id',
    {
      discovered: false,
      withMultiplier: false // filtering out boat pieces
    }
  )
}

function bindQuestModal() {
  bindFormSubmit('questModal', (modal, form) => {
    const playerId = form.find('#playerId').val()
    const pointsGained = form.find('#pointsGainedQuest').val()

    Axios.patch(
      `api/players/${playerId}`,
      {
        "gainedQuestPoints": pointsGained
      }
    ).then(
      (r) => handleSuccess(r, modal)
    ).catch(handleError)
  })
}


function bindLevelDownModal() {
  bindFormSubmit('levelDownPlayerModal', (modal, form) => {
    const playerId = form.find('#playerId').val()

    Axios.patch(
      `api/players/${playerId}`,
      {
        "cancelLevelUp": true
      }
    ).then(
      (r) => {
        const message = `${r.data.first_name} ${r.data.last_name} est maintenant au niveau ${r.data.level}`
        handleSuccess(r, modal, message)
      }
    ).catch(handleError)
  })
}

function bindLevelUpModal() {
  bindFormSubmit('levelUpPlayerModal', (modal, form) => {
    const playerId = form.find('#playerId').val()

    Axios.patch(
      `api/players/${playerId}`,
      {
        "levelUp": true
      }
    ).then(
      (r) => {
        const message = `${r.data.first_name} ${r.data.last_name} est maintenant au niveau ${r.data.level}`
        handleSuccess(r, modal, message)
      }
    ).catch(handleError)
  })
}

function bindBoatPieceModal() {
  bindFormSubmit('discoveredBoatModal', (modal, form) => {
    const playerId = form.find('#playerId').val()
    const itemId = form.find('select.select-item-id').val()


    Axios.patch(
      `api/items/${itemId}`,
      {
        "discoveredByPlayerIds": [playerId]
      }
    ).then(
      (r) => handleSuccess(r, modal)
    ).catch(handleError)
  })

  bindItemSelect2(
    '#discoveredBoatModal form select.select-item-id',
    {
      discovered: false,
      withMultiplier: true // filtering out normal items
    }
  )
}

function bindAdventureCompletedModal() {
  bindFormSubmit('adventureCompletedModal', (modal, form) => {
    const itemId = form.find('select.select-item-id').val()
    const playerIds = form.find('#playerIds').val().split('\n')

    Axios.patch(
      `api/items/${itemId}`,
      {
        "adventureCompletedByPlayerIds": playerIds
      }
    ).then(
      (r) => handleSuccess(r, modal)
    ).catch(handleError)
  })

  bindItemSelect2(
    '#adventureCompletedModal form select.select-item-id',
    {
      discovered: true,
      adventureCompleted: false,
      withMultiplier: false // filtering out boat pieces
    }
  )
}

function bindRegisterPlayerModal() {
  bindFormSubmit('registerPlayerModal', (modal, form) => {
    const playerId = form.find('select.select-player-id').val()
    const playerCode = form.find('#playerId').val()

    Axios.patch(
      `api/players/${playerId}`,
      {
        "code": playerCode
      }
    ).then(
      (r) => handleSuccess(r, modal)
    ).catch(handleError)
  })

  bindPlayerSelect2(
    '#registerPlayerModal form select.select-player-id',
    {
      limit: 20
    }
  )
}

function bindManualPointsModal(containerId) {
  bindFormSubmit(containerId, (modal, form) => {
    const playerId = form.find('#playerId').val()
    const points = form.find('#pointsInput').val()

    Axios.patch(
      `api/players/${playerId}`,
      {
        "scoreIncrement": points
      }
    ).then(
      (r) => handleSuccess(r, modal)
    ).catch(handleError)
  })
}

export function bindActions() {
  bindMommandLouModal()
  bindDiscoveredItem()
  bindQuestModal()
  bindLevelUpModal()
  bindLevelDownModal()
  bindBoatPieceModal()
  bindAdventureCompletedModal()
  bindRegisterPlayerModal()
  bindManualPointsModal('manualPointsModal')
  bindManualPointsModal('treasureModal')
}