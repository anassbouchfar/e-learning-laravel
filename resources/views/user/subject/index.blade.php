@extends('user.layouts.master2')

@section('pageTitle',"Modules")
    
@section('ModulesActive',"True")
    

@section('content')
<div class="container">
    <div class="row">
      
      @if(count($subjects))
        
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
            @foreach ($subjects as $subject)
        
          <tr>
            <a href="">
            <td>{{$subject->title}}</td>
            <td>{{$subject->description}}</td>
            <td>
              <div class="progress progress-xs">
                <div class="progress-bar progress-bar-danger" style="width: {{$subject->progression}}%"></div>
              </div>
              <span class="badge bg-danger">{{$subject->progression}}%</span>
            </td>
            <td>
              <a href="{{route("user.modules.show",["module"=>$subject->id])}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
            </td>
          </a>
          </tr>
        
          @endforeach
          </tbody>
        </table>
       @else
           <h5>Aucun Module</h5>
       @endif 
    </div>
  </div>

@endsection