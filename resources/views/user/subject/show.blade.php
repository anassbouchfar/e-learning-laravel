@extends('user.layouts.master2')


@section('pageTitle',"Modules / $subject->title")

@section('content')
      @if(count($courses))

       
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Description</th>
              <th>Progress</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($courses as $course)
            <tr>
              <a href="">
              <td>{{$course->title}}</td>
              <td>{{$course->description}}</td>
              <td>
                @if($pivot=$course->pivot)
                <div class="progress progress-xs">
                  <div class="progress-bar progress-bar-danger" style="width: {{$pivot->progression}}%"></div>
                </div>
                <span class="badge bg-danger">{{$pivot->progression}}%</span>
                @else
                No inscrit
                @endif
              </td>
              <td>
                <a target="_blank" href="/cours/{{$course->pdf_path}}" class="btn btn-info btn-sm"><i class="fas fa-file-pdf"></i></a>
                @if($pivot=$course->pivot)
                <a href="{{route("user.cours.show",["cour"=>$course->id])}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Continuer</a>
                @else
                <a href="{{route("user.cours.commencer",["course"=>$course->id])}}" class="btn btn-success btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Commencer</a>
                @endif

              </td>
            </a>
            </tr>
          @endforeach
          </tbody>
        </table>
           
       @else
           <h5>Aucun cours</h5>
       @endif 

@endsection