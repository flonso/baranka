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
        // `<small class="text-muted">À l'instant</small>` +
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

    if (typeof playerId === undefined || playerId.trim() == '') {
      return toast('Erreur de formulaire', "L'identifiant du joueur est requis", 'alert')
    } else if (typeof pointsGained === undefined || pointsGained.trim() == '') {
      return toast('Erreur de formulaire', "Merci d'indiquer le nombre de points gagnés", 'alert')
    }

    const params = {
      "gainedBoardPoints": pointsGained
    }
    console.log(
      `Calling route : /api/players/${playerId} with parameters: `,
      params
    )
    Axios.patch(
      `/api/players/${playerId}`,
      params
    ).then(
      (r) => handleSuccess(r, modal)
    ).catch(handleError)
  });
}

function bindSelect2(options) {
  $(options.selector).select2({
    placeholder: options.placeholder,
    width: '100%',
    allowClear: true,
    ajax: {
      url: options.url,
      dataType: 'json',
      data: (params) => {
        let finalParams = {
          query: params.term
        }

        Object.assign(finalParams, options.filters)

        return finalParams
      },
      processResults: options.processResults,
      cache: options.cache
    }
  })
}

function bindTeamSelect2(selector, filters) {
  bindSelect2({
    selector: selector,
    placeholder: 'Chercher un équipage',
    url: '/api/teams',
    filters: filters,
    processResults: (data) => {
      const processed = $.map(data.data, (team) => {
        team.text = team.name

        return team
      })
      return {
        results: processed
      }
    },
    cache: true
  })
}

function bindItemSelect2(selector, filters) {
  bindSelect2({
    selector: selector,
    placeholder: 'Chercher un objet',
    url: '/api/items',
    filters: filters,
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
  })
}

function bindPlayerSelect2(selector, filters) {
  Axios.get(`/api/teams`).then((r) => {
    const teams = r.data.data

    bindSelect2({
      selector: selector,
      placeholder: 'Chercher un joueur',
      url: '/api/players',
      filters: filters,
      processResults: (data) => {
        const processed = $.map(data.data, (player) => {
          console.log(teams);
          const teamName = teams.find(t => t.id === player.team_id).name
          player.text = `${player.first_name} ${player.last_name.toUpperCase()} (${player.group} - ${teamName})`

          return player
        })
        return {
          results: processed
        }
      },
      cache: false
    })
  })
}

