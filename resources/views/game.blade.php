@extends('layouts.app')

@section('title', 'Jeu')

@section('sidebar')
	@parent
@endsection

@section('content')
	<div class="row">
		<div class="col">
			<button type="button" class="btn btn-block btn-primary">
				Entrer les points d'une partie de Momand'lou
			</button>
		</div>
		<div class="col">
			<button type="button" class="btn btn-block btn-primary">
				Enregistrer un certificat de découverte
			</button>
		</div>
		<div class="col">
			<button type="button" class="btn btn-block btn-primary">
				Valider une quête
			</button>
		</div>
		<div class="col">
			<button type="button" class="btn btn-block btn-primary">
				Augmenter le niveau d'un joueur
			</button>
		</div>
	</div>

	<div class="row">
		<div class="col">
			<button type="button" class="btn btn-block btn-primary">
				Enregistrer une pièce de bateau
			</button>
		</div>
		<div class="col">
			<button type="button" class="btn btn-block btn-primary">
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
			<button type="button" class="btn btn-block btn-primary">
				Enregistrer un bonus
			</button>
		</div>
		<div class="col">
			<button type="button" class="btn btn-block btn-primary">
				Enregistrer un malus
			</button>
		</div>
		<div class="col">
			<button type="button" class="btn btn-block btn-primary">
				Enregistrer la découverte du trésor!
			</button>
		</div>
		<div class="col">
		</div>
	</div>

@endsection