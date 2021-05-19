@extends('admin.layouts.master')

@section('pageTitle',"Users")
    
@section('activeUsers',"True")
    

@section('Headerscripts')
<link rel="stylesheet" href="/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/css/buttons.dataTables.min.css">
@endsection


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 m-2">
            <a type="button" class="btn  btn-success" data-toggle="modal" data-target="#affectTestParGroup"><i class="fas fa-edit"></i> Affecter un test par groupe</a>
            <div  class="modal fade" id="affectTestParGroup" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content ">
                    <div class="modal-header">
                      <h4 class="modal-title">affecter un test à un groupe</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <form action="{{route('admin.affectTestToGoupUsers')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="Tests">Tests</label>
                                <select name="test_id" required="" class="custom-select form-control-border border-width-2" id="Tests">
                                    @foreach ($tests as $test)
                                        <option value="{{$test->id}}">{{$test->title}}</option>
                                    @endforeach
                                </select>
                            </div>     
                            <div class="form-group clearfix">
                                <div class="icheck-success">
                                  <input type="checkbox"  id="po" name="PO" value="1">
                                    <label for="po">
                                        PO
                                      </label>
                                </div>
                                <div class="icheck-success">
                                  <input type="checkbox" id="cdb" name="CDB" value="2">
                                    <label for="cdb">
                                        CDB
                                      </label>
                                </div>
                                <div class="icheck-success">
                                  <input type="checkbox"  id="INST" name="INST" value="3">
                                  <label for="INST">
                                    INST
                                  </label>
                                </div>
                              </div>      
                        </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Annuler</button>
                      <button type="submit" class="btn btn-outline-dark">Affecter</button>
                    </div>
                    </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
    </div>    
      @if(count($users))
      <div class="row">
        <div class="col-md-12">
          <table class="table table-bordered responsive" id="usersTable" width="100%">
            <thead>
              <tr>
                <th>Nom</th>
                <th>cin</th>
                <th>Niveau</th>
                <th>Role</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
              @switch($user->grade)
                  @case("PO")
                          <tr style="background-color: antiquewhite">
                      @break
                  @case("INST")
                      <tr style="background-color: darkgrey">
                      @break
                  @case("CDB")
                      <tr style="background-color: darkorange">
                      @break
                  @default
                      <tr>
              @endswitch
            
              
                  @if($user->role=="admin")
                      
                  @else
                      
                  @endif
              <td>
                  @if($user->role=="admin")  
                      <b style="font-size: larger">#</b>
                  @endif
                  {{$user->name}}
              </td>
              <td>{{$user->cin}}</td>
              <td>{{$user->grade}}</td>
              <td>{{$user->role}}</td>
              <td style="background-color: white">
                  <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#affectTest{{$user->id}}"> <i class="fas fa-edit"></i> Affecter un Test</a>
                 
                  
                  <a type="button" class="btn btn-warning" data-toggle="modal" data-target="#resetPassword{{$user->id}}"> <i class="fas fa-key"></i> Reset Password</a>
                  <a  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$user->id}}"><i class="fas fa-trash"></i></a>
                  <div class="modal fade" id="delete{{$user->id}}" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content bg-danger">
                        <div class="modal-header">
                          <h4 class="modal-title"></h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>êtes-vous sûr de vouloir supprimer le module {{$user->name}}</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
                          <form action="{{route("admin.users.destroy",["user"=>$user->id])}}" method="POST">
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
              </td>
              <div  class="modal fade" id="affectTest{{$user->id}}" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content bg-primary">
                    <div class="modal-header">
                      <h4 class="modal-title">affecter un test à {{$user->name}}</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <form action="{{route('admin.affectTestToUser')}}" method="POST">
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="Tests{{$user->id}}">Tests</label>
                                <select name="test_id" required="" class="custom-select form-control-border border-width-2" id="Tests{{$user->id}}">
                                    @foreach ($tests as $test)
                                        <option value="{{$test->id}}">{{$test->title}}</option>
                                    @endforeach
                                </select>
                              </div>           
                        </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Annuler</button>
                      <button type="submit" class="btn btn-outline-dark">Valider</button>
                    </div>
                    </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
              <div  class="modal fade" id="resetPassword{{$user->id}}" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content bg-warning">
                    <div class="modal-header">
                      <h4 class="modal-title">Reset Password for {{$user->name}}</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <form action="{{route('admin.resetPasswordByAdmin')}}" method="POST">
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        @csrf
                        <div class="modal-body">
                            êtes-vous sûr de vouloir réinitialiser le mot de passe de {{$user->name}}            
                        </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Non</button>
                      <button type="submit" class="btn btn-outline-dark">Oui</button>
                    </div>
                </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            
              </div>
            </a>
           
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
        
       @else
           <h5>Aucun User</h5>
       @endif 
   
  </div>
  
@endsection

@section('Footerscripts')
  
<script src="/dashboard/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/js/dataTables.buttons.min.js"></script>
<script src="/js/jszip.min.js"></script>
<script src="/js/pdfmake.min.js"></script>
<script src="/js/vfs_fonts.js"></script>
<script src="/js/buttons.html5.min.js"></script>
<script src="/js/buttons.print.min.js"></script>





<script>
  $(function(){
    $('#usersTable').DataTable({
      responsive: true,
      dom: 'Bfrtip',
      buttons: [
           // 'copy', 'csv', 'excel', 'pdf', 'print'
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                }
            }
        ],
      "columnDefs": [
        {"className": "dt-center", "targets": "_all"}
      ],
    });
  })
/*
{
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
    }
*/
</script>
@endsection