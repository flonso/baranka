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
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th>Nom</th>
                <th>Points de découverte</th>
                <th>Points d'aventure</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($players as $player)
                <tr>
                    <th scope="row">
                    <td>{{ $player->name }}</td>
                    <td>{{ $player->discovery_points }}</td>
                    <td>{{ $player->adventure_points }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Il n'y a pas d'objets</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection
