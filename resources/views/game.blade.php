@extends('layouts.app')

@section('title', 'Jeu')

@section('sidebar')
	@parent
@endsection

@section('content')
		<div class="row">
			<div class="col-sm">
				<h3>Tableau de bord Arawak</h3>
			</div>
		</div>

		<div class="row">
			<div class="col-sm">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Mommand'lou et Quêtes</h5>
						<button
							type="button"
							class="btn btn-block btn-primary"
							data-toggle="modal"
							data-target="#mommandLouModal"
						>
							Entrer les points d'une partie de Mommand'lou
						</button>
						<button
							type="button"
							class="btn btn-block btn-primary"
							data-toggle="modal"
							data-target="#questModal"
						>
							Entrer les points d'une quête
						</button>
					</div>
				</div>
			</div>
			<div class="col-sm">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Objets et Pièces de bâteau</h5>
						<button
							type="button"
							class="btn btn-block btn-primary"
							data-toggle="modal"
							data-target="#discoveredBoatModal"
						>
							Enregistrer une pièce de bateau
						</button>
						<button
							type="button"
							class="btn btn-block btn-primary"
							data-toggle="modal"
							data-target="#adventureCompletedModal"
						>
							Enregistrer un certificat d'acheminement
						</button>
						<button
							type="button"
							class="btn btn-block btn-primary"
							data-toggle="modal"
							data-target="#discoveredItemModal"
						>
							Enregistrer un certificat de découverte
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="row"></div>

		<div class="row">
			<div class="col-sm">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Joueurs</h5>
						<button
							type="button"
							class="btn btn-block btn-primary"
							data-toggle="modal"
							data-target="#registerPlayerModal"
						>
							Enregistrer le bracelet d'un joueur
						</button>
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
			</div>
			<div class="col-sm">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Points manuels</h5>
						<button
							type="button"
							class="btn btn-block btn-primary"
							data-toggle="modal"
							data-target="#manualPointsModal"
						>
							Enregistrer un bonus/malus
						</button>
						<button
							type="button"
							class="btn btn-block btn-primary"
							data-toggle="modal"
							data-target="#treasureModal"
						>
							Enregistrer la découverte du trésor!
						</button>
					</div>
				</div>
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