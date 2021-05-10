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
                    @if ($question->image_path)
                      <img src="/picturesTests/{{$question->image_path}}" class="img-fluid m-1 w-50 h-50" >
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
                    @if ($question->image_path)
                      <img src="/picturesTests/{{$question->image_path}}" class="img-fluid m-1 w-50 h-50" >
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
                      @if ($question->image_path)
                      <img src="/picturesTests/{{$question->image_path}}" class="img-fluid m-1 w-50 h-50" >
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
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h5 class="m-0">{{$question->content}}</h5>
                      <input type="hidden" value="{{$question->id}}" name="QuestionId[]">
                    </div>
                    <div class="card-body">
                      @if ($question->image_path)
                      <img src="/picturesTests/{{$question->image_path}}" class="img-fluid m-1 w-50 h-50" >
                      @endif
                      <div class="form-group">
                        <textarea  required name="option[{{$question->id}}]" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                      </div>
                    </div>
                  </div>
                    @break
                @default
                    <h3>not found</h3>
            @endswitch
        @endforeach
         
           <button class="btn btn-success btn-block" type="submit">Submit</button>
      </form>

@endsection