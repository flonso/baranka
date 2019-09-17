@extends('layouts.app')

@section('title', 'Classement des équipages')

@section('sidebar')
  <nav class="navbar navbar-light bg-light">
    <span class="navbar-text" id="lastRefreshedAt">
      Pas encore mis à jour
    </span>
    <span class="navbar-text" id="nextRefreshedAt">
    Prochaine mise à jour dans <span id="timer">?</span>
    </span>
  </nav>
@endsection

@section('content')
  <!-- carousel-fade -->
  <div id="rankingCarousel" class="carousel slide" data-ride="carousel" data-interval="60000">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <canvas id="allRankings" class="d-block w-100"></canvas>
      </div>
      <div class="carousel-item">
        <table class="table table-striped table-bordered" style="width: 100%" id="tableRankings">
          <thead>
            <tr>
              <th scope="col">Équipage</th>
              <th scope="col">Mommand'lou</th>
              <th scope="col">Quêtes</th>
              <th scope="col">Objets</th>
              <th scope="col">Évolution</th>
              <th scope="col">Bonus/Malus</th>
              <th scope="col">Pièce de Bâteau</th>
              <th scope="col">Points de prestige</th>
            </tr>
          </thead>
        </table>
        <div class="text-danger">
          <p>
            (Mommand'Lou + Quêtes + Objets/Acheminement + Évolution + Bonus/Malus) * Pièces de Bâteau = Points de prestige
          </p>
        </div>
      </div>
      <div class="carousel-item">
        <canvas id="globalRanks"  class="d-block w-100"></canvas>
      </div>
      <!--
      <div class="carousel-item">
        <table class="table table-striped table-bordered" style="width: 100%" id="clanRankings">
          <thead>
            <tr>
              <th scope="col">Clan</th>
              <th scope="col">Points</th>
            </tr>
          </thead>
        </table>
      </div>
      -->
    </div>

    <a class="carousel-control-prev" href="#rankingCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#rankingCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <!--<div class="progress" style="height: 4px;">
    <div class="progress-bar bg-info" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="progressBar"></div>
  </div>-->
@endsection

@section('scripts')
  @parent
  <script>
    $(document).ready(() => {
      ranking.initCharts()
    })
  </script>
@endsection