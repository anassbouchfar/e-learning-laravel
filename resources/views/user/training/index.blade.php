@extends('user.layouts.master2')

@section('pageTitle',"Entrainement")
    
@section('EntrainementActive',"True")
    

@section('content')
<div class="container">
    <div class="row">
      @if(count($subjects))
        
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Description</th>
              <th>Type Entrainement</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($subjects as $subject)
        
          <tr>
            <a href="">
            <td>{{$subject->title}}</td>
            <td>{{$subject->description}}</td>
            <td>
              <div class="row">

              <div class="col-md-2">
                <form action="/trainingLevels" method="POST">
                  @csrf
                  <input type="hidden" name="subject_id" value="{{$subject->id}}">
                  <input type="hidden" name="level_id" value="1">
                  <button type="submit" class="btn btn-success btn-sm">beginner</button>
                </form>
            </div>
            <div class="col-md-3">
              <form action="/trainingLevels" method="POST">
                @csrf
                <input type="hidden" name="subject_id" value="{{$subject->id}}">
                <input type="hidden" name="level_id" value="2">
                <button type="submit" class="btn btn-primary btn-sm">intermediate</button>
              </form>
            </div>
            <div class="col-md-2">
              <form action="/trainingLevels" method="POST">
                @csrf
                <input type="hidden" name="subject_id" value="{{$subject->id}}">
                <input type="hidden" name="level_id" value="3">
                <button type="submit" class="btn btn-warning btn-sm">advanced</button>
              </form>
            </div>
            </div>
            </td>
          </a>
          </tr>
        
          @endforeach
          </tbody>
        </table>
       @else
           <h5>Aucun Module</h5>
       @endif 
@if(count($histoTrainings))
       <h3>Historique</h3>
       <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Type Entrainement</th>
            <th>Score</th>
            <th >Note/20</th>
            <th>Date & heure</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($histoTrainings as $training)
      
        <tr>
          <td>{{$training->subject_name}}</td>
          <td>
            @switch($training->level_id)
                @case(1)
                <button  class="btn btn-success btn-sm">{{$training->level_name}}</button>
                    @break
                @case(2)
                <button  class="btn btn-primary btn-sm">{{$training->level_name}}</button>
                    @break
                @case(3)
                <button  class="btn btn-warning btn-sm">{{$training->level_name}}</button>
                  @break
            @endswitch
          </td>
          <td>{{$training->score}} %</td>
          <td>{{ number_format(($training->score*20)/100,2) }}</td>
          <td>
            {{$training->created_at}}
          </td>
        </tr>
        @endforeach
        </tbody>
      </table>
      @endif
    </div>
  </div>

@endsection