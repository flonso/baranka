@extends('layouts.app')

@section('title', 'Joueurs')

@section('sidebar')
	@parent
@endsection

@section('content')
    <div class="row">
        <h1>Joueurs</h1>
    </div>
	<div class="row">
        <table class="table table-striped table-bordered" style="width:100%" id="players">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th>Badge</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Groupe</th>
                <th>Score</th>
                <th>Commentaire</th>
            </tr>
            </thead>
        </table>
    </div>

@endsection

@section('scripts')
    @parent
    <script>
    $(document).ready(function() {
        players.initializeDataTables()
    } );
    </script>
@endsection
