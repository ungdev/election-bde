@extends('layouts.election')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Deconnexion</div>
                <div class="panel-body"><p>Vous êtes bien déconnecté.</p>

                    <a class="btn btn-primary" style="float:right;margin:5px;" href="{{ url('/') }}">Voter avec un autre compte</a>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <p>Pour toute question ou remarque relative aux elections BDE, veuillez contacter l'arbitre : {{ config('election.referer.email') }}</p> 
        </div>
    </div>
</div>

<!-- Force EtuUTT logout -->
<IFRAME width=1 height=1 src=https://etu.utt.fr/user/logout scrolling=no frameborder=0></IFRAME>
@endsection
