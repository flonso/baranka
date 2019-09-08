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

	@component('modals/mommand-lou-modal') @endcomponent
	@component('modals/discovered-item-modal') @endcomponent
@endsection

@section('scripts')
	@parent
	<script>
		$(document).ready(() => {
			game.bindActions();
		})
	</script>
@endsection