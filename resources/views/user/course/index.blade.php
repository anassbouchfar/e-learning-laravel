@extends('user.layouts.master')

@section('content')
<div class="container">
    <h2>Mes Cours</h2>
    <div class="row">
      @if(count($myCourses))
        @foreach ($myCourses as $mycourse)
          <div class="card m-3" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">$mycourse->title</h5>
              <p class="card-text">>$mycourse->description</p>
              <a href="{{route("user.cours.show",["course"=>$mycourse->id])}}" class="btn btn-primary">Accéder au cours</a>
            </div>
          </div>
        @endforeach
           
       @else
           <h5>Aucun cours</h5>
       @endif 
    </div>
    <h2>Autres Cours</h2>
    <div class="row">
      <div class="card m-3" style="width: 18rem;">
          <img src="..." class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
    </div>
  </div>

@endsection