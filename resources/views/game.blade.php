<!DOCTYPE html>

@extends('layouts.app')

@section('title', 'Jeu')

@section('sidebar')
	@parent
@endsection

@section('content')
	<div class="row">
		<div class="col">
			<button type="button" class="btn btn-block">
				Entrer les points d'une partie de Momand'lou
			</button>
		</div>
		<div class="col">
			<button type="button" class="btn btn-block">
				Enregistrer un certificat de découverte
			</button>
		</div>
		<div class="col">
			<button type="button" class="btn btn-block">
				Valider une quête
			</button>
		</div>
		<div class="col">
			<button type="button" class="btn btn-block">
				Augmenter le niveau d'un jour
			</button>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<button type="button" class="btn btn-block">
				Enregistrer une pièce de bateau
			</button>
		</div>
		<div class="col">
			<button type="button" class="btn btn-block">
				Enregistrer un certificat d'acheminement
			</button>
		</div>
		<div class="col">
		</div>
		<div class="col">
		</div>
	</div>
	<div class="row">
		<div class="col">
			<button type="button" class="btn btn-block">
				Enregistrer un bonus
			</button>
		</div>
		<div class="col">
			<button type="button" class="btn btn-block">
				Enregistrer un malus
			</button>
		</div>
		<div class="col">
			<button type="button" class="btn btn-block">
				Enregistrer la découverte du trésor!
			</button>
		</div>
	</div>
	
@endsection