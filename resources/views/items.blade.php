@extends('layouts.app')

@section('title', 'Objets')

@section('sidebar')
	@parent
@endsection

@section('content')
    <div class="row">
        <h1>Objets</h1>
    </div>
	<div class="row">
        <table class="table table-striped" id="items">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th>Nom</th>
                <th>Points de découverte</th>
                <th>Points d'aventure</th>
                <th>Incrément du multiplicateur</th>
                <th>Découvert</th>
                <th>Aventure terminée</th>
            </tr>
            </thead>
        </table>
    </div>

@endsection

@section('scripts')
    @parent
    <script>
    $(document).ready(function() {
        $('#items').DataTable( {
            "ajax": "api/items?limit=1000",
            "columns": [
                { "data": "id"},
                { "data": "name" },
                { "data": "discovery_points" },
                { "data": "adventure_points" },
                { "data": "multiplier_increment"},
                { "data": "discovered" },
                { "data": "adventure_completed" }
            ]
        } );
    } );
    </script>
@endsection

