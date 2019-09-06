@extends('layouts.app')

@section('title', 'Jeu')

@section('sidebar')
	@parent
@endsection

@section('content')
	<div class="row">
		<div class="col">
		<button
				type="button"
				class="btn btn-block btn-primary"
				data-toggle="modal"
				data-target="#mommandLouModal"
			>
				Entrer les points d'une partie de Momand'lou
			</button>
		</div>
		<div class="col">
			<button
				type="button"
				class="btn btn-block btn-primary"
				data-toggle="modal"
				data-target="#discoveredCertificateModal"
			>
				Enregistrer un certificat de découverte
			</button>
		</div>
		<div class="col">

		<button
				type="button"
				class="btn btn-block btn-primary"
				data-toggle="modal"
				data-target="#validateQuestModal"
			>
				Valider une quête
			</button>
		</div>
		<div class="col">
		<button
				type="button"
				class="btn btn-block btn-primary"
				data-toggle="modal"
				data-target="#levelUpModal"
			>
				Augmenter le niveau d'un joueur
			</button>
		</div>
	</div>

	<div class="row">
		<div class="col">
		<button
				type="button"
				class="btn btn-block btn-primary"
				data-toggle="modal"
				data-target="#registerBoatPieceModal"
			>
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
			<button
				type="button"
				class="btn btn-block btn-primary"
				data-toggle="modal"
				data-target="#enterBonusModal"
			>
				Enregistrer un bonus
			</button>
		</div>
		<div class="col">
		<button
				type="button"
				class="btn btn-block btn-primary"
				data-toggle="modal"
				data-target="#enterMalusModal"
			>
				Enregistrer un malus
			</button>
		</div>
		<div class="col">
		<button
				type="button"
				class="btn btn-block btn-primary"
				data-toggle="modal"
				data-target="#registerTreasureModal"
			>
				Enregistrer la découverte du trésor!
			</button>
		</div>
		<div class="col">
		</div>
	</div>

	<div class="modal fade" id="mommandLouModal" tabindex="-1" role="dialog" aria-labelledby="mommandLouLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="mommandLouLabel">Mommand'lou</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
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
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
					<button type="button" class="btn btn-primary">Valider</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	@parent
	<script>
		$(document).ready(() => {
			game.bindActions();
		})
	</script>
@endsection