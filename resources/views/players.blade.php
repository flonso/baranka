<!DOCTYPE html>

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
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
            </tr>
            </tbody>
        </table>
        @forelse ($players as $player)
            {{ $player->first_name }} {{ $player->last_name }}
        @empty
            <p>Pas de joueurs</p>
        @endforelse
    </div>

@endsection
