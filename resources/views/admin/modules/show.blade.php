@extends('admin.layouts.master')


@section('pageTitle',"Modules / $subject->title / Cours")

@section('content')
<a type="button" class="btn  btn-success mb-2" data-toggle="modal" data-target="#modal-new-course"><i class="fa fa-plus"></i> Ajouter</a>
<div class="modal fade" id="modal-new-course" style="display: none;" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ajouter un cours</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="{{route('admin.courses.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="subject_id" value="{{$subject->id}}">
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
                <label for="exampleInputFile">fichier cours (pdf) : 
                </label>
                <div class="input-group">
                  <div class="custom-file">
                    <input required accept="application/pdf" name="cours_pdf" type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                  </div>
                </div>
              </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
      @if(count($courses))

       
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Description</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($courses as $course)
            
            <tr>
              <a href="">
              <td>{{$course->title}}</td>
              <td>{{$course->description ?? '--'}} </td>
              <td>
                <a  class="btn btn-info btn-sm" href="/cours/{{$course->pdf_path}}" target="_blank"><i class="fas fa-file-pdf"></i></a> 
                <a  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modify-xl{{$course->id}}"><i class="fas fa-edit"></i></a>
                <a  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$course->id}}"><i class="fas fa-trash"></i></a>
              </td>
            </a>
            </tr>
            <div class="modal fade" id="modify-xl{{$course->id}}" style="display: none;" aria-hidden="true">
                <div class="modal-dialog ">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Modifer le cours {{$course->title}}</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <form action="{{route('admin.courses.update',['course'=>$course->id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Nom{{$course->id}}">Nom</label>
                            <input name="title" required type="text" class="form-control" id="Nom{{$course->id}}" placeholder="entrer Nom" value="{{$course->title}}">
                          </div>
                          <div class="form-group">
                            <label for="Description{{$course->id}}">Description</label>
                            <input name="Description"  type="text" class="form-control" id="Description{{$course->id}}" placeholder="entrer Description" value="{{$course->description}}">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputFile{{$course->id}}">Changer ce pdf : 
                                <a  class="btn btn-info btn-sm" href="/cours/{{$course->pdf_path}}" target="_blank"><i class="fas fa-file-pdf"></i></a> 
                            </label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input accept="application/pdf" name="cours_pdf" type="file" class="custom-file-input" id="exampleInputFile{{$course->id}}">
                                <label class="custom-file-label" for="exampleInputFile{{$course->id}}">Choose file</label>
                              </div>
                            </div>
                          </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>

              <div class="modal fade" id="delete{{$course->id}}" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content bg-danger">
                    <div class="modal-header">
                      <h4 class="modal-title"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>êtes-vous sûr de vouloir supprimer le cours {{$course->title}}</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
                      <form action="{{route("admin.courses.destroy",["course"=>$course->id])}}" method="POST">
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
           <h5>Aucun cours</h5>
       @endif 

@endsection