@extends('admin.layouts.master')

@section('pageTitle',"Modules")
    
@section('ModulesActive',"True")
    

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2 m-2">
            <a type="button" class="btn  btn-success" data-toggle="modal" data-target="#modal-new-module"><i class="fa fa-plus"></i> Ajouter</a>
            <div class="modal fade" id="modal-new-module" style="display: none;" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Ajouter un nouveau module</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <form action="{{route('admin.modules.store')}}" method="POST">
                      @csrf
                      <div class="modal-body">
                      <div class="form-group">
                          <label for="Nom">Nom</label>
                          <input name="title" required type="text" class="form-control" id="Nom{" placeholder="entrer Nom" >
                        </div>
                        <div class="form-group">
                          <label for="Description">Description</label>
                          <input name="Description" required type="text" class="form-control" id="Description" placeholder="entrer Description" >
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
      @if(count($subjects))
        
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Description</th>
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
              <a  class="btn btn-info btn-sm" href="{{route('admin.modules.show',['module'=>$subject->id])}}"><i class="nav-icon fas fa-book"></i></a>
              <a  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default{{$subject->id}}"><i class="fas fa-edit"></i></a>
              <a  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$subject->id}}"><i class="fas fa-trash"></i></a>
              <a  class="btn btn-warning btn-sm"  href="{{route('admin.testsByModule',['module'=>$subject->id])}}">Tests</a>
              <a  type="button" class="btn btn-warning btn-sm"  data-toggle="modal" data-target="#uplodQuestions{{$subject->id}}"><i class="fas fa-upload"></i> Questions Entrainement</a>
              <div  class="modal fade" id="uplodQuestions{{$subject->id}}" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Uploader des questions au {{$subject->title}}</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <form action="{{route('admin.uploadQuestionsEntrainement')}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="subject_id" value="{{$subject->id}}">
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
          <div class="modal fade" id="modal-default{{$subject->id}}" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Modifier {{$subject->title}}</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <form action="{{route('admin.modules.update',['module'=>$subject->id])}}" method="POST">
                    @csrf
                    @method("PUT")
                    <div class="modal-body">
                    <div class="form-group">
                        <label for="Nom{{$subject->id}}">Nom</label>
                        <input name="title" required type="text" class="form-control" id="Nom{{$subject->id}}" placeholder="entrer Nom" value="{{$subject->title}}">
                      </div>
                      <div class="form-group">
                        <label for="Description{{$subject->id}}">Description</label>
                        <input name="Description"  type="text" class="form-control" id="Description{{$subject->id}}" placeholder="entrer Description" value="{{$subject->description}}">
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

          <div class="modal fade" id="delete{{$subject->id}}" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content bg-danger">
                <div class="modal-header">
                  <h4 class="modal-title"></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>êtes-vous sûr de vouloir supprimer le module {{$subject->title}}</p>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
                  <form action="{{route("admin.modules.destroy",["module"=>$subject->id])}}" method="POST">
                    @csrf
                    @method("delete")
                    <button type="submit" class="btn btn-outline-light">Supprimer</button>
                  </form>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          @endforeach
          </tbody>
        </table>
       @else
           <h5>Aucun Module</h5>
       @endif 
    </div>
  </div>
  
@endsection