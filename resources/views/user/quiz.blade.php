@extends('user.layouts.master')

@section('content')
<div class="container">
    <h3>Vos Tests</h3>
    <div class="row">
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Nom</th>
                <th scope="col">description</th>
                <th scope="col">durée</th>
                <th scope="col">actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Math</td>
                <td>desc math</td>
                <td>2h</td>
                <td>
                    <a  class="btn btn-success btn-sm" href="{{route("user.quizzes.show",["quiz"=>1])}}">Démarrer</a>
                </td>
              </tr>
            </tbody>
          </table>
    </div>
    <h3>Historique</h3>
    <div class="row">
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Nom</th>
                <th scope="col">description</th>
                <th scope="col">Score</th>
                <th scope="col">Etat</th>
                <th scope="col">actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Anglais</td>
                <td>desc Anglais</td>
                <td>70%</td>
                <td>
                    <span class="badge rounded-pill bg-success">réussi</span>
                </td>
                <td>
                    <a  class="btn btn-outline-primary btn-sm" href="{{route("user.quizzes.show",["quiz"=>1])}}">view</a>
                </td>
              </tr>
            </tbody>
          </table>
    </div>
  </div>

@endsection