function bindDiscoveredItem() {
  bindFormSubmit('discoveredItemModal', (modal, form) => {
    const itemId = form.find('select.select-item-id').val()
    const playerIds = form.find('#playerIds').val().split('\n')

    if (typeof itemId === undefined || itemId.trim() == '') {
      return toast('Erreur de formulaire', "Merci d'indiquer l'objet découvert", 'alert')
    } else if (typeof playerIds === undefined || playerIds.count() == 0) {
      return toast('Erreur de formulaire', "Merci d'indiquer au minimum un identifiant de joueur", 'alert')
    }

    const params = {
      "discoveredByPlayerIds": playerIds
    }
    console.log(
      `Calling route : api/items/${itemId} with parameters: `,
      params
    )
    Axios.patch(
      `api/items/${itemId}`,
      params
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

    if (typeof playerId === undefined || playerId.trim() == '') {
      return toast('Erreur de formulaire', "L'identifiant du joueur est requis", 'alert')
    } else if (typeof pointsGained === undefined || pointsGained.trim() == '') {
      return toast('Erreur de formulaire', "Merci d'indiquer le nombre de points gagnés", 'alert')
    }

    const params = {
      "gainedQuestPoints": pointsGained
    }
    console.log(
      `Calling route : api/players/${playerId} with parameters: `,
      params
    )
    Axios.patch(
      `api/players/${playerId}`,
      params
    ).then(
      (r) => handleSuccess(r, modal)
    ).catch(handleError)
  })
}


function bindLevelDownModal() {
  bindFormSubmit('levelDownPlayerModal', (modal, form) => {
    const playerId = form.find('#playerId').val()

    if (typeof playerId === undefined || playerId.trim() == '') {
      return toast('Erreur de formulaire', "L'identifiant du joueur est requis", 'alert')
    }

    const params = {
      "cancelLevelUp": true
    }
    console.log(
      `Calling route : api/players/${playerId} with parameters: `,
      params
    )
    Axios.patch(
      `api/players/${playerId}`,
      params
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

    if (typeof playerId === undefined || playerId.trim() == '') {
      return toast('Erreur de formulaire', "L'identifiant du joueur est requis", 'alert')
    }

    const params = {
      "levelUp": true
    }
    console.log(
      `Calling route : api/players/${playerId} with parameters: `,
      params
    )
    Axios.patch(
      `api/players/${playerId}`,
      params
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

    if (typeof playerId === undefined || playerId.trim() == '') {
      return toast('Erreur de formulaire', "L'identifiant du joueur est requis", 'alert')
    } else if (typeof itemId === undefined || itemId.trim() == '') {
      return toast('Erreur de formulaire', "Merci d'indiquer la pièce de bâteau découverte", 'alert')
    }

    const params = {
      "discoveredByPlayerIds": [playerId]
    }
    console.log(
      `Calling route : api/items/${itemId} with parameters: `,
      params
    )
    Axios.patch(
      `api/items/${itemId}`,
      params
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

    if (typeof itemId === undefined || itemId.trim() == '') {
      return toast('Erreur de formulaire', "Merci d'indiquer l'objet découvert", 'alert')
    } else if (typeof playerIds === undefined || playerIds.count() == 0) {
      return toast('Erreur de formulaire', "Merci d'indiquer au minimum un identifiant de joueur", 'alert')
    }


    const params = {
      "adventureCompletedByPlayerIds": playerIds
    }
    console.log(
      `Calling route : api/items/${itemId} with parameters: `,
      params
    )
    Axios.patch(
      `api/items/${itemId}`,
      params
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

    if (typeof playerId === undefined || playerId.trim() == '') {
      return toast('Erreur de formulaire', "Merci de sélectionner un joueur", 'alert')
    } else if (typeof playerCode === undefined || playerCode.trim() == '') {
      return toast('Erreur de formulaire', "Merci d'indiquer le numéro de talisman du joueur", 'alert')
    }

    const params = {
      "code": playerCode
    }
    console.log(
      `Calling route : api/players/${playerId} with parameters: `,
      params
    )
    Axios.patch(
      `api/players/${playerId}`,
      params
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
    const teamId = form.find('select').val()
    const playerId = form.find('#playerId').val()
    const points = form.find('#pointsInput').val()

    const radioChoice = form.find('input[name=teamOrPlayer][type=radio]')
    const teamOrPlayerMode = radioChoice.length > 1
    const applyOnTeam = radioChoice.filter(':checked').val() === "teamPoints"

    let url = `/api/teams/${teamId}`
    if (teamOrPlayerMode && !applyOnTeam) {
      url =  `/api/players/${playerId}`
    }

    if (
      (teamOrPlayerMode && applyOnTeam) ||
      !teamOrPlayerMode
    ){
      if (typeof teamId === undefined || teamId.trim() == '') {
        return toast('Erreur de formulaire', "Merci de sélectionner un équipage", 'alert')
      }
    } else if (teamOrPlayerMode && !applyOnTeam) {
      if (typeof playerId === undefined || playerId.trim() == '') {
        return toast('Erreur de formulaire', "L'identifiant du joueur est requis", 'alert')
      }
    }

    if (typeof points === undefined || points.trim() == '') {
      return toast('Erreur de formulaire', "Merci d'indiquer le nombre de points gagnés/perdus", 'alert')
    }
    const params = {
      "scoreIncrement": points
    }

    console.log(
      `Calling route ${url} with parameters`,
      params
    )
    Axios.patch(
      url,
      params
    ).then(
      (r) => handleSuccess(r, modal)
    ).catch(handleError)
  })

  const container = $(`#${containerId}`)
  const playerInputField = container.find('form #playerInputField')
  const teamInputField = container.find('form #teamInputField')
  teamInputField.hide()

  const radios = container.find('form input[type=radio][name=teamOrPlayer]')
  container.find('form').on('reset', () => {
    playerInputField.show()
    teamInputField.hide()
  })

  radios.change(function() {
    if (this.value === 'teamPoints') {
      playerInputField.hide()
      teamInputField.show()
    } else {
      playerInputField.show()
      teamInputField.hide()
    }
  })


  bindTeamSelect2(`#${containerId} select`)
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