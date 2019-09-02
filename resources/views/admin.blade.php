<!DOCTYPE html>

@extends('layouts.app')

@section('title', 'Admin')

@section('sidebar')
	@parent
@endsection

@section('content')
	<div class="row">
        <div class="col">
            <button type="button" class="btn btn-block">
                Démarrer une phase de jeu
            </button>
        </div>
        <div class="col">
            <button type="button" class="btn btn-block">
                Terminer une phase de jeu
            </button>
        </div>

    </div>
    <div class="row">
        <div class="col">
            <button type="button" class="btn btn-block">
                Exporter classement global équipages
            </button>
        </div>
        <div class="col">
            <button type="button" class="btn btn-block">
                Exporter classement équipages par catégorie
            </button>
        </div>
        <div class="col">
            <button type="button" class="btn btn-block">
                Exporter classement joueurs
            </button>
        </div>
    </div>

@endsection
