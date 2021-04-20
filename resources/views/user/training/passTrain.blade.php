@extends('user.layouts.master2')

@section('pageTitle',"Entrainement ".$subject->title)



@section('content')

      <form action="{{route('user.Training.store')}}" method="POST">
        @csrf
        <input type="hidden" value="{{$subject->id}}" name="subject_id">
        <input type="hidden" value="{{$level->id}}" name="level_id">

        @foreach ([$questionsBeginner,$questionsIntermediate,$questionsAdvanced] as $questions)
            
        
          @foreach ($questions as $question)
              @switch($question->type_question)
                  @case("multiple_choice")
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h5 class="m-0">{{$question->content}}</h5>
                      <input type="hidden" value="{{$question->id}}" name="QuestionId[]">
                    </div>
                    <div class="card-body">
                      @if ($question->image_path )
                      <img src="{{$question->image_path  }}" class="img-fluid" >
                      @endif
                      
                      @foreach ($question->choices as $choice)
                      <div class="icheck-primary ">
                        <input type="radio" id="choice{{$choice->id}}" name="option[{{$question->id}}]" value="{{$choice->id}}" required>
                        <label for="choice{{$choice->id}}">
                          {{$choice->content}}
                        </label>
                      </div>
                    @endforeach
                    </div>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default{{$question->id}}">
                      Réponse & Explication
                    </button>
                    <div class="modal fade" id="modal-default{{$question->id}}" style="display: none;" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">{{$question->content}}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <ul>
                              <li><b>Réponse</b> : 
                                {{$question->correct[0]->content}}
                                </li>
                              @if($question->explication)
                              <li><b>Explication</b> : {{$question->explication}}</li>
                              @endif
                            </ul>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>            
                        </div>
                  
                      @break
                  @case("multiple_answers")
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h5 class="m-0">{{$question->content}}</h5>
                      <input type="hidden" value="{{$question->id}}" name="QuestionId[]">
                    </div>
                    <div class="card-body">
                      @if ($question->image_path )
                      <img src="{{$question->image_path  }}" class="img-fluid" >
                      @endif
                      
                      @foreach ($question->choices as $choice)
                      <div class="icheck-primary ">
                        <input type="checkbox" id="choice{{$choice->id}}" name="option[{{$question->id}}][{{$choice->id}}]" value="{{$choice->id}}" >
                        <label for="choice{{$choice->id}}">
                          {{$choice->content}}
                        </label>
                      </div>
                    @endforeach
                    </div>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default{{$question->id}}">
                      Réponse & Explication
                    </button>
                    <div class="modal fade" id="modal-default{{$question->id}}" style="display: none;" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">{{$question->content}}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <ul>
                              <li><b>Réponse</b> : 
                                @if($question->correct->count()>1)
                                <ol>
                                  @foreach ($question->correct as $item)
                                        <li>{{$item->content}}</li>
                                  @endforeach
                                </ol>
                                @else
                                {{$question->correct[0]->content}}
                                @endif
                                </li>
                              @if($question->explication)
                              <li><b>Explication</b> : {{$question->explication}}</li>
                              @endif
                            </ul>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div> 
                  </div>
                      @break
                  @case("boolean")

                    <div class="card card-primary card-outline">
                      <div class="card-header">
                        <h5 class="m-0">{{$question->content}}</h5>
                        <input type="hidden" value="{{$question->id}}" name="QuestionId[]">
                      </div>
                      <div class="card-body">
                        @if ($question->image_path )
                        <img src="{{$question->image_path  }}" class="img-fluid" >
                        @endif
                        
                        <div class="icheck-primary ">
                          <input type="radio" id="TrueChoice{{$question->id}}"  name="option[{{$question->id}}]" value="true" >
                          <label for="TrueChoice{{$question->id}}">
                            True
                          </label>
                        </div>
                        <div class="icheck-primary">
                          <input type="radio" id="FalseChoice{{$question->id}}"  name="option[{{$question->id}}]" value="false" required>
                          <label for="FalseChoice{{$question->id}}">
                            False
                          </label>
                        </div>
                      </div>
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default{{$question->id}}">
                        Réponse & Explication
                      </button>
                      <div class="modal fade" id="modal-default{{$question->id}}" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">{{$question->content}}</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <ul>
                                <li><b>Réponse</b> : 
                                  
                                  {{$question->correct}}
                                
                                  </li>
                                @if($question->explication)
                                <li><b>Explication</b> : {{$question->explication}}</li>
                                @endif
                              </ul>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                    </div>

                    @break
                    @case("input")
                    <h6>{{$question->content}}</h6>
                    <img src="{{$question->image_path  }}" class="img-fluid" >
                    <input type="hidden" value="{{$question->id}}" name="QuestionId[]">
                    <div class="form-check">
                      <textarea required class="form-check-textarea" cols="50" name="option[{{$question->id}}]" id=""></textarea>
                  </div>
                      @break
                  @default
                      <h3>not found</h3>
              @endswitch
          @endforeach
        @endforeach 
           <button class="btn btn-primary btn-block" type="submit">Submit</button>
      </form>

@endsection