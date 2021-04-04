@extends('user.layouts.master')

@section('content')
<div class="container">
    <h2>Mes Cours</h2>
    <div class="row">
      @if(count($courses))
        @foreach ($courses as $course)
          <div class="card m-3" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">{{$course->title}}</h5>
              <p class="card-text">{{$course->description}}</p>
              @if($pivot=$course->pivot)
              <a href="{{route("user.cours.show",["cour"=>$course->id])}}" class="btn btn-primary">Continuer</a>
              <span>{{$pivot->progression}} %</span>
              @else
              <a href="{{route("user.cours.commencer",["course"=>$course->id])}}" class="btn btn-success">Commencer</a>
              @endif
            </div>
          </div>
        @endforeach
           
       @else
           <h5>Aucun cours</h5>
       @endif 
    </div>
  </div>

@endsection