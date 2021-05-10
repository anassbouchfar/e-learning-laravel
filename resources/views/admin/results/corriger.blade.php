@extends('admin.layouts.master')

@section('pageTitle',"Corriger les Tests")
    
 @section('Headerscripts')
 @endsection   



@section('content')
<div class="container">
    <div class="row">
    
      @if(count($quizzes))
        
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>User</th>
              <th>Test</th>
              <th>Score actuel</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($quizzes as $key => $quiz)
              @foreach ($quiz as $key1 => $item)
              
                <tr>
                  <td>{{$key}}</td>
                  <td>{{$key1}}</td>
                  <td>{{$item["score"]}} %</td>
                  <td>
                    
                    <a  type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#corriger{{str_replace(' ', '', $key.$key1)}}"><i class="fas fa-check"></i> Corriger</a>
                    <div  class="modal fade" id="corriger{{str_replace(' ', '', $key.$key1)}}" style="display: none;" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">corriger {{$key1}}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                          </div>
                          <form action="{{route('admin.CorrigerTestStore')}}" method="POST" >
                            <input type="hidden" name="user_id" value="{{$item["questions"][0]["user_id"]}}">
                            <input type="hidden" name="quiz_id" value="{{$item["questions"][0]["quiz_id"]}}">
                              @csrf
                              <div class="modal-body">
                                @foreach ($item["questions"] as $question)
                                  <input type="hidden" name="pendigQuestion[]" value="{{$question->id}}">
                                  <div class="form-group">
                                    <label>{{$question->content}}</label>
                                    <input  type="text" class="form-control" name="" disabled="" value="{{$question->user_response}}">
                                  </div>
                                  <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                      <input required type="radio" id="True{{$question->id}}" name="correctResponse[{{$question->question_id}}]" value="1">
                                      <label for="True{{$question->id}}">
                                        True
                                      </label>
                                    </div>
                                    <div class="icheck-primary d-inline">
                                      <input type="radio" id="False{{$question->id}}" name="correctResponse[{{$question->question_id}}]" value="0">
                                      <label for="False{{$question->id}}">
                                        False
                                      </label>
                                    </div>
                                  </div>
                                @endforeach
                                
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Corriger</button>
                          </div>
                      
                        </div>
                      </form>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                  </td>
                </tr>
                
              @endforeach
          @endforeach
          </tbody>
        </table>
       @else
           <h5>Aucun Test à corriger</h5>
       @endif 
    </div>
  </div>
  
@endsection

@section('Footerscripts')

@endsection