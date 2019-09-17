import Axios from 'axios';

const labelsMapping = {
  'board': `Mommand'Lou`,
  'quest': 'Quêtes',
  'item': 'Objets et acheminement',
  'level_change': 'Évolution'
}
const teamColors = {
  'constantinople': 'orange',
  'cardiff': 'white',
  'brest': 'green',
  'shanghai': 'red',
  'almeria': 'yellow',
  'amsterdam': 'blue'
}

let timerInterval = undefined
const intervalInSeconds = 300

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
    },
    scales: {
      yAxes: [{
          ticks: {
              beginAtZero: true
          }
      }]
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
    },
    scales: {
      yAxes: [{
          ticks: {
              beginAtZero: true
          }
      }]
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

function getColorForTeam(name) {
  const colorIndex = Object.keys(teamColors).find((n) => {
    return name.toLocaleLowerCase().indexOf(n) >= 0
  })

  return teamColors[colorIndex]
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

      const color = getColorForTeam(team.name)
      const points = originalData.map(d => {

        if (d.type === 'quest' || d.type === 'board') {
          return d.score * 10
        }

        return d.score
      })

      return {
        label: team.name,
        originalData: originalData,
        data: points,
        backgroundColor: color,
        borderColor: 'grey',
        borderWidth: 1,
        datalabels: {
          color: 'black',
          anchor: 'end',
          align: 'top',
          offset: '5'
        }
      }
    })

    chart.data.labels = keys.map(k => labelsMapping[k])

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
      const color = getColorForTeam(team.name)

      return {
        label: team.name,
        data: [Math.round(team.score)],
        backgroundColor: color,
        borderColor: 'grey',
        borderWidth: 1,
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

export function fetchRankTableData(data, callback, settings) {
  Axios.get("api/teams/rankings?includeManualPoints=true").then((response) => {
    const data = response.data
    let rows = [];
    const keys = Object.keys(data)
    keys.map((key) => {
      const ranks = data[key]
      ranks.forEach((rank) => {
        if (typeof rows[rank.team_id] === 'undefined') {
          rows[rank.team_id] = {}
          rows[rank.team_id]['total'] = 0
        }
        rows[rank.team_id][rank.type] = (rank.type === 'manual_points') ? rank.score : rank.gainedPoints
        rows[rank.team_id]['name'] = rank.name
        rows[rank.team_id]['total'] += (rank.type === 'manual_points') ?  rank.score : rank.gainedPoints
        rows[rank.team_id]['score_multiplier'] = rank.score_multiplier
      })
    })

    rows = rows.map((row) => {
      row['total'] *= row['score_multiplier']
      row['total'] = Math.round(row['total'])
      return row
    }).filter(v => typeof v !== 'undefined')

    console.log('rows are', rows, JSON.stringify(rows))

    return callback({
      data: rows
    })
  })
}

function bindRankTable() {
  const table = $('#tableRankings').DataTable( {
    ajax: fetchRankTableData,
    paging: false,
    searchable: false,
    deferRender: true,
    columns: [
        { data: "name"},
        { data: "board" },
        { data: "quest" },
        { data: "item" },
        { data: "level_change" },
        { data: "manual_points"},
        { data: "score_multiplier" },
        { data: "total"}
    ]
  })

  return table
}

export function initCharts() {
  const allRanksChart = initAllRanksChart()
  const globalRanksChart = initGlobalRankChart()
  const table = bindRankTable()

  const refresh = () => {
    refreshGlobalRankChart(globalRanksChart)
    refreshAllRanksChart(allRanksChart)
    table.ajax.reload()

    $('#lastRefreshedAt').text(
      `Dernière mise à jour à ${moment().format('HH:mm:ss')}`
    )
  }

  refresh()
  startTimer(intervalInSeconds, $('#timer'), refresh)
  $('#rankingCarousel').on('slide.bs.carousel', () => {
    // Could add a progress bar here
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