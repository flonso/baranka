@extends('layouts.app')

@section('title', 'Admin - Login')

@section('sidebar')
	@parent
@endsection

@section('content')

  <form method="post" action="/admin">
    @csrf
    <div class="form-group">
      <label for="password">Mot de passe</label>
      <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" placeholder="Mot de passe">
    </div>
    <button type="submit" class="btn btn-primary">C'est parti moussaillon!</button>
  </form>
@endsection
