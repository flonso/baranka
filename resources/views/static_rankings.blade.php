@extends('layouts.app')

@section('title', 'Classement des équipages')

@section('sidebar')
  <nav class="navbar navbar-light bg-light">
    <span class="navbar-text" id="lastRefreshedAt">
      Mis à jour le dimanche 15 septembre à 12:00
    </span>
  </nav>
@endsection

@section('content')
  <!-- carousel-fade -->
  <div id="rankingCarousel" class="ipad-static carousel slide" data-ride="carousel" data-interval="20000">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/all_rankings.png" />
      </div>
      <div class="carousel-item">
        <img src="images/table.png" />
      </div>
      <div class="carousel-item">
        <img src="images/global_rankings.png" />
      </div>
      <div class="carousel-item">
        <h3>Jeu des Clans</h3>
        <table class="table table-responsive">
          <thead>
            <tr>
              <th>Clan</th>
              <th>Points gagnés</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Sept Mers</td>
              <td>232 pts</td>
            </tr>
            <tr>
              <td>Tricornes des Sables</td>
              <td>210 pts</td>
            </tr>
            <tr>
              <td>Flibustiers du Cap</td>
              <td>103 pts</td>
            </tr>
            <tr>
              <td>Crânes Rouges</td>
              <td>90 pts</td>
            </tr>
            <tr>
              <td>Requins Noirs</td>
              <td>88 pts</td>
            </tr>
            <tr>
              <td>Oeil du Singe</td>
              <td>0 pts</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!--<div class="progress" style="height: 4px;">
    <div class="progress-bar bg-info" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="progressBar"></div>
  </div>-->
@endsection
