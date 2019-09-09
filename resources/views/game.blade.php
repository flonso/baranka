@extends('layouts.app')

@section('title', 'Jeu')

@section('sidebar')
	@parent
@endsection

@section('content')
	<div class="btn-group-vertical" role="group" aria-label="">

	</div>
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
				data-target="#discoveredItemModal"
			>
				Enregistrer un certificat de découverte
			</button>
		</div>
		<div class="col">
		<button
				type="button"
				class="btn btn-block btn-primary"
				data-toggle="modal"
				data-target="#questModal"
			>
				Entrer les points d'une quête
			</button>
		</div>
		<div class="col">
		<button
				type="button"
				class="btn btn-block btn-primary"
				data-toggle="modal"
				data-target="#levelUpPlayerModal"
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
				data-target="#discoveredBoatModal"
			>
				Enregistrer une pièce de bateau
			</button>
		</div>
		<div class="col">
			<button
				type="button"
				class="btn btn-block btn-primary"
				data-toggle="modal"
				data-target="#adventureCompletedModal"
			>
				Enregistrer un certificat d'acheminement
			</button>
		</div>
		<div class="col">
			<button
				type="button"
				class="btn btn-block btn-primary"
				data-toggle="modal"
				data-target="#registerPlayerModal"
			>
				Enregistrer le bracelet d'un joueur
			</button>
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
				data-target="#manualPointsModal"
			>
				Enregistrer un bonus/malus
			</button>
		</div>
		<div class="col">
			<button
				type="button"
				class="btn btn-block btn-primary"
				data-toggle="modal"
				data-target="#treasureModal"
			>
				Enregistrer la découverte du trésor!
			</button>
		</div>
		<div class="col">
		</div>
	</div>

	@component('modals/mommand-lou-modal') @endcomponent
	@component('modals/discovered-item-modal') @endcomponent
	@component('modals/manual-points-modal') @endcomponent
	@component('modals/discovered-item-modal') @endcomponent
	@component('modals/adventure-completed-modal') @endcomponent
	@component('modals/discovered-boat-modal') @endcomponent
	@component('modals/found-treasure-modal') @endcomponent
	@component('modals/levelup-player-modal') @endcomponent
	@component('modals/quest-modal') @endcomponent
	@component('modals/register-player-modal') @endcomponent
@endsection

@section('scripts')
	@parent
	<script>
		$(document).ready(() => {
			game.bindActions();
		})
	</script>
@endsection