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
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Score</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($players as $player)
                <tr>
                    <th scope="row">{{ $player->code ?? $player->id }}</th>
                    <td>{{ $player->first_name }}</td>
                    <td>{{ $player->last_name }}</td>
                    <td>{{ $player->score }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Il n'y a pas de joueurs</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection
