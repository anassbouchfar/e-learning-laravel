@extends('user.layouts.master2')

@section('pageTitle',"Résultat Entrainement $subject->title")
    
    

@section('content')
<div class="container">
    <div class="row">
    <div class="col-sm-12">
        <div class="position-relative p-3 bg-secondary" style="height: 180px">
            @if($scoreWithPercent<70)
            <div class="ribbon-wrapper ribbon-xl">
              <div class="ribbon bg-danger text-xl">
                Echoué
              </div>
            </div>
            @else 
            <div class="ribbon-wrapper ribbon-xl">
                <div class="ribbon bg-success text-xl">
                  Réussi
                </div>
            </div>
            @endif
            <ul>
                <li><b>Score</b> : {{$scoreWithPercent}}%</li>
                <li><b>questions Corrects   </b> : {{$score}}</li>
                <li><b>Total des questions </b>: {{$totalQuestions}}</li>
            </ul>
        </div>
        <a  href="/home" class="btn btn-primary btn-block"><i class="fa fa-arrow-left"></i> Acceuil</a>

    </div>

    </div>
  </div>

@endsection