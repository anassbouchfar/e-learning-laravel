@extends('user.layouts.master2')

@section('pageTitle',$quiz->title)



@section('content')

      <form action="{{route('user.quizzes.store')}}" method="POST">
        @csrf
        <input type="hidden" value="{{$quiz->id}}" name="QuizId">
        
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
         
           <button class="btn btn-success" type="submit">Submit</button>
      </form>

@endsection