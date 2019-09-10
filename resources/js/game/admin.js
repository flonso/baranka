import Axios from 'axios';
import { handleError, toast } from './game';

export function bindStartGamePhase() {
  $('#startGamePhaseButton').click((event) => {
    event.preventDefault()

    Axios.post(
      '/api/game/start'
    ).then( r => {
      toast('Information', 'La phase de jeu a bien débuté!', 'success')
      updateDisplay()
    }).catch(handleError)
  })
}

export function bindStopGamePhase() {
  $('#stopGamePhaseButton').click((event) => {
    event.preventDefault()

    Axios.post(
      '/api/game/stop'
    ).then( r => {
      toast('Information', 'La phase de jeu est terminée!', 'success')
      updateDisplay()
    }).catch(handleError)
  })
}

export function updateDisplay() {
  Axios.get('/api/game/status').then(
    r => {
      const data = r.data

      // If a game phase is in progress
      if (data && data.end_datetime === null) {
        $('#startGamePhaseButton').attr('disabled', true)
        $('#stopGamePhaseButton').attr('disabled', false)
        $('#currentPhase').text(
          `La phase ${data.number} est en cours!`
        )
      } else {
        $('#startGamePhaseButton').attr('disabled', false)
        $('#stopGamePhaseButton').attr('disabled', true)
        if (data) {
          $('#currentPhase').text(
            `La phase ${data.number} est terminée!`
          )
        } else {
          $('#currentPhase').text(
            `Aucune phase de jeu n'a été lancée pour le moment`
          )
        }
      }
    }
  ).catch(handleError)
}

export function bindAdminDashboard() {
  bindStartGamePhase()
  bindStopGamePhase()
  updateDisplay()
}