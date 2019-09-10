import Axios from 'axios';

const labelsMapping = {
  'board': `Mommand'Lou`,
  'quest': 'Quêtes',
  'item': 'Objets et acheminement',
  'level_change': 'Niveaux'
}
const teamColors = {
  'contantinople': 'orange',
  'cardiff': 'white',
  'brest': 'green',
  'shangai': 'red',
  'almeria': 'yellow',
  'amsterdam': 'blue'
}

let timerInterval = undefined
const intervalInSeconds = 10

export function initGlobalRankChart() {
  const ctx = $('#globalRanks').get(0).getContext('2d')

  const options = {
    title: {
      display: true,
      text: 'Classement général Baranka',
      position: 'top'
    },
    animation: {
      duration: 1000
    }
  }
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [],
      datasets: []
    },
    options: options
  })

  return chart
}

export function initAllRanksChart() {
  const ctx = $('#allRankings').get(0).getContext('2d')

  const options = {
    title: {
      display: true,
      text: 'Points des équipages par catégorie',
      position: 'top'
    },
    animation: {
      duration: 1000
    }
  }
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [],
      datasets: []
    },
    options: options
  })

  return chart
}

export function refreshAllRanksChart(chart) {
  Axios.get(
    `/api/teams/rankings`
  ).then(r => {
    const data = r.data

    const keys = Object.keys(data)
    const teams = data[keys[0]]
    const datasets = teams.map((team) => {
      const originalData = keys.map((key) => {
        return data[key].find(t => t.team_id === team.team_id)
      })
      const points = originalData.map(d => d.score)

      return {
        label: team.name,
        originalData: originalData,
        data: points,
        backgroundColor: (team.team_id === 1) ? 'orange' : 'green',
        borderColor: 'grey',
        datalabels: {
          color: 'black',
          anchor: 'end',
          align: 'top',
          offset: '5'
        }
      }
    })

    chart.data.labels = [
      `Mommand'Lou`,
      'Quêtes',
      'Objets et acheminement',
      'Niveaux'
    ]

    chart.data.datasets = datasets

    chart.update()
  })
}


export function refreshGlobalRankChart(chart) {
  Axios.get(
    `/api/teams/rankings/global`
  ).then(r => {
    const teams = r.data

    const datasets = teams.map((team) => {
      return {
        label: team.name,
        data: [team.score],
        backgroundColor: (team.id === 1) ? 'orange' : 'green',
        borderColor: 'grey',
        datalabels: {
          color: 'black',
          anchor: 'end',
          align: 'top',
          offset: '5'
        }
      }
    })

    chart.data.labels = [
      'Points totaux'
    ]
    chart.data.datasets = datasets

    chart.update()
  })
}

export function initCharts() {
  const allRanksChart = initAllRanksChart()
  const globalRanksChart = initGlobalRankChart()

  startTimer(intervalInSeconds, $('#timer'), () => {
    refreshGlobalRankChart(globalRanksChart)
    refreshAllRanksChart(allRanksChart)

    $('#lastRefreshedAt').text(
      `Dernière mise à jour à ${moment().format('HH:mm:ss')}`
    )
  })
}

function startTimer(duration, display, callback) {
  if (typeof timerInterval !== undefined) {
    clearInterval(timerInterval)
    timerInterval = undefined
  }

  var timer = duration, minutes, seconds;
  timerInterval = setInterval(function () {
    minutes = parseInt((timer / 60) % 60, 10);
    seconds = parseInt(timer % 60, 10);

    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;

    display.text(minutes + ":" + seconds)

    if (--timer < 0) {
      if (typeof callback === 'function') callback()

      startTimer(intervalInSeconds, $('#timer'), callback)
      timer = duration;
    }
  }, 1000);
}