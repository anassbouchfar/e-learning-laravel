@extends('user.layouts.master')

@section('content')
<div class="container">
    <h2>Modules : </h2>
    <div class="row">
      @if(count($subjects))
        @foreach ($subjects as $subject)
          <div class="card m-3" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">{{$subject->title}}</h5>
              <p class="card-text">{{$subject->description}}</p>
              <a href="{{route("user.modules.show",["module"=>$subject->id])}}" class="btn btn-primary">Accéder au module</a>
            </div>
          </div>
        @endforeach
           
       @else
           <h5>Aucun Module</h5>
       @endif 
    </div>
  </div>

@endsection