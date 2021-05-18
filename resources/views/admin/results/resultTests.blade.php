@extends('admin.layouts.master')

@section('pageTitle','Resultat Tests')
    
@section('activeTests',"true")
    
@section('content')
<div class="container">
    <div class="row">
      @if (count($data))
        <table class="table">
            <thead>
              <tr>
                <th scope="col">User</th>  
                <th scope="col">Cin</th>  
                <th scope="col">Test</th>  
                <th scope="col">Date & Time</th>  
                <th scope="col">Score %</th>
                <th scope="col">Note/20</th>
                <th scope="col">Etat</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                
                    @if(count($item->quizzes)>1)
                        <TR>
                            <TD ROWSPAN="{{count($item->quizzes)}}">{{$item->name}}</TD> 
                            <TD ROWSPAN="{{count($item->quizzes)}}">{{$item->cin}}</TD> 
                                <TD>{{$item->quizzes[0]->title}}</TD>
                                <TD>{{$item->quizzes[0]->pivot->updated_at}}</TD>
                                @if($item->quizzes[0]->pivot->score!==null)
                                        @if($item->quizzes[0]->pivot->isAdminCorrection)
                                            <TD>
                                                --
                                            </TD>
                                            <TD>
                                                --
                                            </TD>
                                            <td>
                                                <span class="badge rounded-pill bg-info">en cours de correction</span>
                                            </td>
                                        @else
                                            <TD>
                                                {{$item->quizzes[0]->pivot->score}} %
                                            </TD>
                                            <td>{{ number_format(($item->quizzes[0]->pivot->score*20)/100,2) }}</td>
                                            @if($item->quizzes[0]->pivot->score>60)
                                                <TD>
                                                    <span class="badge rounded-pill bg-success">Réussi</span>
                                                </TD>
                                            @else 
                                                <TD>
                                                    <span class="badge rounded-pill bg-danger">Echoué</span>
                                                </TD>
                                            @endif
                                        @endif
                                @else 
                                    <TD>--</TD>
                                    <TD>--</TD>
                                    <TD>
                                        <span class="badge rounded-pill bg-warning">Not Passed</span>
                                    </TD>
                                @endif
                        </TR>
                        @for ($i = 1; $i < count($item->quizzes); $i++)
                            <tr>
                                <TD>{{$item->quizzes[$i]->title}}</TD>
                                <TD>{{$item->quizzes[$i]->pivot->updated_at}}</TD>
                                @if($item->quizzes[$i]->pivot->score!==null)
                                    @if($item->quizzes[0]->pivot->isAdminCorrection)
                                        <TD>
                                            --
                                        </TD>
                                        <TD>
                                            --
                                        </TD>
                                        <td>
                                            <span class="badge rounded-pill bg-info">en cours de correction</span>
                                        </td>
                                    @else
                                        <TD>{{$item->quizzes[$i]->pivot->score}} %</TD>
                                        <td>{{ number_format(($item->quizzes[$i]->pivot->score*20)/100,2) }}</td>

                                        @if($item->quizzes[$i]->pivot->score>60)
                                            <TD>
                                                <span class="badge rounded-pill bg-succes">Réussi</span>
                                            </TD>
                                        @else 
                                            <TD>
                                                <span class="badge rounded-pill bg-danger">Echoué</span>
                                            </TD>
                                        @endif
                                    @endif
                                   
                                @else 
                                    <TD>--</TD>
                                    <TD>--</TD>
                                    <TD>
                                        <span class="badge rounded-pill bg-warning">Not Passed</span>
                                    </TD>
                                @endif
                            </tr>
                        @endfor
                    @else 

                        <TR>
                            <TD>{{$item->name}}</TD> 
                            <TD>{{$item->cin}}</TD> 
                            <TD>{{$item->quizzes[0]->title}}</TD>
                            <TD>{{$item->quizzes[0]->pivot->updated_at}}</TD>
                            @if($item->quizzes[0]->pivot->score!==null)
                                @if($item->quizzes[0]->pivot->isAdminCorrection)
                                <TD>
                                   --
                                </TD>
                                <TD>
                                    --
                                 </TD>
                                <td>
                                    <span class="badge rounded-pill bg-info">en cours de correction</span>
                                </td>
                                @else   
                                    <TD>
                                        {{$item->quizzes[0]->pivot->score}} %
                                    </TD>
                                    <td>{{ number_format(($item->quizzes[0]->pivot->score*20)/100,2) }}</td>

                                    @if($item->quizzes[0]->pivot->score>60)
                                        <TD>
                                            <span class="badge rounded-pill bg-success">Réussi</span>
                                        </TD>
                                    @else 
                                        <TD>
                                            <span class="badge rounded-pill bg-danger">Echoué</span>
                                        </TD>
                                    @endif
                                @endif
                                
                            @else 
                                <TD>--</TD>
                                <TD>--</TD>
                                <TD>
                                    <span class="badge rounded-pill bg-warning">Not Passed</span>
                                </TD>
                            @endif
                        </TR>
                    @endif
                    
                @endforeach
                

                
                    
            </tbody>
          </table>
          @else 
          <div class="card card-secondary">
            <div class="card-header">
              <h4 class="card-title w-100">
                <a class="d-block w-100" data-toggle="collapse" >
                  pas de résultat
                </a>
              </h4>
            </div>
          </div>
          @endif
    </div>
  </div>

@endsection