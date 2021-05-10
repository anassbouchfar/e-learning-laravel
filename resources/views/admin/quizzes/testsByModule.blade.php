@extends('admin.layouts.master')

@section('pageTitle',"Tests de $subject->title")
    
 @section('Headerscripts')
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
              <a  type="button" class="btn btn-warning btn-sm"   data-toggle="modal" data-target="#QWithImage{{$quiz->id}}"><i class="fas fa-plus"></i> Question</a>
              <div  class="modal fade" id="QWithImage{{$quiz->id}}" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Ajouter une question au {{$quiz->title}}</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <form action="{{route('admin.addQuestion')}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="quiz_id" value="{{$quiz->id}}">
                        @csrf
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="content{{$quiz->id}}">Contenu</label>
                            <input required type="text" class="form-control" name="content" id="content{{$quiz->id}}" placeholder="Enter content">
                          </div>
                          <div class="form-group">
                            <label for="questionImage{{$quiz->id}}">Image (jpeg,jpg,png)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                  <input  accept=".jpeg,.jpg,.png" name="questionImage" type="file" class="custom-file-input" id="questionImage{{$quiz->id}}">
                                  <label class="custom-file-label" for="questionImage{{$quiz->id}}">Choose Image</label>
                                </div>
                              </div>                          
                          </div>
                          <div class="form-group clearfix">
                            <div class="icheck-primary ">
                              <input type="radio" id="radioPrimary1{{$quiz->id}}" name="type_question"  value="1">
                              <label  for="radioPrimary1{{$quiz->id}}">
                                Multiple choix
                              </label>
                            </div>
                            <div class="icheck-primary ">
                              <input type="radio" id="radioPrimary2{{$quiz->id}}" name="type_question" value="2">
                              <label for="radioPrimary2{{$quiz->id}}">
                                Multiple réponses
                              </label>
                            </div>
                            <div class="icheck-primary ">
                              <input type="radio" id="radioPrimary3{{$quiz->id}}" name="type_question"  value="3">
                              <label for="radioPrimary3{{$quiz->id}}">
                                Booléenne
                              </label>
                            </div>
                            <div class="icheck-primary ">
                              <input type="radio" id="radioPrimary4{{$quiz->id}}" name="type_question"  value="4">
                              <label for="radioPrimary4{{$quiz->id}}">
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
                            <label for="questionsFile{{$quiz->id}}">Upload (.xlsx,.csv)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                  <input required accept=".xlsx,.csv" name="questionsFile" type="file" class="custom-file-input" id="questionsFile{{$quiz->id}}">
                                  <label class="custom-file-label" for="questionsFile{{$quiz->id}}">Choose file</label>
                                </div>
                              </div>                          
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
          @endforeach
          </tbody>
        </table>
       @else
           <h5>Aucun Test</h5>
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