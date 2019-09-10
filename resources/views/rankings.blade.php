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
  <div class="row" style="max-height: 40%;">
    <div class="col-sm">
      <canvas id="allRankings">
      </canvas>
    </div>
  </div>
  <hr/>
  <div class="row" style="max-height: 40%;">
    <div class="col-sm">
      <canvas id="globalRanks">
      </canvas>
    </div>
  </div>
@endsection

@section('scripts')
  @parent
  <script>
    ranking.initCharts()
  </script>
@endsection