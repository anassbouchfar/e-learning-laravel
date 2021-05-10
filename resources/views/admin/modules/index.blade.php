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
              <a  type="button" class="btn btn-warning btn-sm"   data-toggle="modal" data-target="#QWithImage{{$subject->id}}"><i class="fas fa-plus"></i> Question</a>
              <div  class="modal fade" id="QWithImage{{$subject->id}}" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Ajouter une question au {{$subject->title}}</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <form action="{{route('admin.addQuestion')}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="subject_id" value="{{$subject->id}}">
                        @csrf
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="content{{$subject->id}}">Contenu</label>
                            <input required type="text" class="form-control" name="content" id="content{{$subject->id}}" placeholder="Enter content">
                          </div>
                          <div class="form-group">
                            <label for="levels{{$subject->id}}">Niveau</label>
                            <select required name="level" class="custom-select form-control-border border-width-2" id="levels{{$subject->id}}">
                              <option value="1">Beginner</option>
                              <option value="2">Intermediate</option>
                              <option value="3">advanced</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="questionImage{{$subject->id}}">Image (jpeg,jpg,png)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                  <input  accept=".jpeg,.jpg,.png" name="questionImage" type="file" class="custom-file-input" id="questionImage{{$subject->id}}">
                                  <label class="custom-file-label" for="questionImage{{$subject->id}}">Choose Image</label>
                                </div>
                              </div>                          
                          </div>
                          <div class="form-group clearfix">
                            <div class="icheck-primary ">
                              <input type="radio" id="radioPrimary1{{$subject->id}}" name="type_question"  value="1">
                              <label  for="radioPrimary1{{$subject->id}}">
                                Multiple choix
                              </label>
                            </div>
                            <div class="icheck-primary ">
                              <input type="radio" id="radioPrimary2{{$subject->id}}" name="type_question" value="2">
                              <label for="radioPrimary2{{$subject->id}}">
                                Multiple réponses
                              </label>
                            </div>
                            <div class="icheck-primary ">
                              <input type="radio" id="radioPrimary3{{$subject->id}}" name="type_question"  value="3">
                              <label for="radioPrimary3{{$subject->id}}">
                                Booléenne
                              </label>
                            </div>
                            <div class="icheck-primary ">
                              <input type="radio" id="radioPrimary4{{$subject->id}}" name="type_question"  value="4">
                              <label for="radioPrimary4{{$subject->id}}">
                                Input
                              </label>
                            </div>
                          </div>


                          <div class="ResponsesContent">
                     
                          </div> 

                        

                          </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Close</button>
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

@section('Footerscripts')
<script>
  $(function(){
      $('.modal').on('hidden.bs.modal', function () {
        clear()
          });
      $(".closeModal").click(function(){
        clear()
      })
      function clear(){
        $(".ResponsesContent").html("")
            $("form").trigger("reset");
      }

          var bool =   ` <div class="form-group">
                                      <div class="form-check">
                                        <input required class="form-check-input" type="radio" name="choiceBool" value="1">
                                        <label class="form-check-label">True</label>
                                      </div>
                                      <div class="form-check">
                                        <input  class="form-check-input" type="radio" name="choiceBool" value="0">
                                        <label class="form-check-label">False</label>
                                      </div>
                                    </div>`
              var mc = `<div class="input-group m-1">
        <div class="input-group-prepend">
        <span class="input-group-text">
          <input required type="radio" name="TrueChoice" value="1">
        </span>
        </div>
        <input required type="text" class="form-control" name="choix[]"  placeholder="Choix 1">
        </div>

        <div class="input-group m-1">
        <div class="input-group-prepend">
        <span class="input-group-text">
          <input type="radio" name="TrueChoice" value="2">
        </span>
        </div>
        <input required type="text" class="form-control" name="choix[]"  placeholder="Choix 2">
        </div>

        <div class="input-group m-1">
        <div class="input-group-prepend">
        <span class="input-group-text">
          <input type="radio" name="TrueChoice" value="3">
        </span>
        </div>
        <input required type="text" class="form-control" name="choix[]"  placeholder="Choix 3">
        </div>

        <div class="input-group m-1">
        <div class="input-group-prepend">
        <span class="input-group-text">
          <input type="radio" name="TrueChoice" value="4">
        </span>
        </div>
        <input  type="text" class="form-control" name="choix[]"  placeholder="Choix 4">
        </div>`;

        var ma=`       <div class="input-group m-1">
                              <div class="input-group-prepend">
                              <span class="input-group-text">
                                <input type="checkbox" name="TrueChoice[]" value="1">
                              </span>
                              </div>
                              <input required type="text" class="form-control" name="choix[]"  placeholder="Choix 1">
                              </div>
                              
                              <div class="input-group m-1">
                              <div class="input-group-prepend">
                              <span class="input-group-text">
                                <input type="checkbox" name="TrueChoice[]" value="2">
                              </span>
                              </div>
                              <input required type="text" class="form-control" name="choix[]"  placeholder="Choix 2">
                              </div>
                              
                              <div class="input-group m-1">
                              <div class="input-group-prepend">
                              <span class="input-group-text">
                                <input type="checkbox" name="TrueChoice[]" value="3">
                              </span>
                              </div>
                              <input required type="text" class="form-control" name="choix[]"   placeholder="Choix 3">
                              </div>
                              
                              <div class="input-group m-1">
                              <div class="input-group-prepend">
                              <span class="input-group-text">
                                <input type="checkbox" name="TrueChoice[]" value="4">
                              </span>
                              </div>
                              <input  type="text" class="form-control" name="choix[]"  placeholder="Choix 4">
                              </div>
                              <div class="input-group m-1">
                                <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <input type="checkbox" name="TrueChoice[]" value="5">
                                </span>
                                </div>
                                <input  type="text" class="form-control" name="choix[]"  placeholder="Choix 5">
                                </div>
                                <div class="input-group m-1">
                                  <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <input type="checkbox" name="TrueChoice[]" value="6">
                                  </span>
                                  </div>
                                  <input  type="text" class="form-control" name="choix[]"  placeholder="Choix 6">
                                  </div>`;

            $('input[type=radio][name=type_question]').click(function() {
              
                switch(this.value){
                  case "1" :   
                      $(".ResponsesContent").html(mc)
                    break;
                  case "2" : 
                  $(".ResponsesContent").html(ma)
                    break;
                  case "3" : 
                  $(".ResponsesContent").html(bool)
                    break;

                    case "4" : 
                  $(".ResponsesContent").html("")
                    break; 
                }
                  
              })
            });
</script>
@endsection