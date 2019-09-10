<!DOCTYPE html>

@extends('layouts.app')

@section('title', 'Admin')

@section('sidebar')
	@parent
@endsection

@section('content')
    <div class="row">
        <div class="col-sm">
            <h3>Administration du jeu</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Phases de jeu</h5>
                    <button
                        type="button"
                        class="btn btn-block btn-primary"
                        id="startGamePhaseButton"
                        disabled
                    >
                        Démarrer une phase de jeu
                    </button>
                    <button
                        type="button"
                        class="btn btn-block btn-primary"
                        id="stopGamePhaseButton"
                        disabled
                    >
                        Terminer une phase de jeu
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="mx-auto">
            <h3 id="currentPhase"></h3>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            admin.bindAdminDashboard()
        });
    </script>

@endsection