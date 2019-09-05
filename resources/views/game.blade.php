@extends('layouts.app')

@section('title', 'Jeu')

@section('sidebar')
	@parent
@endsection

@section('content')
	<div class="row">
		<div class="col">
			<button type="button" class="btn btn-block btn-primary" id="mommand-lou">
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

	<div id="mommand-lou-form" title="Mommand'lou">
		<form>
			<div class="form-group">
				<label for="playerId">Identifiant du joueur</label>
				<input type="text" class="form-control" id="playerId" aria-describedby="playerIdHelp" placeholder="Entrez l'identifiant du joueur">
				<small id="playerIdHelp" class="form-text text-muted">Utilisez le bracelet du joueur.</small>
			</div>
			<div class="form-group">
				<label for="pointsGained">Points gagnés</label>
				<input type="text" class="form-control" id="pointsGained" placeholder="Points gagnés" aria-describedby="pointsGainedHelp">
				<small id="pointsGainedHelp" class="form-text text-muted">Entrez un nombre par ex. 35</small>
			</div>
		</form>
	</div>
@endsection

@section('scripts')
	@parent
	<script>
		game.bindButtons();
	</script>
@endsection