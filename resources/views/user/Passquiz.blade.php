@extends('user.layouts.master')

@section('content')
<div class="container">
    <h3>{{$quiz->title}}</h3>
    <div class="row">
      <form action="{{route('user.quizzes.store')}}" method="POST">
        @csrf
        <input type="hidden" value="{{$quiz->id}}" name="QuizId">
        
        @foreach ($questions as $question)
            @switch($question->type_question)
                @case("multiple_choice")
                <h6>{{$question->content}}</h6>
                <input type="hidden" value="{{$question->id}}" name="QuestionId[]">
                  @foreach ($question->choices as $choice)
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="option[{{$question->id}}]" id="" required value="{{$choice->id}}">
                      <label class="form-check-label" for="flexRadioDefault1">
                        {{$choice->content}}
                      </label>
                    </div>
                  @endforeach
                    @break
                @case("multiple_answers")
                <h6>{{$question->content}}</h6>
                <input type="hidden" value="{{$question->id}}" name="QuestionId[]">
                @foreach ($question->choices as $choice)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{$choice->id}}" name="option[{{$question->id}}][{{$choice->id}}]" id=""  >
                    <label class="form-check-label" for="defaultCheck1">
                      {{$choice->content}}
                    </label>
                  </div>
                @endforeach
                    @break
                @case("boolean")
                <h6>{{$question->content}}</h6>
                <input type="hidden" value="{{$question->id}}" name="QuestionId[]">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="option[{{$question->id}}]" id="" value="true">
                    <label class="form-check-label" for="flexRadioDefault1">
                      True
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="option[{{$question->id}}]" id="" required value="false" >
                    <label class="form-check-label" for="flexRadioDefault2">
                      False
                    </label>
                  </div>
                  @break
                  @case("input")
                  <h6>{{$question->content}}</h6>
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
    </div>
  </div>

@endsection