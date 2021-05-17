@extends('user.layouts.master2')

@section('pageTitle','Tests')
    
@section('activeTests',"true")
    
@section('content')
<div class="container">
    <div class="row">
      @if (count($quizzes))
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Nom</th>
                <th scope="col">description</th>
                <th scope="col">Date & Heure</th>
                <th scope="col">durée (min)</th>
                <th scope="col">actions</th>
              </tr>
            </thead>
            <tbody>
              
              @foreach ($quizzes as $quiz)
                <tr>
                  <td>{{$quiz->title}}</td>
                  <td>
                    {{$quiz->description ?? '--'}}
                  </td>
                  <td>{{$quiz->pivot->created_at}}</td>
                  <td>
                    {{$quiz->duration}}
                  </td>
                  <td>
                      <a  class="btn btn-success btn-sm" href="{{route("user.quizzes.show",["quiz"=>$quiz->id])}}">Démarrer</a>
                  </td>
                </tr>
              @endforeach
              
              
              
            </tbody>
          </table>
          @else
          <div class="card card-secondary">
            <div class="card-header">
              <h4 class="card-title w-100">
                <a class="d-block w-100" data-toggle="collapse" >
                  pas de tests
                </a>
              </h4>
            </div>
          </div>
          @endif
    </div>
    <h3>Historique</h3>
    <div class="row">
      @if (count($quizzesPassed))
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Nom</th>
                <th scope="col">description</th>
                <th scope="col">Date & Heure</th>
                <th scope="col">Score %</th>
                <th scope="col">Note/20</th>
                <th scope="col">Etat</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($quizzesPassed as $quiz)
              <tr>
                <td>{{$quiz->title}}</td>
                <td>{{$quiz->description ?? "--" }}</td>
                <td>{{$quiz->pivot->updated_at}}</td>
                @if($quiz->pivot->isAdminCorrection)
                  <td>--</td>
                  <td>
                    <span class="badge rounded-pill bg-warning">en cours de correction</span>
                  </td>
                @else
                    <td>{{$quiz->pivot->score}} %</td>
                    <td>{{ number_format(($quiz->pivot->score*20)/100,2) }}</td>
                    @if($quiz->pivot->score>=70)
                      <td>
                          <span class="badge rounded-pill bg-success">réussi</span>
                      </td>
                    @else 
                      <td>
                        <span class="badge rounded-pill bg-danger">échoué</span>
                      </td>
                    @endif
                @endif
              </tr>
              @endforeach
            </tbody>
          </table>
          @else 
          <div class="card card-secondary">
            <div class="card-header">
              <h4 class="card-title w-100">
                <a class="d-block w-100" data-toggle="collapse" >
                  pas d'historique
                </a>
              </h4>
            </div>
          </div>
          @endif
    </div>
  </div>

@endsection