@extends('admin.layouts.master')

@section('pageTitle',"Tests de $subject->title")
    
 @section('Headerscripts')
 @endsection   

@section('Footerscripts')

@endsection

@section('content')
<div class="container">
    <div class="row">
    
        <div class="col-md-2 m-2">
           
            <a type="button" class="btn  btn-success" data-toggle="modal" data-target="#modal-new-test"><i class="fa fa-plus"></i> Ajouter</a>
            <div class="modal fade" id="modal-new-test" style="display: none;" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Ajouter un nouveau Test</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <form action="{{route('admin.quizzes.store')}}" method="POST">
                      <input type="hidden" name="subject_id" value="{{$subject->id}}">
                      @csrf
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="Nom">Nom</label>
                          <input name="title" required type="text" class="form-control" id="Nom" placeholder="entrer Nom" >
                        </div>
                        <div class="form-group">
                          <label for="Description">Description</label>
                          <input name="Description"  type="text" class="form-control" id="Description" placeholder="entrer Description" >
                        </div>
                        <div class="form-group">
                            <label for="levels">Levels</label>
                            <select name="level_id" required class="custom-select form-control-border border-width-2" id="levels">
                                @foreach ($levels as $level)
                                <option value="{{$level->id}}">{{$level->name}}</option>
                                @endforeach
                            </select>
                          </div>

                   
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                  </div>
              </form>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
          </div>
      @if(count($quizzes))
        
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Description</th>
              <th>Level</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($quizzes as $quiz)
        
          <tr>
            <a href="">
            <td>{{$quiz->title}}</td>
            <td>{{$quiz->description}}</td>
            <td>{{$quiz->level}}</td>
            <td>
              <a  class="btn btn-info btn-sm" ><i class="nav-icon fas fa-book"></i></a>
              <a  class="btn btn-primary btn-sm" ><i class="fas fa-edit"></i></a>
              <a  class="btn btn-danger btn-sm" ><i class="fas fa-trash"></i></a>
              <a  type="button" class="btn btn-warning btn-sm"  data-toggle="modal" data-target="#uplodQuestions{{$quiz->id}}"><i class="fas fa-upload"></i> Questions</a>
              <div  class="modal fade" id="uplodQuestions{{$quiz->id}}" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Uploader des questions au {{$quiz->title}}</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <form action="{{route('admin.uploadQuestions')}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="quiz_id" value="{{$quiz->id}}">
                        @csrf
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="questionsFile">Upload (.xlsx,.csv)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                  <input required accept=".xlsx,.csv" name="questionsFile" type="file" class="custom-file-input" id="questionsFile">
                                  <label class="custom-file-label" for="questionsFile">Choose file</label>
                                </div>
                              </div>                          
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            </td>
          </a>
          </tr>
          @endforeach
          </tbody>
        </table>
       @else
           <h5>Aucun Test</h5>
       @endif 
    </div>
  </div>
  
@endsection